<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->date('date')->index();
            $table->integer('transactions_count')->default(0);
            $table->decimal('revenue', 12, 2)->default(0);
            $table->decimal('tokens_issued', 18, 8)->default(0);
            $table->decimal('tokens_redeemed', 18, 8)->default(0);
            $table->integer('active_patrons')->default(0);
            $table->integer('new_patrons')->default(0);
            $table->integer('repeat_patrons')->default(0);
            $table->timestamps();

            $table->unique(['vendor_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_snapshots');
    }
};
