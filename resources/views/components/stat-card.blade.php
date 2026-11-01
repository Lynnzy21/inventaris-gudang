{{-- 
    Penggunaan: <x-stat-card title="Total Produk" value="150" icon="..." color="indigo" />
    Color options: indigo, green, yellow, red
--}}
@php
    $colors = [
        'indigo' => 'bg-indigo-50 text-indigo-600',
        'green'  => 'bg-green-50 text-green-600',
        'yellow' => 'bg-yellow-50 text-yellow-600',
        'red'    => 'bg-red-50 text-red-600',
    ];
    $bgClass = $colors[$color ?? 'indigo'];
@endphp

<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500">{{ $title }}</p>
            <p class="mt-2 text-3xl font-bold text-slate-800">{{ $value }}</p>
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-lg {{ $bgClass }}">
            {!! $icon !!}
        </div>
    </div>
</div>