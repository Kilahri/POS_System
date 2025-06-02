<?php
// app/Http/Controllers/FarewellMessageController.php

namespace App\Http\Controllers;

use App\Models\FarewellMessage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class FarewellMessageController extends Controller
{
    public function index(): JsonResponse
    {
        $messages = FarewellMessage::orderBy('usage_count', 'desc')->get();

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $farewellMessage = FarewellMessage::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Farewell message created successfully',
            'farewell_message' => $farewellMessage
        ], 201);
    }

    public function update(Request $request, FarewellMessage $farewellMessage): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:500',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $farewellMessage->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Farewell message updated successfully',
            'farewell_message' => $farewellMessage
        ]);
    }

    public function destroy(FarewellMessage $farewellMessage): JsonResponse
    {
        $farewellMessage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Farewell message deleted successfully'
        ]);
    }

    public function random(): JsonResponse
    {
        $message = FarewellMessage::where('is_active', true)
            ->inRandomOrder()
            ->first();

        if ($message) {
            $message->incrementUsage();
        }

        return response()->json([
            'success' => true,
            'message' => $message?->message ?? 'Thank you for your purchase!'
        ]);
    }
}