@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="mb-4">
            <a href="{{ route('transactions.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">&larr; Kembali ke Riwayat</a>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-xl font-bold text-slate-800">Transaksi #{{ $transaction->id }}</h2>
                @if($transaction->type === 'in')
                    <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-sm font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Stok Masuk</span>
                @else
                    <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-sm font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Stok Keluar</span>
                @endif
            </div>

            <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-slate-500">Tanggal</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $transaction->transaction_date->format('d M Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Jumlah</dt>
                    <dd class="mt-1 text-sm font-bold text-slate-900">{{ $transaction->quantity }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Produk</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $transaction->product->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Kategori</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $transaction->product->category->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Dicatat oleh</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $transaction->user->name }}</dd>
                </div>
            </dl>

            @if($transaction->note)
                <div class="mt-6 border-t border-slate-200 pt-6">
                    <dt class="text-sm font-medium text-slate-500">Catatan</dt>
                    <dd class="mt-2 text-sm text-slate-700 whitespace-pre-wrap">{{ $transaction->note }}</dd>
                </div>
            @endif
        </div>
    </div>
@endsection