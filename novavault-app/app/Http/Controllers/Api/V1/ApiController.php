<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Wallet;
use App\Services\TokenEngine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    // ----- Merchant Profile -----

    public function vendorProfile(Request $request): JsonResponse
    {
        $vendor = $request->user()->vendor;
        if (!$vendor) return response()->json(['error' => 'Not a vendor'], 403);

        return response()->json($vendor->load('profile'));
    }

    // ----- Products -----

    public function products(Request $request): JsonResponse
    {
        $vendor = $request->user()->vendor;
        $products = $vendor->products()->with('category')->paginate(50);
        return response()->json($products);
    }

    public function storeProduct(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'sku' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'backstock_qty' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'in:active,inactive'],
        ]);

        $product = $request->user()->vendor->products()->create($validated);
        return response()->json($product, 201);
    }

    public function updateProduct(Request $request, Product $product): JsonResponse
    {
        if ($product->vendor_id !== $request->user()->vendor?->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'price' => ['sometimes', 'numeric', 'min:0.01'],
            'sku' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'backstock_qty' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'in:active,inactive'],
        ]);

        $product->update($validated);
        return response()->json($product);
    }

    public function deleteProduct(Request $request, Product $product): JsonResponse
    {
        if ($product->vendor_id !== $request->user()->vendor?->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $product->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // ----- Orders -----

    public function orders(Request $request): JsonResponse
    {
        $vendor = $request->user()->vendor;
        $orders = $vendor->orders()->with('patron', 'items.product')->latest()->paginate(50);
        return response()->json($orders);
    }

    public function orderDetail(Request $request, Order $order): JsonResponse
    {
        if ($order->vendor_id !== $request->user()->vendor?->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return response()->json($order->load('patron', 'items.product'));
    }

    // ----- Rewards / Wallets -----

    public function patronBalance(Request $request): JsonResponse
    {
        $wallets = $request->user()->wallets()->with('vendor')->get()
            ->map(fn ($w) => [
                'vendor' => $w->vendor->business_name,
                'vendor_id' => $w->vendor_id,
                'balance' => $w->balance,
                'tier' => $w->tier?->name,
            ]);

        return response()->json(['wallets' => $wallets]);
    }

    public function tokenActivity(Request $request): JsonResponse
    {
        $entries = $request->user()->wallets()
            ->join('token_ledger', 'wallets.id', '=', 'token_ledger.wallet_id')
            ->select('token_ledger.*', 'wallets.vendor_id')
            ->latest('token_ledger.created_at')
            ->paginate(50);

        return response()->json($entries);
    }
}
