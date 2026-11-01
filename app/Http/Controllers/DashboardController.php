<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = now()->toDateString();

        // 1. Total produk dan kategori
        $totalProducts = Product::count();
        $totalCategories = Category::count();

        // 2. Jumlah produk stok menipis (stock <= min_stock)
        // Menggunakan whereColumn untuk membandingkan dua kolom di tabel yang sama
        $lowStockCount = Product::whereColumn('stock', '<=', 'min_stock')->count();

        // 3. Jumlah transaksi hari ini
        $todayTransactions = StockTransaction::whereDate('transaction_date', $today)->count();

        // 4. 5 produk stok terendah (eager load category untuk menghindari N+1)
        $lowStockProducts = Product::with('category')
            ->whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        // 5. 5 transaksi terbaru (eager load product dan user)
        $latestTransactions = StockTransaction::with(['product', 'user'])
            ->latest('transaction_date')
            ->latest('id') // Secondary sort untuk tanggal yang sama
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalProducts',
            'totalCategories',
            'lowStockCount',
            'todayTransactions',
            'lowStockProducts',
            'latestTransactions'
        ));
    }
}