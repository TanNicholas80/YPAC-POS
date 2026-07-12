<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display the reports page with insights.
     */
    public function index(Request $request)
    {
        // 1. Overall summary statistics (completed transactions only)
        $totalRevenue = Transaction::where('status', 'completed')->sum('total');
        $totalTransactions = Transaction::where('status', 'completed')->count();
        $totalItemsSold = TransactionDetails::whereHas('transaction', function($query) {
            $query->where('status', 'completed');
        })->sum('qty');

        // 2. Best Selling Products (Top 5)
        $bestSellers = TransactionDetails::select(
                'product_id', 
                DB::raw('SUM(qty) as total_sold'),
                DB::raw('SUM(subtotal) as total_revenue')
            )
            ->whereHas('transaction', function($query) {
                $query->where('status', 'completed');
            })
            ->whereHas('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with(['product.category', 'product.unit'])
            ->take(5)
            ->get();

        // Maximum sold quantity among top products (used for progress bar scaling)
        $maxSold = $bestSellers->max('total_sold') ?: 1;

        // 3. Low Stock Alert (Products with stock <= 10, ordered by stock ascending)
        $lowStockProducts = Product::where('is_active', true)
            ->where('stock', '<=', 10)
            ->with(['category', 'unit'])
            ->orderBy('stock', 'asc')
            ->take(10)
            ->get();

        // 4. Transaction History Table with filters & pagination (completed transactions only)
        $query = Transaction::with(['user', 'details.product.category', 'details.product.unit'])
            ->where('status', 'completed');

        // Filter: Start Date
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        // Filter: End Date
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter: Search Invoice
        if ($request->filled('search')) {
            $query->where('invoice_number', 'like', '%' . $request->search . '%');
        }

        $transactions = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('report.index', compact(
            'totalRevenue',
            'totalTransactions',
            'totalItemsSold',
            'bestSellers',
            'maxSold',
            'lowStockProducts',
            'transactions'
        ));
    }
}
