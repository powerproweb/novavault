<?php

namespace App\Console\Commands;

use App\Models\LoyaltyTier;
use App\Models\Wallet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class EvaluateTiers extends Command
{
    protected $signature = 'tiers:evaluate';
    protected $description = 'Evaluate and assign loyalty tiers for all patron wallets';

    public function handle(): int
    {
        // Get all vendors that have tiers configured
        $vendorIds = LoyaltyTier::distinct()->pluck('vendor_id');

        $updated = 0;

        foreach ($vendorIds as $vendorId) {
            $tiers = LoyaltyTier::where('vendor_id', $vendorId)
                ->orderByDesc('spend_threshold')
                ->get();

            if ($tiers->isEmpty()) continue;

            // Get cumulative spend per patron for this vendor
            $wallets = Wallet::where('vendor_id', $vendorId)->get();

            foreach ($wallets as $wallet) {
                $totalSpend = DB::table('orders')
                    ->where('vendor_id', $vendorId)
                    ->where('patron_id', $wallet->user_id)
                    ->where('status', 'paid')
                    ->sum('total');

                // Find highest qualifying tier
                $newTier = null;
                foreach ($tiers as $tier) {
                    if ($totalSpend >= $tier->spend_threshold) {
                        $newTier = $tier;
                        break;
                    }
                }

                $newTierId = $newTier?->id;

                if ($wallet->tier_id !== $newTierId) {
                    $wallet->update(['tier_id' => $newTierId]);
                    $updated++;
                }
            }
        }

        $this->info("Tier evaluation complete. {$updated} wallets updated.");

        return self::SUCCESS;
    }
}
