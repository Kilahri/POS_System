<?php
// app/Http/Controllers/ReportController.php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\CustomerFeedback;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function dashboard(): JsonResponse
    {
        $today = now()->format('Y-m-d');
        $thisMonth = now()->format('Y-m');

        $todaySales = Transaction::whereDate('transaction_date', $today)
            ->sum('total_amount');

        $monthSales = Transaction::where('transaction_date', 'like', "$thisMonth%")
            ->sum('total_amount');

        $todayTransactions = Transaction::whereDate('transaction_date', $today)
            ->count();

        $lowStockCount = Product::whereRaw('stock_quantity <= min_stock_level')
            ->count();

        $averageRating = CustomerFeedback::avg('rating');

        return response()->json([
            'success' => true,
            'dashboard' => [
                'today_sales' => $todaySales,
                'month_sales' => $monthSales,
                'today_transactions' => $todayTransactions,
                'low_stock_count' => $lowStockCount,
                'average_rating' => round($averageRating, 2),
            ]
        ]);
    }

    public function salesReport(Request $request): JsonResponse
    {
        $dateFrom = $request->get('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $salesData = Transaction::whereBetween('transaction_date', [$dateFrom, $dateTo])
            ->selectRaw('DATE(transaction_date) as date, SUM(total_amount) as total_sales, COUNT(*) as transaction_count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totalSales = Transaction::whereBetween('transaction_date', [$dateFrom, $dateTo])
            ->sum('total_amount');

        $totalTransactions = Transaction::whereBetween('transaction_date', [$dateFrom, $dateTo])
            ->count();

        $averageTransaction = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;

        // Top selling products
        $topProducts = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->whereBetween('transactions.transaction_date', [$dateFrom, $dateTo])
            ->selectRaw('products.name, SUM(transaction_items.quantity) as total_quantity, SUM(transaction_items.total_price) as total_revenue')
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'report' => [
                'period' => ['from' => $dateFrom, 'to' => $dateTo],
                'summary' => [
                    'total_sales' => $totalSales,
                    'total_transactions' => $totalTransactions,
                    'average_transaction' => round($averageTransaction, 2),
                ],
                'daily_sales' => $salesData,
                'top_products' => $topProducts,
            ]
        ]);
    }

    public function inventoryReport(): JsonResponse
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $lowStockProducts = Product::whereRaw('stock_quantity <= min_stock_level')->count();
        
        $stockValue = Product::selectRaw('SUM(price * stock_quantity) as total_value')->first();
        
        $categoryStock = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('categories.name, COUNT(*) as product_count, SUM(products.stock_quantity) as total_stock')
            ->groupBy('categories.id', 'categories.name')
            ->get();

        $criticalStock = Product::whereRaw('stock_quantity <= min_stock_level')
            ->with('category')
            ->get();

        return response()->json([
            'success' => true,
            'report' => [
                'summary' => [
                    'total_products' => $totalProducts,
                    'active_products' => $activeProducts,
                    'low_stock_products' => $lowStockProducts,
                    'total_stock_value' => $stockValue->total_value,
                ],
                'category_breakdown' => $categoryStock,
                'critical_stock' => $criticalStock,
            ]
        ]);
    }

    public function feedbackReport(): JsonResponse
    {
        $totalFeedback = CustomerFeedback::count();
        $averageRating = CustomerFeedback::avg('rating');
        
        $ratingDistribution = CustomerFeedback::selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->orderBy('rating')
            ->get();

        $recentFeedback = CustomerFeedback::with('transaction')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Satisfaction trends over time
        $satisfactionTrends = CustomerFeedback::selectRaw('DATE(created_at) as date, AVG(rating) as avg_rating, COUNT(*) as feedback_count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Calculate improvement suggestions
        $lowRatingFeedback = CustomerFeedback::where('rating', '<=', 2)
            ->with('transaction')
            ->whereNotNull('comments')
            ->get();

        $suggestions = $this->generateImprovementSuggestions($ratingDistribution, $averageRating);

        return response()->json([
            'success' => true,
            'report' => [
                'summary' => [
                    'total_feedback' => $totalFeedback,
                    'average_rating' => round($averageRating, 2),
                ],
                'rating_distribution' => $ratingDistribution,
                'satisfaction_trends' => $satisfactionTrends,
                'recent_feedback' => $recentFeedback,
                'low_rating_feedback' => $lowRatingFeedback,
                'improvement_suggestions' => $suggestions,
            ]
        ]);
    }

    private function generateImprovementSuggestions($ratingDistribution, $averageRating): array
    {
        $suggestions = [];
        
        if ($averageRating < 3.0) {
            $suggestions[] = [
                'priority' => 'high',
                'category' => 'Service Quality',
                'suggestion' => 'Immediate attention required - Customer satisfaction is below acceptable levels. Consider staff training and service process review.',
            ];
        } elseif ($averageRating < 4.0) {
            $suggestions[] = [
                'priority' => 'medium',
                'category' => 'Service Improvement',
                'suggestion' => 'Good foundation but room for improvement. Focus on consistent service delivery and staff engagement.',
            ];
        }

        $lowRatings = $ratingDistribution->where('rating', '<=', 2)->sum('count');
        $totalRatings = $ratingDistribution->sum('count');
        
        if ($totalRatings > 0 && ($lowRatings / $totalRatings) > 0.2) {
            $suggestions[] = [
                'priority' => 'high',
                'category' => 'Customer Experience',
                'suggestion' => 'High percentage of low ratings detected. Investigate common issues and implement corrective measures.',
            ];
        }

        if (empty($suggestions)) {
            $suggestions[] = [
                'priority' => 'low',
                'category' => 'Maintenance',
                'suggestion' => 'Excellent customer satisfaction! Continue current practices and monitor for consistency.',
            ];
        }

        return $suggestions;
    }
}

{
    $days = $request->get('days', 30);
    
    $topProducts = DB::table('transaction_items')
        ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
        ->join('products', 'transaction_items.product_id', '=', 'products.id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->where('transactions.transaction_date', '>=', now()->subDays($days))
        ->selectRaw('
            products.id,
            products.name,
            categories.name as category_name,
            SUM(transaction_items.quantity) as total_sold,
            SUM(transaction_items.total_price) as total_revenue,
            AVG(transaction_items.unit_price) as avg_price
        ')
        ->groupBy('products.id', 'products.name', 'categories.name')
        ->orderBy('total_sold', 'desc')
        ->limit(20)
        ->get();

    return response()->json([
        'success' => true,
        'top_products' => $topProducts
    ]);
}

{
    $period = $request->get('period', 'daily'); // daily, weekly, monthly
    $days = $request->get('days', 30);
    
    $dateFormat = match($period) {
        'weekly' => '%Y-%u',
        'monthly' => '%Y-%m',
        default => '%Y-%m-%d'
    };
    
    $trends = Transaction::where('transaction_date', '>=', now()->subDays($days))
        ->selectRaw("
            DATE_FORMAT(transaction_date, '$dateFormat') as period,
            COUNT(*) as transaction_count,
            SUM(total_amount) as total_sales,
            AVG(total_amount) as avg_transaction,
            SUM(CASE WHEN payment_method = 'cash' THEN 1 ELSE 0 END) as cash_transactions,
            SUM(CASE WHEN payment_method = 'card' THEN 1 ELSE 0 END) as card_transactions,
            SUM(CASE WHEN payment_method = 'digital_wallet' THEN 1 ELSE 0 END) as digital_transactions
        ")
        ->groupBy('period')
        ->orderBy('period')
        ->get();

    return response()->json([
        'success' => true,
        'trends' => $trends,
        'period' => $period
    ]);
}

{
    // Customer segmentation based on purchase behavior
    $customerAnalysis = DB::table('transactions')
        ->selectRaw('
            customer_email,
            customer_name,
            COUNT(*) as visit_count,
            SUM(total_amount) as total_spent,
            AVG(total_amount) as avg_transaction,
            MAX(transaction_date) as last_visit,
            MIN(transaction_date) as first_visit
        ')
        ->whereNotNull('customer_email')
        ->groupBy('customer_email', 'customer_name')
        ->having('visit_count', '>', 1)
        ->orderBy('total_spent', 'desc')
        ->limit(50)
        ->get();

    // Purchase patterns
    $patterns = DB::table('transactions')
        ->selectRaw('
            HOUR(transaction_date) as hour,
            DAYNAME(transaction_date) as day_name,
            COUNT(*) as transaction_count,
            AVG(total_amount) as avg_amount
        ')
        ->where('transaction_date', '>=', now()->subDays(30))
        ->groupBy('hour', 'day_name')
        ->orderBy('transaction_count', 'desc')
        ->get();

    return response()->json([
        'success' => true,
        'customer_analysis' => $customerAnalysis,
        'purchase_patterns' => $patterns
    ]);
}


{
    $date = $request->get('date', now()->format('Y-m-d'));
    
    $hourlySales = Transaction::whereDate('transaction_date', $date)
        ->selectRaw('
            HOUR(transaction_date) as hour,
            COUNT(*) as transaction_count,
            SUM(total_amount) as total_sales,
            AVG(total_amount) as avg_transaction
        ')
        ->groupBy('hour')
        ->orderBy('hour')
        ->get();

    // Fill missing hours with zero values
    $completeHours = collect(range(0, 23))->map(function ($hour) use ($hourlySales) {
        $existing = $hourlySales->firstWhere('hour', $hour);
        return [
            'hour' => $hour,
            'transaction_count' => $existing ? $existing->transaction_count : 0,
            'total_sales' => $existing ? $existing->total_sales : 0,
            'avg_transaction' => $existing ? $existing->avg_transaction : 0,
        ];
    });

    return response()->json([
        'success' => true,
        'date' => $date,
        'hourly_sales' => $completeHours
    ]);
}


{
    $today = now()->format('Y-m-d');
    $yesterday = now()->subDay()->format('Y-m-d');
    
    $todayStats = Transaction::whereDate('transaction_date', $today)
        ->selectRaw('
            COUNT(*) as transactions,
            SUM(total_amount) as revenue,
            AVG(total_amount) as avg_transaction
        ')
        ->first();
    
    $yesterdayStats = Transaction::whereDate('transaction_date', $yesterday)
        ->selectRaw('
            COUNT(*) as transactions,
            SUM(total_amount) as revenue
        ')
        ->first();
    
    // Low stock alerts
    $lowStock = Product::whereRaw('stock_quantity <= min_stock_level')
        ->with('category')
        ->get();
    
    // Recent feedback
    $recentFeedback = CustomerFeedback::where('created_at', '>=', now()->subDays(1))
        ->with('transaction')
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'success' => true,
        'summary' => [
            'today' => $todayStats,
            'yesterday' => $yesterdayStats,
            'growth' => [
                'transactions' => $yesterdayStats->transactions > 0 
                    ? (($todayStats->transactions - $yesterdayStats->transactions) / $yesterdayStats->transactions) * 100 
                    : 0,
                'revenue' => $yesterdayStats->revenue > 0 
                    ? (($todayStats->revenue - $yesterdayStats->revenue) / $yesterdayStats->revenue) * 100 
                    : 0,
            ],
            'alerts' => [
                'low_stock_count' => $lowStock->count(),
                'low_stock_products' => $lowStock,
                'recent_feedback_count' => $recentFeedback->count(),
                'recent_feedback' => $recentFeedback,
            ]
        ]
    ]);
}