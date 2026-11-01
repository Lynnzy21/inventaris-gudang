@extends('layouts.app')

@section('title', 'Kategori')
@section('page-title', 'Daftar Kategori')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800">Kategori</h1>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('categories.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Tambah Kategori
            </a>
        @endif
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4 text-right">Jumlah Produk</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $category->name }}</td>
                            <td class="px-6 py-4">{{ $category->description ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800">
                                    {{ $category->products_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('categories.edit', $category) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Edit</a>
                                    <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline ml-3" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection