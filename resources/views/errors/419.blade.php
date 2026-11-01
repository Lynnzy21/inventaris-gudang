@extends('layouts.error')
@section('title', '419 Page Expired')
@section('content')
    <h1 class="text-6xl font-bold text-slate-800">419</h1>
    <p class="mt-4 text-xl font-semibold text-slate-600">Sesi Berakhir</p>
    <p class="mt-2 text-sm text-slate-500">Token keamanan Anda telah kedaluwarsa. Silakan muat ulang halaman dan coba lagi.</p>
    <a href="{{ url()->previous() ?? '/login' }}" class="mt-6 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Muat Ulang</a>
@endsection