@extends('layouts.error')
@section('title', '403 Forbidden')
@section('content')
    <h1 class="text-6xl font-bold text-slate-800">403</h1>
    <p class="mt-4 text-xl font-semibold text-slate-600">Akses Ditolak</p>
    <p class="mt-2 text-sm text-slate-500">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
    <a href="{{ url()->previous() ?? '/dashboard' }}" class="mt-6 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Kembali</a>
@endsection