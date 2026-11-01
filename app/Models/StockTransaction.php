<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockTransaction extends Model
{
    // PERHATIAN: 'user_id' TIDAK ada di sini. Diisi otomatis oleh server dari auth()->id().
    protected $fillable = [
        'product_id',
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