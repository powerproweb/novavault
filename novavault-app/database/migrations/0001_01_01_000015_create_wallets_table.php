<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cached balance per patron-vendor pair
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->decimal('balance', 18, 8)->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'vendor_id']);
        });

        // Append-only, immutable ledger — source of truth for all balance changes
        Schema::create('token_ledger', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['earn', 'redeem', 'reverse', 'adjust']);
            $table->decimal('amount', 18, 8);
            $table->string('reference_type')->nullable(); // e.g. 'order', 'redemption'
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('memo')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['wallet_id', 'type']);
            $table->index(['reference_type', 'reference_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('token_ledger');
        Schema::dropIfExists('wallets');
    }
};
