@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Ringkasan Gudang</h1>
        <p class="text-sm text-slate-500">Pantau stok dan aktivitas terkini.</p>
    </div>

    {{-- Kartu Statistik --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat-card 
            title="Total Produk" 
            :value="$totalProducts" 
            color="indigo" 
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>' 
        />
        <x-stat-card 
            title="Total Kategori" 
            :value="$totalCategories" 
            color="green" 
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /></svg>' 
        />
        <x-stat-card 
            title="Stok Menipis" 
            :value="$lowStockCount" 
            color="yellow" 
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>' 
        />
        <x-stat-card 
            title="Transaksi Hari Ini" 
            :value="$todayTransactions" 
            color="red" 
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" /></svg>' 
        />
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Tabel Produk Stok Menipis --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-slate-800">Produk Stok Menipis</h3>
            @if($lowStockProducts->isEmpty())
                <p class="text-sm text-slate-500">Tidak ada produk dengan stok menipis.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase text-slate-500">
                            <tr>
                                <th class="px-4 py-3">Produk</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3 text-right">Stok</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($lowStockProducts as $product)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-slate-800">{{ $product->name }}</td>
                                    <td class="px-4 py-3">{{ $product->category->name }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <span class="inline-flex items-center rounded-full bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-700 ring-1 ring-inset ring-yellow-600/20">
                                            {{ $product->stock }} / {{ $product->min_stock }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Tabel Transaksi Terbaru --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-slate-800">Transaksi Terbaru</h3>
            @if($latestTransactions->isEmpty())
                <p class="text-sm text-slate-500">Belum ada transaksi tercatat.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase text-slate-500">
                            <tr>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Produk</th>
                                <th class="px-4 py-3">Jenis</th>
                                <th class="px-4 py-3 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($latestTransactions as $transaction)
                                <tr>
                                    <td class="px-4 py-3">{{ $transaction->transaction_date->format('d M Y') }}</td>
                                    <td class="px-4 py-3 font-medium text-slate-800">{{ $transaction->product->name }}</td>
                                    <td class="px-4 py-3">
                                        @if($transaction->type === 'in')
                                            <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Masuk</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Keluar</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right font-medium">{{ $transaction->quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection