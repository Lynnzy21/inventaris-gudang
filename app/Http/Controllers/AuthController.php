<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    // Tampilkan halaman register
    public function showRegister(): View
    {
        return view('auth.register');
    }

    // Proses register
    public function register(RegisterRequest $request): RedirectResponse
    {
        // Buat user baru. Role selalu 'staff' (tidak dari request).
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'staff',
        ]);

        // Login otomatis setelah register
        Auth::login($user);
        session()->regenerate();

        return redirect()->intended('/dashboard')->with('success', 'Registrasi berhasil. Selamat datang!');
    }

    // Tampilkan halaman login
    public function showLogin(): View
    {
        return view('auth.login');
    }

    // Proses login
    public function login(LoginRequest $request): RedirectResponse
    {
        // Coba autentikasi
        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Login berhasil.');
        }

        // Pesan error umum (tidak membocorkan apakah email atau password yang salah)
        return back()->withErrors([
            'email' => 'Kredensial yang Anda masukkan tidak cocok dengan data kami.',
        ])->withInput($request->only('email'));
    }

    // Proses logout
        // Proses logout
    public function logout(Request $request): RedirectResponse // <-- Ganti LoginRequest menjadi Request
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}