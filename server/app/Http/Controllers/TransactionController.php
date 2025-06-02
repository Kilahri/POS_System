<?php
// app/Http/Controllers/TransactionController.php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\FarewellMessage;
use App\Services\ReceiptService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    private ReceiptService $receiptService;

    public function __construct(ReceiptService $receiptService)
    {
        $this->receiptService = $receiptService;
    }

    public function index(Request $request): JsonResponse
    {
        $query = Transaction::with(['user', 'items.product']);

        if ($request->has('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->get('date_from'));
        }

        if ($request->has('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->get('date_to'));
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'transactions' => $transactions
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'discount_amount' => 'nullable|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,digital_wallet',
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Check stock availability
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                if ($product->stock_quantity < $item['quantity']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Insufficient stock for {$product->name}"
                    ], 400);
                }
            }

            // Calculate totals
            $subtotal = 0;
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $subtotal += $product->price * $item['quantity'];
            }

            $discountAmount = $request->discount_amount ?? 0;
            $taxAmount = ($subtotal - $discountAmount) * 0.1; // 10% tax
            $totalAmount = $subtotal - $discountAmount + $taxAmount;
            $changeAmount = $request->paid_amount - $totalAmount;

            // Create transaction
            $transaction = Transaction::create([
                'transaction_number' => 'TXN-' . strtoupper(Str::random(10)),
                'user_id' => auth()->id(),
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $changeAmount,
                'payment_method' => $request->payment_method,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'transaction_date' => now(),
            ]);

            // Create transaction items and update stock
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total_price' => $product->price * $item['quantity'],
                ]);

                $product->reduceStock($item['quantity']);
            }

            DB::commit();

            $transaction->load(['items.product', 'user']);

            // Get farewell message
            $farewellMessage = FarewellMessage::where('is_active', true)
                ->inRandomOrder()
                ->first();
            
            if ($farewellMessage) {
                $farewellMessage->incrementUsage();
            }

            // Send email receipt if customer email provided
            if ($request->customer_email) {
                $this->receiptService->sendEmailReceipt($transaction);
            }

            return response()->json([
                'success' => true,
                'message' => 'Transaction completed successfully',
                'transaction' => $transaction,
                'farewell_message' => $farewellMessage?->message,
                'print_receipt' => $this->receiptService->generatePrintReceipt($transaction)
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Transaction failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Transaction $transaction): JsonResponse
    {
        return response()->json([
            'success' => true,
            'transaction' => $transaction->load(['items.product', 'user', 'feedback'])
        ]);
    }

    public function printReceipt(Transaction $transaction): JsonResponse
    {
        $receipt = $this->receiptService->generatePrintReceipt($transaction);

        return response()->json([
            'success' => true,
            'receipt' => $receipt
        ]);
    }
}