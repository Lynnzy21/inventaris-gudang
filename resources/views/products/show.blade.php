@extends('layouts.app')

@section('title', 'Detail Produk')
@section('page-title', 'Detail Produk')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="mb-4">
            <a href="{{ route('products.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">&larr; Kembali ke Daftar Produk</a>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-6 flex items-start justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">{{ $product->name }}</h2>
                    <p class="text-sm text-slate-500">SKU: {{ $product->sku }}</p>
                </div>
                @if($product->stock <= $product->min_stock)
                    <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-sm font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Stok Menipis</span>
                @else
                    <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-sm font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Stok Aman</span>
                @endif
            </div>

            <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-slate-500">Kategori</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $product->category->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Satuan</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $product->unit }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Harga</dt>
                    <dd class="mt-1 text-sm text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Stok Saat Ini</dt>
                    <dd class="mt-1 text-sm font-bold text-slate-900">{{ $product->stock }} {{ $product->unit }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Stok Minimum</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $product->min_stock }} {{ $product->unit }}</dd>
                </div>
            </dl>

            @if($product->description)
                <div class="mt-6 border-t border-slate-200 pt-6">
                    <dt class="text-sm font-medium text-slate-500">Deskripsi</dt>
                    <dd class="mt-2 text-sm text-slate-700 whitespace-pre-wrap">{{ $product->description }}</dd>
                </div>
            @endif
        </div>
    </div>
@endsection