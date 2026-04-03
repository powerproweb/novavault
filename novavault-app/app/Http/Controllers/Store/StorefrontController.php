<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    /**
     * Vendor store homepage.
     */
    public function show(Vendor $vendor): View
    {
        if ($vendor->status !== 'approved') {
            abort(404);
        }

        $products = $vendor->products()
            ->active()
            ->with('category')
            ->paginate(20);

        $categories = $vendor->categories;

        return view('store.show', compact('vendor', 'products', 'categories'));
    }

    /**
     * Product detail page.
     */
    public function product(Vendor $vendor, Product $product): View
    {
        if ($vendor->status !== 'approved' || $product->vendor_id !== $vendor->id) {
            abort(404);
        }

        $relatedProducts = $vendor->products()
            ->active()
            ->where('id', '!=', $product->id)
            ->when($product->category_id, fn ($q) => $q->where('category_id', $product->category_id))
            ->take(4)
            ->get();

        return view('store.product', compact('vendor', 'product', 'relatedProducts'));
    }

    /**
     * Filter products by category.
     */
    public function category(Vendor $vendor, string $categorySlug): View
    {
        if ($vendor->status !== 'approved') {
            abort(404);
        }

        $category = $vendor->categories()->where('slug', $categorySlug)->firstOrFail();

        $products = $vendor->products()
            ->active()
            ->where('category_id', $category->id)
            ->paginate(20);

        $categories = $vendor->categories;

        return view('store.show', compact('vendor', 'products', 'categories', 'category'));
    }
}
