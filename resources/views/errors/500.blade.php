@extends('layouts.error')
@section('title', '500 Server Error')
@section('content')
    <h1 class="text-6xl font-bold text-slate-800">500</h1>
    <p class="mt-4 text-xl font-semibold text-slate-600">Kesalahan Server</p>
    <p class="mt-2 text-sm text-slate-500">Terjadi masalah di server. Tim kami sedang memperbaikinya.</p>
    <a href="/dashboard" class="mt-6 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Ke Dashboard</a>
@endsection