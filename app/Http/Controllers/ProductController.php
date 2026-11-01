<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $q = request('q');
        $categoryId = request('category_id');

        // Query dengan pencarian, filter kategori, dan paginasi
        $products = Product::with('category')
            ->when($q, fn($query) => $query->where(function($q2) use ($q) {
                $q2->where('name', 'like', "%{$q}%")
                   ->orWhere('sku', 'like', "%{$q}%");
            }))
            ->when($categoryId, fn($query) => $query->where('category_id', $categoryId))
            ->latest()
            ->paginate(10)
            ->withQueryString(); // Agar filter tetap terbawa saat pindah halaman

        $categories = Category::latest()->get();

        return view('products.index', compact('products', 'categories', 'q', 'categoryId'));
    }

    public function create(): View
    {
        $categories = Category::latest()->get();
        return view('products.create', compact('categories'));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        // Stok awal otomatis 0 (default di migration), tidak dari request
        Product::create($request->validated());
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product): View
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::latest()->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        // F-06 & BR-06: Produk yang sudah punya transaksi tidak boleh dihapus
        if ($product->stockTransactions()->count() > 0) {
            return back()->with('error', 'Produk tidak dapat dihapus karena sudah memiliki riwayat transaksi.');
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}