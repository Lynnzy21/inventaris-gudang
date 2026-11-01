@extends('layouts.auth')

@section('title', 'Login')
@section('auth-subtitle', 'Masuk ke akun Anda')

@section('content')
    <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <x-input name="email" label="Email" type="email" :value="old('email')" required />
        <x-input name="password" label="Password" type="password" required />

        <div class="mb-4 flex items-center">
            <input type="checkbox" name="remember" id="remember" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
            <label for="remember" class="ml-2 text-sm text-slate-600">Ingat saya</label>
        </div>

        <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Masuk
        </button>
    </form>

    <p class="mt-4 text-center text-sm text-slate-500">
        Belum punya akun? 
        <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Daftar di sini</a>
    </p>
@endsection