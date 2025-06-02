<?php
// routes/api.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FarewellMessageController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/dashboard', [ProductController::class, 'dashboard']);
Route::post('/feedback', [FeedbackController::class, 'store']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/profile', [AuthController::class, 'profile']);

    // Product routes (all authenticated users)
    Route::middleware('auth:sanctum')->get('/product/{id}', function ($id) {
    return Product::findOrFail($id);
});

    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::get('/products/alerts/low-stock', [ProductController::class, 'lowStock']);

    // Category routes (all authenticated users)
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);

    // Transaction routes (all authenticated users)
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show']);
    Route::get('/transactions/{transaction}/print', [TransactionController::class, 'printReceipt']);

    // Farewell messages
    Route::get('/farewell-messages/random', [FarewellMessageController::class, 'random']);

    // Manager/Admin routes
    Route::middleware('role:manager,admin')->group(function () {
        // Product management
Route::get('/products', [ProductController::class, 'index']);

        Route::controller(ProductController::class)->group(function() {
            
            Route::post('/products', 'store');
            Route::get('/products/{id}', 'show');
            Route::put('/products/{id}', 'update');
            Route::delete('/products/{id}', 'destroy');
        });
        
        // Category management
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{category}', [CategoryController::class, 'update']);

        // Reports
        Route::get('/reports/dashboard', [ReportController::class, 'dashboard']);
        Route::get('/reports/sales', [ReportController::class, 'salesReport']);
        Route::get('/reports/inventory', [ReportController::class, 'inventoryReport']);
        Route::get('/reports/feedback', [ReportController::class, 'feedbackReport']);

        // Feedback management
        Route::get('/feedback', [FeedbackController::class, 'index']);
        Route::get('/feedback/{feedback}', [FeedbackController::class, 'show']);

        // Farewell messages management
        Route::get('/farewell-messages', [FarewellMessageController::class, 'index']);
        Route::post('/farewell-messages', [FarewellMessageController::class, 'store']);
        Route::put('/farewell-messages/{farewellMessage}', [FarewellMessageController::class, 'update']);
    });

    // Admin only routes
    Route::middleware('role:admin')->group(function () {
        // User management
        Route::post('/auth/register', [AuthController::class, 'register']);
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users/{user}', [UserController::class, 'show']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);

        // Product deletion
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);

        // Category deletion
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

        // Farewell message deletion
        Route::delete('/farewell-messages/{farewellMessage}', [FarewellMessageController::class, 'destroy']);
    });
});
// Additional API endpoints for enhanced functionality
// Add these to routes/api.php

// Enhanced reporting endpoints
Route::middleware(['auth:sanctum', 'role:manager,admin'])->group(function () {
    // Advanced analytics
    Route::get('/analytics/top-products', [ReportController::class, 'topProducts']);
    Route::get('/analytics/sales-trends', [ReportController::class, 'salesTrends']);
    Route::get('/analytics/customer-insights', [ReportController::class, 'customerInsights']);
    Route::get('/analytics/hourly-sales', [ReportController::class, 'hourlySales']);
    
    // Export functionality
    Route::get('/exports/sales-report', [ReportController::class, 'exportSales']);
    Route::get('/exports/inventory-report', [ReportController::class, 'exportInventory']);
    Route::get('/exports/transactions', [ReportController::class, 'exportTransactions']);
    
    // Bulk operations
    Route::post('/products/bulk-update', [ProductController::class, 'bulkUpdate']);
    Route::post('/products/bulk-price-update', [ProductController::class, 'bulkPriceUpdate']);
    
    // Notifications
    Route::get('/notifications/low-stock', [ProductController::class, 'lowStockNotifications']);
    Route::get('/notifications/daily-summary', [ReportController::class, 'dailySummary']);
});