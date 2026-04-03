<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\RewardRule;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Wallet;
use App\Services\TokenEngine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TokenEngineTest extends TestCase
{
    use RefreshDatabase;

    protected TokenEngine $engine;
    protected User $patron;
    protected Vendor $vendor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->engine = new TokenEngine();

        $vendorUser = User::factory()->create(['role' => 'vendor']);
        $this->vendor = Vendor::create([
            'user_id' => $vendorUser->id,
            'business_name' => 'Test Shop',
            'slug' => 'test-shop',
            'status' => 'approved',
        ]);

        $this->patron = User::factory()->create(['role' => 'patron']);
    }

    public function test_credit_creates_wallet_and_ledger_entry(): void
    {
        $entry = $this->engine->credit(
            userId: $this->patron->id,
            vendorId: $this->vendor->id,
            amount: '10.00000000',
            type: 'earn',
            memo: 'Test credit',
        );

        $this->assertNotNull($entry);
        $this->assertEquals('earn', $entry->type);

        $wallet = Wallet::where('user_id', $this->patron->id)
            ->where('vendor_id', $this->vendor->id)
            ->first();

        $this->assertNotNull($wallet);
        $this->assertEquals('10.00000000', $wallet->balance);
    }

    public function test_debit_reduces_balance(): void
    {
        // Setup: credit first
        $this->engine->credit(
            userId: $this->patron->id,
            vendorId: $this->vendor->id,
            amount: '50.00000000',
        );

        // Debit
        $entry = $this->engine->debit(
            userId: $this->patron->id,
            vendorId: $this->vendor->id,
            amount: '20.00000000',
            type: 'redeem',
        );

        $this->assertEquals('redeem', $entry->type);

        $wallet = Wallet::where('user_id', $this->patron->id)
            ->where('vendor_id', $this->vendor->id)
            ->first();

        $this->assertEquals('30.00000000', $wallet->balance);
    }

    public function test_debit_fails_on_insufficient_balance(): void
    {
        $this->engine->credit(
            userId: $this->patron->id,
            vendorId: $this->vendor->id,
            amount: '5.00000000',
        );

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Insufficient token balance');

        $this->engine->debit(
            userId: $this->patron->id,
            vendorId: $this->vendor->id,
            amount: '10.00000000',
        );
    }

    public function test_earn_on_purchase_awards_tokens(): void
    {
        RewardRule::create([
            'vendor_id' => $this->vendor->id,
            'earn_rate' => 1.0000,
            'min_purchase' => 0,
            'multiplier' => 1.00,
            'active' => true,
        ]);

        $order = Order::create([
            'vendor_id' => $this->vendor->id,
            'patron_id' => $this->patron->id,
            'status' => 'paid',
            'total' => 25.00,
            'source' => 'online',
        ]);

        $entry = $this->engine->earnOnPurchase($order);

        $this->assertNotNull($entry);
        $this->assertEquals('earn', $entry->type);
        $this->assertEquals('25.00000000', $entry->amount);

        $wallet = Wallet::where('user_id', $this->patron->id)
            ->where('vendor_id', $this->vendor->id)
            ->first();

        $this->assertEquals('25.00000000', $wallet->balance);
    }

    public function test_reverse_on_refund_deducts_earned_tokens(): void
    {
        RewardRule::create([
            'vendor_id' => $this->vendor->id,
            'earn_rate' => 1.0000,
            'min_purchase' => 0,
            'multiplier' => 1.00,
            'active' => true,
        ]);

        $order = Order::create([
            'vendor_id' => $this->vendor->id,
            'patron_id' => $this->patron->id,
            'status' => 'paid',
            'total' => 30.00,
            'source' => 'online',
        ]);

        $this->engine->earnOnPurchase($order);

        // Simulate refund
        $order->update(['status' => 'refunded']);
        $reversal = $this->engine->reverseOnRefund($order);

        $this->assertNotNull($reversal);
        $this->assertEquals('reverse', $reversal->type);

        $wallet = Wallet::where('user_id', $this->patron->id)
            ->where('vendor_id', $this->vendor->id)
            ->first();

        $this->assertEquals('0.00000000', $wallet->balance);
    }

    public function test_earn_returns_null_without_active_rule(): void
    {
        $order = Order::create([
            'vendor_id' => $this->vendor->id,
            'patron_id' => $this->patron->id,
            'status' => 'paid',
            'total' => 50.00,
            'source' => 'online',
        ]);

        $entry = $this->engine->earnOnPurchase($order);

        $this->assertNull($entry);
    }
}
