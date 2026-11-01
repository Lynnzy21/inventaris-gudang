<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Error')</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-slate-50 font-sans text-slate-700 antialiased">
    <div class="flex min-h-screen flex-col items-center justify-center p-4 text-center">
        @yield('content')
    </div>
</body>
</html>