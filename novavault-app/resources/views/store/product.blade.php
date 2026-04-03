<x-app-layout>
    <div class="py-8 max-w-5xl mx-auto px-4">
        <a href="{{ route('store.show', $vendor->slug) }}" class="text-nv-blue text-sm hover:underline">&larr; Back to {{ $vendor->business_name }}</a>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                @if($product->image_path)
                    <img src="{{ Storage::url($product->image_path) }}" class="w-full rounded-nv" alt="{{ $product->title }}">
                @else
                    <div class="w-full h-80 bg-navy-800 rounded-nv flex items-center justify-center text-gray-600">No Image</div>
                @endif
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white">{{ $product->title }}</h1>
                <div class="text-3xl font-bold text-gold mt-2">${{ number_format($product->price, 2) }}</div>
                @if($product->category)<div class="text-sm text-gray-400 mt-1">{{ $product->category->name }}</div>@endif
                <p class="mt-4 text-gray-300">{{ $product->description }}</p>
                <div class="mt-2 text-sm text-gray-400">Stock: {{ $product->backstock_qty > 0 ? $product->backstock_qty . ' available' : 'Out of stock' }}</div>

                @if($product->backstock_qty > 0)
                    <form method="POST" action="{{ route('store.cart.add', [$vendor->slug, $product]) }}" class="mt-6 flex gap-3 items-end">
                        @csrf
                        <div>
                            <label for="qty" class="text-sm text-gray-400">Qty</label>
                            <input id="qty" name="qty" type="number" min="1" max="{{ $product->backstock_qty }}" value="1" class="w-20 mt-1 rounded-nv-sm bg-navy-800 border-stroke text-white">
                        </div>
                        <button class="bg-gold text-navy-950 px-6 py-2 rounded-nv-sm font-semibold hover:bg-gold-dark">Add to Cart</button>
                    </form>
                @endif

                <div class="mt-4 bg-surface border border-stroke rounded-nv-sm p-3 text-sm text-nv-blue">
                    Earn loyalty tokens with every purchase!
                </div>
            </div>
        </div>

        @if($relatedProducts->count())
            <section class="mt-12">
                <h3 class="text-lg font-semibold mb-4">Related Products</h3>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($relatedProducts as $rp)
                        <a href="{{ route('store.product', [$vendor->slug, $rp]) }}" class="bg-surface border border-stroke rounded-nv p-4 hover:border-nv-blue transition">
                            <div class="font-medium">{{ $rp->title }}</div>
                            <div class="text-gold text-sm mt-1">${{ number_format($rp->price, 2) }}</div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-app-layout>
