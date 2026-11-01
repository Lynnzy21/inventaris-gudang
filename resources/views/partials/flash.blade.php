{{-- Menampilkan pesan flash success dan error --}}
@if (session('success'))
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-800" role="alert">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
        {{ session('error') }}
    </div>
@endif