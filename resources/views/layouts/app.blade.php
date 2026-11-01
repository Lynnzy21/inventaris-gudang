<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Inventaris Gudang')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-700 antialiased">
    <div class="flex h-screen overflow-hidden">
        @include('partials.sidebar')

        <div class="flex flex-1 flex-col overflow-hidden">
            @include('partials.navbar')

            <main class="flex-1 overflow-y-auto p-4 lg:p-8">
                @include('partials.flash')
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>