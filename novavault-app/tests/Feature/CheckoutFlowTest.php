<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\RewardRule;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutFlowTest extends TestCase
{
    use RefreshDatabase;

    protected User $patron;
    protected Vendor $vendor;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $vendorUser = User::factory()->create(['role' => 'vendor']);
        $this->vendor = Vendor::create([
            'user_id' => $vendorUser->id,
            'business_name' => 'Test Store',
            'slug' => 'test-store',
            'status' => 'approved',
        ]);

        $this->product = Product::create([
            'vendor_id' => $this->vendor->id,
            'title' => 'Widget',
            'price' => 25.00,
            'backstock_qty' => 10,
            'status' => 'active',
        ]);

        RewardRule::create([
            'vendor_id' => $this->vendor->id,
            'earn_rate' => 1.0,
            'multiplier' => 1.0,
            'active' => true,
        ]);

        $this->patron = User::factory()->create(['role' => 'patron']);
    }

    public function test_add_to_cart(): void
    {
        $response = $this->actingAs($this->patron)
            ->post(route('store.cart.add', [$this->vendor->slug, $this->product]));

        $response->assertRedirect();
        $response->assertSessionHas("cart.{$this->vendor->id}.{$this->product->id}", 1);
    }

    public function test_full_checkout_creates_order_and_awards_tokens(): void
    {
        // Add to cart
        $this->actingAs($this->patron)
            ->withSession(["cart.{$this->vendor->id}" => [$this->product->id => 2]])
            ->post(route('store.checkout', $this->vendor->slug));

        // Order created
        $order = Order::where('patron_id', $this->patron->id)->first();
        $this->assertNotNull($order);
        $this->assertEquals('50.00', $order->total);
        $this->assertEquals('paid', $order->status);
        $this->assertEquals(1, $order->items->count()); // 1 line item with qty=2

        // Stock decremented
        $this->product->refresh();
        $this->assertEquals(8, $this->product->backstock_qty);

        // Tokens awarded
        $wallet = Wallet::where('user_id', $this->patron->id)
            ->where('vendor_id', $this->vendor->id)
            ->first();
        $this->assertNotNull($wallet);
        $this->assertEquals('50.00000000', $wallet->balance);
    }

    public function test_checkout_fails_with_insufficient_stock(): void
    {
        $response = $this->actingAs($this->patron)
            ->withSession(["cart.{$this->vendor->id}" => [$this->product->id => 999]])
            ->post(route('store.checkout', $this->vendor->slug));

        $response->assertSessionHasErrors('cart');
        $this->assertDatabaseMissing('orders', ['patron_id' => $this->patron->id]);
    }

    public function test_storefront_only_shows_approved_vendors(): void
    {
        $this->get(route('store.show', $this->vendor->slug))->assertOk();

        $this->vendor->update(['status' => 'suspended']);
        $this->get(route('store.show', $this->vendor->slug))->assertNotFound();
    }
}
