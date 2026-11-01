<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => [
                'required',
                'string',
                'max:255',
                // Unique kecuali saat edit (abaikan ID kategori yang sedang diedit)
                'unique:categories,name,' . $this->route('category')?->id,
            ],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'   => 'Nama kategori wajib diisi.',
            'name.max'        => 'Nama kategori maksimal 255 karakter.',
            'name.unique'     => 'Nama kategori sudah digunakan.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
        ];
    }
}