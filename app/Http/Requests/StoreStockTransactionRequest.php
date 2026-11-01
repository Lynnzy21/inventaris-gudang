<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id'       => ['required', 'exists:products,id'],
            'type'             => ['required', 'in:in,out'],
            'quantity'         => ['required', 'integer', 'min:1'],
            'transaction_date' => ['required', 'date'],
            'note'             => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required'       => 'Produk wajib dipilih.',
            'product_id.exists'         => 'Produk tidak ditemukan.',
            'type.required'             => 'Jenis transaksi wajib dipilih.',
            'type.in'                   => 'Jenis transaksi harus masuk atau keluar.',
            'quantity.required'         => 'Jumlah wajib diisi.',
            'quantity.integer'          => 'Jumlah harus berupa angka bulat.',
            'quantity.min'              => 'Jumlah minimal 1.',
            'transaction_date.required' => 'Tanggal transaksi wajib diisi.',
            'transaction_date.date'     => 'Format tanggal tidak valid.',
            'note.max'                  => 'Catatan maksimal 500 karakter.',
        ];
    }
}