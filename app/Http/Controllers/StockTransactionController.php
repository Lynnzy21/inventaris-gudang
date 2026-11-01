<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockTransactionRequest;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;


class StockTransactionController extends Controller
{
    public function index(): View
    {
        $type = request('type');
        $productId = request('product_id');
        $dateFrom = request('date_from');
        $dateTo = request('date_to');

        $transactions = StockTransaction::with(['product', 'user'])
            ->when($type, fn($q) => $q->where('type', $type))
            ->when($productId, fn($q) => $q->where('product_id', $productId))
            ->when($dateFrom, fn($q) => $q->whereDate('transaction_date', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->whereDate('transaction_date', '<=', $dateTo))
            ->latest('transaction_date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $products = Product::latest()->get();

        return view('transactions.index', compact('transactions', 'products', 'type', 'productId', 'dateFrom', 'dateTo'));
    }

    public function create(): View
    {
        $products = Product::with('category')->latest()->get();
        return view('transactions.create', compact('products'));
    }

    public function store(StoreStockTransactionRequest $request): RedirectResponse
    {
        // BR-03: Pemeriksaan stok dilakukan di dalam transaksi database dengan row lock
        try {
            DB::transaction(function () use ($request) {
                $product = Product::lockForUpdate()->findOrFail($request->product_id);

                if ($request->type === 'out' && $product->stock < $request->quantity) {
                    throw ValidationException::withMessages([
                        'quantity' => 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock,
                    ]);
                }

                StockTransaction::create([
                    'product_id'       => $request->product_id,
                    'user_id'          => auth()->id(), // BR-07: Mencatat siapa pelakunya
                    'type'             => $request->type,
                    'quantity'         => $request->quantity,
                    'note'             => $request->note,
                    'transaction_date' => $request->transaction_date,
                ]);

                // BR-01 & BR-02: Stok berubah otomatis berdasarkan transaksi
                $product->stock = $request->type === 'in' 
                    ? $product->stock + $request->quantity 
                    : $product->stock - $request->quantity;
                $product->save();
            });
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi stok berhasil dicatat.');
    }

    public function show(StockTransaction $transaction): View
    {
        $transaction->load(['product.category', 'user']);
        return view('transactions.show', compact('transaction'));
    }
}