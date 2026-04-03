<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Discover Vendors</h2></x-slot>
    <div class="py-8 max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($vendors as $vendor)
                <a href="{{ route('store.show', $vendor->slug) }}" class="bg-surface border border-stroke rounded-nv p-6 hover:border-nv-blue transition block">
                    <h3 class="text-lg font-semibold text-white">{{ $vendor->business_name }}</h3>
                    @if($vendor->category)<span class="text-xs text-gold">{{ $vendor->category }}</span>@endif
                    <p class="text-sm text-gray-400 mt-2 line-clamp-2">{{ $vendor->description ?? 'No description.' }}</p>
                    <div class="mt-3 text-xs text-gray-500">{{ $vendor->products_count }} products</div>
                </a>
            @empty
                <p class="text-gray-500 col-span-full">No vendors available yet.</p>
            @endforelse
        </div>
        <div class="mt-6">{{ $vendors->links() }}</div>
    </div>
</x-app-layout>
