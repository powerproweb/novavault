<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loyalty_tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // bronze, silver, gold, custom
            $table->decimal('spend_threshold', 12, 2)->default(0);
            $table->decimal('earn_multiplier', 5, 2)->default(1.00);
            $table->json('perks_json')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::table('wallets', function (Blueprint $table) {
            $table->foreignId('tier_id')->nullable()->after('balance')
                ->constrained('loyalty_tiers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tier_id');
        });
        Schema::dropIfExists('loyalty_tiers');
    }
};
