<?php
// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::with('category');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->get('category_id'));
        }

        if ($request->has('low_stock') && $request->get('low_stock')) {
            $query->whereRaw('stock_quantity <= min_stock_level');
        }

        $products = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'min_stock_level' => $request->min_stock_level,
            'sku' => 'TEA-' . strtoupper(Str::random(8)),
            'category_id' => $request->category_id,
            'image' => $request->image,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'product' => $product->load('category')
        ], 201);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'success' => true,
            'product' => $product->load('category')
        ]);
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $product->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'product' => $product->load('category')
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    public function lowStock(): JsonResponse
    {
        $lowStockProducts = Product::whereRaw('stock_quantity <= min_stock_level')
            ->with('category')
            ->get();

        return response()->json([
            'success' => true,
            'products' => $lowStockProducts
        ]);
    }
}