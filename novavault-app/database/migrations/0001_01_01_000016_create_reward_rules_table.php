<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reward_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->decimal('earn_rate', 8, 4)->default(1.0000); // tokens per dollar
            $table->decimal('min_purchase', 10, 2)->default(0);
            $table->decimal('multiplier', 5, 2)->default(1.00);
            $table->boolean('active')->default(true)->index();
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_until')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reward_rules');
    }
};
