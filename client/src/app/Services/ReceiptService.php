<?php
// app/Services/ReceiptService.php

namespace App\Services;

use App\Models\Transaction;
use App\Models\FarewellMessage;
use App\Mail\ReceiptMail;
use Illuminate\Support\Facades\Mail;

class ReceiptService
{
    public function generatePrintReceipt(Transaction $transaction): array
    {
        $farewellMessage = FarewellMessage::where('is_active', true)
            ->inRandomOrder()
            ->first();

        return [
            'header' => [
                'business_name' => 'Possibilitea',
                'address' => '123 Tea Street, Tea City',
                'phone' => '+1-234-567-8900',
                'email' => 'info@possibilitea.com',
            ],
            'transaction' => [
                'number' => $transaction->transaction_number,
                'date' => $transaction->transaction_date->format('Y-m-d H:i:s'),
                'cashier' => $transaction->user->name,
                'customer' => $transaction->customer_name,
            ],
            'items' => $transaction->items->map(function ($item) {
                return [
                    'name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->unit_price,
                    'total' => $item->total_price,
                ];
            }),
            'totals' => [
                'subtotal' => $transaction->subtotal,
                'discount' => $transaction->discount_amount,
                'tax' => $transaction->tax_amount,
                'total' => $transaction->total_amount,
                'paid' => $transaction->paid_amount,
                'change' => $transaction->change_amount,
            ],
            'footer' => [
                'farewell_message' => $farewellMessage?->message ?? 'Thank you for your purchase!',
                'feedback_url' => config('app.url') . '/feedback/' . $transaction->id,
            ],
        ];
    }

    public function sendEmailReceipt(Transaction $transaction): void
    {
        if (!$transaction->customer_email) {
            return;
        }

        Mail::to($transaction->customer_email)->send(new ReceiptMail($transaction));
    }
}