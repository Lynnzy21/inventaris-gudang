<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->string('sku', 100)->unique();
            $table->string('name');
            $table->string('description', 2000)->nullable();
            $table->string('unit', 50);
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('min_stock')->default(0);
            $table->timestamps();

            // Index untuk mempercepat pencarian nama produk
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};