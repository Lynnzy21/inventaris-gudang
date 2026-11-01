<nav class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 lg:px-8">
    {{-- Tombol toggle sidebar untuk mobile --}}
    <button id="sidebar-toggle" type="button" class="text-slate-500 hover:text-slate-700 lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="h-6 w-6">
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
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="rounded-lg border border-red-200 px-3 py-1.5 text-sm font-medium text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                Logout
            </button>
        </form>
    </div>
</nav>
