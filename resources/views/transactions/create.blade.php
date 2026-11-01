@extends('layouts.app')

@section('title', 'Catat Transaksi')
@section('page-title', 'Catat Transaksi')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('transactions.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="product_id" class="mb-1 block text-sm font-medium text-slate-700">Produk <span class="text-red-500">*</span></label>
                    <select name="product_id" id="product_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">Pilih Produk</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }} ({{ $p->category->name }}) - Stok: {{ $p->stock }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="mb-1 block text-sm font-medium text-slate-700">Jenis Transaksi <span class="text-red-500">*</span></label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="type" value="in" {{ old('type') === 'in' ? 'checked' : '' }} class="h-4 w-4 border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm text-slate-700">Stok Masuk</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="type" value="out" {{ old('type') === 'out' ? 'checked' : '' }} class="h-4 w-4 border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm text-slate-700">Stok Keluar</span>
                        </label>
                    </div>
                    @error('type') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <x-input name="quantity" label="Jumlah" type="number" :value="old('quantity')" required />
                    <x-input name="transaction_date" label="Tanggal" type="date" :value="old('transaction_date', date('Y-m-d'))" required />
                </div>

                <div class="mb-4">
                    <label for="note" class="mb-1 block text-sm font-medium text-slate-700">Catatan</label>
                    <textarea name="note" id="note" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">{{ old('note') }}</textarea>
                    @error('note') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Simpan Transaksi</button>
                    <a href="{{ route('transactions.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection