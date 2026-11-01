{{-- 
    Penggunaan: <x-input name="email" label="Email" type="email" :value="old('email')" />
--}}
<div class="mb-4">
    <label for="{{ $name }}" class="mb-1 block text-sm font-medium text-slate-700">
        {{ $label }} @if(($required ?? false)) <span class="text-red-500">*</span> @endif
    </label>
    <input 
        type="{{ $type ?? 'text' }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        value="{{ $value ?? '' }}"
        {{ $attributes->merge(['class' => 'w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500']) }}
    >
    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>