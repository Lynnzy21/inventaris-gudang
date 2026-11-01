<nav class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 lg:px-8">
    {{-- Tombol toggle sidebar untuk mobile --}}
    <button id="sidebar-toggle" type="button" class="text-slate-500 hover:text-slate-700 lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>

    {{-- Judul halaman (diisi dari child view) --}}
    <div class="hidden lg:block">
        <h2 class="text-lg font-semibold text-slate-800">@yield('page-title', 'Dashboard')</h2>
    </div>

    {{-- Profil User & Logout --}}
    <div class="flex items-center gap-4">
        <div class="text-right">
            <p class="text-sm font-medium text-slate-700">{{ auth()->user()->name ?? 'Tamu' }}</p>
            <p class="text-xs text-slate-500 capitalize">{{ auth()->user()->role ?? 'guest' }}</p>
        </div>
        {{-- Form logout sementara (akan diaktifkan di Fase 3) --}}
        <form method="POST" action="/logout" class="hidden">
            @csrf
            <button type="submit" class="text-sm text-red-600 hover:text-red-800">Logout</button>
        </form>
    </div>
</nav>