<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            @if($vendor->logo_path)<img src="{{ Storage::url($vendor->logo_path) }}" class="w-10 h-10 rounded-nv-sm" alt="">@endif
            <div>
                <h2 class="text-xl font-semibold text-gold">{{ $vendor->business_name }}</h2>
                @if($vendor->category)<span class="text-sm text-gray-400">{{ $vendor->category }}</span>@endif
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4">
        <!-- Categories -->
        @if($categories->count())
            <div class="flex gap-3 mb-6 flex-wrap">
                <a href="{{ route('store.show', $vendor->slug) }}" class="px-3 py-1 rounded-full text-sm {{ !isset($category) ? 'bg-nv-blue text-navy-950' : 'bg-navy-800 text-gray-300 hover:bg-navy-700' }}">All</a>
                @foreach($categories as $cat)
                    <a href="{{ route('store.category', [$vendor->slug, $cat->slug]) }}" class="px-3 py-1 rounded-full text-sm {{ (isset($category) && $category->id === $cat->id) ? 'bg-nv-blue text-navy-950' : 'bg-navy-800 text-gray-300 hover:bg-navy-700' }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        @endif

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-surface border border-stroke rounded-nv overflow-hidden hover:border-nv-blue transition">
                    @if($product->image_path)
                        <img src="{{ Storage::url($product->image_path) }}" class="w-full h-48 object-cover" alt="{{ $product->title }}">
                    @else
                        <div class="w-full h-48 bg-navy-800 flex items-center justify-center text-gray-600">No Image</div>
                    @endif
                    <div class="p-4">
                        <h3 class="font-semibold text-white">{{ $product->title }}</h3>
                        <div class="text-gold font-bold mt-1">${{ number_format($product->price, 2) }}</div>
                        <p class="text-xs text-gray-400 mt-1 line-clamp-2">{{ $product->description }}</p>
                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('store.product', [$vendor->slug, $product]) }}" class="text-nv-blue text-sm hover:underline">Details</a>
                            <form method="POST" action="{{ route('store.cart.add', [$vendor->slug, $product]) }}">
                                @csrf
                                <button class="bg-gold text-navy-950 px-3 py-1 rounded text-xs font-semibold hover:bg-gold-dark">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 col-span-full">No products available.</p>
            @endforelse
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    </div>
</x-app-layout>
