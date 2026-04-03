<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Vendor;
use App\Services\TokenEngine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Show cart contents.
     */
    public function cart(Request $request, Vendor $vendor): View
    {
        $cart = $request->session()->get("cart.{$vendor->id}", []);
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $items = [];
        $total = 0;
        foreach ($cart as $productId => $qty) {
            if ($products->has($productId)) {
                $product = $products[$productId];
                $lineTotal = bcmul((string) $product->price, (string) $qty, 2);
                $items[] = [
                    'product' => $product,
                    'qty' => $qty,
                    'line_total' => $lineTotal,
                ];
                $total = bcadd($total, $lineTotal, 2);
            }
        }

        return view('store.cart', compact('vendor', 'items', 'total'));
    }

    /**
     * Add product to cart.
     */
    public function addToCart(Request $request, Vendor $vendor, Product $product): RedirectResponse
    {
        $request->validate(['qty' => ['sometimes', 'integer', 'min:1', 'max:99']]);
        $qty = $request->input('qty', 1);

        $cart = $request->session()->get("cart.{$vendor->id}", []);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + $qty;
        $request->session()->put("cart.{$vendor->id}", $cart);

        return back()->with('status', "{$product->title} added to cart.");
    }

    /**
     * Remove product from cart.
     */
    public function removeFromCart(Request $request, Vendor $vendor, Product $product): RedirectResponse
    {
        $cart = $request->session()->get("cart.{$vendor->id}", []);
        unset($cart[$product->id]);
        $request->session()->put("cart.{$vendor->id}", $cart);

        return back()->with('status', 'Item removed.');
    }

    /**
     * Process checkout — creates order, decrements stock, awards tokens.
     *
     * NOTE: Stripe integration will be wired in separately.
     * This handles the post-payment order creation flow.
     */
    public function processOrder(Request $request, Vendor $vendor, TokenEngine $engine): RedirectResponse
    {
        $cart = $request->session()->get("cart.{$vendor->id}", []);

        if (empty($cart)) {
            return back()->withErrors(['cart' => 'Your cart is empty.']);
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        return DB::transaction(function () use ($request, $vendor, $cart, $products, $engine) {
            $total = 0;
            $orderItems = [];

            foreach ($cart as $productId => $qty) {
                if (! $products->has($productId)) {
                    continue;
                }

                $product = $products[$productId];

                if ($product->backstock_qty < $qty) {
                    return back()->withErrors(['cart' => "{$product->title} has insufficient stock."]);
                }

                $lineTotal = bcmul((string) $product->price, (string) $qty, 2);
                $total = bcadd($total, $lineTotal, 2);

                $orderItems[] = [
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'unit_price' => $product->price,
                    'line_total' => $lineTotal,
                ];

                $product->decrement('backstock_qty', $qty);
            }

            $order = Order::create([
                'vendor_id' => $vendor->id,
                'patron_id' => $request->user()?->id,
                'status' => 'paid', // Will be 'pending' when Stripe is wired
                'total' => $total,
                'source' => 'online',
            ]);

            $order->items()->createMany($orderItems);

            // Award tokens
            $engine->earnOnPurchase($order);

            // Clear cart
            $request->session()->forget("cart.{$vendor->id}");

            return redirect()->route('store.order-confirmation', [$vendor, $order])
                ->with('status', 'Order placed successfully!');
        });
    }

    /**
     * Order confirmation page.
     */
    public function confirmation(Vendor $vendor, Order $order): View
    {
        $order->load('items.product');

        return view('store.confirmation', compact('vendor', 'order'));
    }
}
