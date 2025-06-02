<?php
// app/Http/Controllers/FeedbackController.php

namespace App\Http\Controllers;

use App\Models\CustomerFeedback;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|exists:transactions,id',
            'rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:1000',
            'customer_email' => 'nullable|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if feedback already exists for this transaction
        $existingFeedback = CustomerFeedback::where('transaction_id', $request->transaction_id)->first();
        if ($existingFeedback) {
            return response()->json([
                'success' => false,
                'message' => 'Feedback already submitted for this transaction'
            ], 400);
        }

        $feedback = CustomerFeedback::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your feedback!',
            'feedback' => $feedback
        ], 201);
    }

    public function index(Request $request): JsonResponse
    {
        $query = CustomerFeedback::with('transaction');

        if ($request->has('rating')) {
            $query->where('rating', $request->get('rating'));
        }

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->get('date_from'));
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->get('date_to'));
        }

        $feedback = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'feedback' => $feedback
        ]);
    }

    public function show(CustomerFeedback $feedback): JsonResponse
    {
        return response()->json([
            'success' => true,
            'feedback' => $feedback->load('transaction')
        ]);
    }
}