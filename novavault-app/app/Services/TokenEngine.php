<?php

namespace App\Services;

use App\Models\Order;
use App\Models\RewardRule;
use App\Models\TokenLedger;
use App\Models\Vendor;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class TokenEngine
{
    /**
     * Award tokens to a patron after a successful purchase.
     *
     * All balance changes go through the ledger. The wallet balance
     * is always a cached derivation of ledger entries.
     */
    public function earnOnPurchase(Order $order): ?TokenLedger
    {
        if (! $order->patron_id || $order->status !== 'paid') {
            return null;
        }

        $rule = $this->getActiveRule($order->vendor_id, $order->total);

        if (! $rule) {
            return null;
        }

        $earnAmount = bcmul(
            bcmul((string) $order->total, (string) $rule->earn_rate, 8),
            (string) $rule->multiplier,
            8
        );

        if (bccomp($earnAmount, '0', 8) <= 0) {
            return null;
        }

        return $this->credit(
            userId: $order->patron_id,
            vendorId: $order->vendor_id,
            amount: $earnAmount,
            type: 'earn',
            referenceType: 'order',
            referenceId: $order->id,
            memo: "Earned on order #{$order->id}"
        );
    }

    /**
     * Reverse tokens when an order is refunded.
     */
    public function reverseOnRefund(Order $order): ?TokenLedger
    {
        if (! $order->patron_id) {
            return null;
        }

        // Find the original earn entry for this order
        $wallet = Wallet::where('user_id', $order->patron_id)
            ->where('vendor_id', $order->vendor_id)
            ->first();

        if (! $wallet) {
            return null;
        }

        $originalEarn = TokenLedger::where('wallet_id', $wallet->id)
            ->where('type', 'earn')
            ->where('reference_type', 'order')
            ->where('reference_id', $order->id)
            ->first();

        if (! $originalEarn) {
            return null;
        }

        return $this->debit(
            userId: $order->patron_id,
            vendorId: $order->vendor_id,
            amount: $originalEarn->amount,
            type: 'reverse',
            referenceType: 'order',
            referenceId: $order->id,
            memo: "Reversal for refunded order #{$order->id}"
        );
    }

    /**
     * Credit tokens to a wallet (earn, adjust).
     */
    public function credit(
        int $userId,
        int $vendorId,
        string $amount,
        string $type = 'earn',
        ?string $referenceType = null,
        ?int $referenceId = null,
        ?string $memo = null,
    ): TokenLedger {
        return DB::transaction(function () use ($userId, $vendorId, $amount, $type, $referenceType, $referenceId, $memo) {
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $userId, 'vendor_id' => $vendorId],
                ['balance' => 0]
            );

            $entry = TokenLedger::create([
                'wallet_id' => $wallet->id,
                'type' => $type,
                'amount' => $amount,
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
                'memo' => $memo,
            ]);

            $wallet->increment('balance', $amount);

            return $entry;
        });
    }

    /**
     * Debit tokens from a wallet (redeem, reverse).
     */
    public function debit(
        int $userId,
        int $vendorId,
        string $amount,
        string $type = 'redeem',
        ?string $referenceType = null,
        ?int $referenceId = null,
        ?string $memo = null,
    ): TokenLedger {
        return DB::transaction(function () use ($userId, $vendorId, $amount, $type, $referenceType, $referenceId, $memo) {
            $wallet = Wallet::where('user_id', $userId)
                ->where('vendor_id', $vendorId)
                ->lockForUpdate()
                ->firstOrFail();

            if (bccomp((string) $wallet->balance, (string) $amount, 8) < 0) {
                throw new \DomainException('Insufficient token balance.');
            }

            $entry = TokenLedger::create([
                'wallet_id' => $wallet->id,
                'type' => $type,
                'amount' => $amount,
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
                'memo' => $memo,
            ]);

            $wallet->decrement('balance', $amount);

            return $entry;
        });
    }

    /**
     * Get the active reward rule for a vendor, applicable to the given purchase amount.
     */
    protected function getActiveRule(int $vendorId, string|float $purchaseAmount): ?RewardRule
    {
        return RewardRule::where('vendor_id', $vendorId)
            ->where('active', true)
            ->where('min_purchase', '<=', $purchaseAmount)
            ->where(function ($q) {
                $q->whereNull('valid_from')->orWhere('valid_from', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
            })
            ->orderByDesc('min_purchase') // most specific rule wins
            ->first();
    }
}
