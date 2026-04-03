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
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('sku')->nullable()->index();
            $table->decimal('price', 10, 2);
            $table->integer('backstock_qty')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active')->index();
            $table->string('image_path')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('low_stock_threshold')->default(5);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
