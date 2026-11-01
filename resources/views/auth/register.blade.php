@extends('layouts.auth')

@section('title', 'Registrasi')
@section('auth-subtitle', 'Buat akun baru (peran: Staff)')

@section('content')
    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <x-input name="name" label="Nama Lengkap" :value="old('name')" required />
        <x-input name="email" label="Email" type="email" :value="old('email')" required />
        <x-input name="password" label="Password" type="password" required />
        <x-input name="password_confirmation" label="Konfirmasi Password" type="password" required />

        <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Daftar
        </button>
    </form>

    <p class="mt-4 text-center text-sm text-slate-500">
        Sudah punya akun? 
        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Masuk di sini</a>
    </p>
@endsection