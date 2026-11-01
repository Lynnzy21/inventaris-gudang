<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login - Sistem Inventaris')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-700 antialiased">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-indigo-600">Sistem Inventaris Gudang</h1>
                <p class="mt-2 text-sm text-slate-500">@yield('auth-subtitle', 'Silakan masuk ke akun Anda')</p>
            </div>
            
            <div class="rounded-xl bg-white p-8 shadow-sm">
                @include('partials.flash')
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>