<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'sku'         => [
                'required', 'string', 'max:100',
                'unique:products,sku,' . $this->route('product')?->id,
            ],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'unit'        => ['required', 'string', 'max:50'],
            'price'       => ['required', 'numeric', 'min:0'],
            'min_stock'   => ['required', 'integer', 'min:0'],
            // PERHATIAN: 'stock' TIDAK ada di sini (BR-01).
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori tidak ditemukan.',
            'sku.required'         => 'SKU wajib diisi.',
            'sku.unique'           => 'SKU sudah digunakan.',
            'name.required'        => 'Nama produk wajib diisi.',
            'unit.required'        => 'Satuan wajib diisi.',
            'price.required'       => 'Harga wajib diisi.',
            'price.numeric'        => 'Harga harus berupa angka.',
            'price.min'            => 'Harga tidak boleh negatif.',
            'min_stock.required'   => 'Stok minimum wajib diisi.',
            'min_stock.integer'    => 'Stok minimum harus berupa angka bulat.',
        ];
    }
}