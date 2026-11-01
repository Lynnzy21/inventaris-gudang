@extends('layouts.app')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('products.update', $product) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="category_id" class="mb-1 block text-sm font-medium text-slate-700">Kategori <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <x-input name="sku" label="SKU" :value="old('sku', $product->sku)" required />
                <x-input name="name" label="Nama Produk" :value="old('name', $product->name)" required />
                
                <div class="mb-4">
                    <label for="description" class="mb-1 block text-sm font-medium text-slate-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">{{ old('description', $product->description) }}</textarea>
                    @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <x-input name="unit" label="Satuan" :value="old('unit', $product->unit)" required />
                    <x-input name="price" label="Harga" type="number" :value="old('price', $product->price)" required />
                    <x-input name="min_stock" label="Stok Minimum" type="number" :value="old('min_stock', $product->min_stock)" required />
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Perbarui</button>
                    <a href="{{ route('products.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection