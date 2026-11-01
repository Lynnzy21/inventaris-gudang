<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockTransaction extends Model
{
    // Tambahkan 'user_id' agar bisa diisi oleh controller lewat method create()
    protected $fillable = [
        'product_id',
        'user_id',       // <-- TAMBAHKAN INI
        'type',
        'quantity',
        'note',
        'transaction_date',
    ];

    protected $casts = [
        'quantity'         => 'integer',
        'transaction_date' => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}