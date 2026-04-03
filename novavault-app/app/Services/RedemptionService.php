<?php

namespace App\Services;

use App\Models\Redemption;
use App\Models\Vendor;
use App\Models\Wallet;
use Illuminate\Support\Str;

class RedemptionService
{
    public function __construct(
        protected TokenEngine $tokenEngine,
    ) {}

    /**
     * Execute a redemption with anti-abuse checks.
     *
     * @throws \DomainException
     */
    public function redeem(
        int $patronId,
        int $vendorId,
        string $amount,
        string $rewardType,
        ?array $rewardDetail = null,
    ): Redemption {
        // Anti-abuse: rate limit — max 5 redemptions per patron per vendor per hour
        $recentCount = Redemption::where('patron_id', $patronId)
            ->where('vendor_id', $vendorId)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($recentCount >= 5) {
            throw new \DomainException('Too many redemptions. Please wait before trying again.');
        }

        // Anti-abuse: minimum balance check — must retain at least 0 after redemption
        $wallet = Wallet::where('user_id', $patronId)
            ->where('vendor_id', $vendorId)
            ->first();

        if (! $wallet || bccomp((string) $wallet->balance, $amount, 8) < 0) {
            throw new \DomainException('Insufficient token balance.');
        }

        // Execute debit through the ledger
        $entry = $this->tokenEngine->debit(
            userId: $patronId,
            vendorId: $vendorId,
            amount: $amount,
            type: 'redeem',
            referenceType: 'redemption',
            memo: "Redeemed: {$rewardType}",
        );

        // Create redemption record
        $redemption = Redemption::create([
            'wallet_id' => $entry->wallet_id,
            'patron_id' => $patronId,
            'vendor_id' => $vendorId,
            'amount' => $amount,
            'reward_type' => $rewardType,
            'reward_detail_json' => $rewardDetail,
            'status' => 'completed',
            'confirmation_code' => strtoupper(Str::random(8)),
        ]);

        // Link ledger entry
        $entry->update([
            'reference_type' => 'redemption',
            'reference_id' => $redemption->id,
        ]);

        return $redemption;
    }
}
