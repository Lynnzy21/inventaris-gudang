<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    // PERHATIAN: 'stock' TIDAK ada di sini. Stok hanya diubah lewat transaksi (BR-01).
    protected $fillable = [
        'category_id',
        'sku',
        'name',
        'description',
        'unit',
        'price',
        'min_stock',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'stock'     => 'integer',
        'min_stock' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function stockTransactions(): HasMany
    {
        return $this->hasMany(StockTransaction::class);
    }
}