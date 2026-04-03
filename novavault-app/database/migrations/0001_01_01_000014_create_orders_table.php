<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patron_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['pending', 'paid', 'refunded', 'cancelled'])->default('pending')->index();
            $table->decimal('total', 10, 2);
            $table->string('payment_intent_id')->nullable()->unique();
            $table->enum('source', ['pos', 'online'])->default('online');
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->integer('qty');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('line_total', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
