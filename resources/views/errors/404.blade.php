@extends('layouts.error')
@section('title', '404 Not Found')
@section('content')
    <h1 class="text-6xl font-bold text-slate-800">404</h1>
    <p class="mt-4 text-xl font-semibold text-slate-600">Halaman Tidak Ditemukan</p>
    <p class="mt-2 text-sm text-slate-500">URL yang Anda tuju tidak ada atau telah dipindahkan.</p>
    <a href="/dashboard" class="mt-6 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Ke Dashboard</a>
@endsection