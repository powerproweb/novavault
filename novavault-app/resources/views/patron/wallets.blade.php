<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">My Wallets</h2></x-slot>
    <div class="py-8 max-w-5xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($wallets as $wallet)
                <div class="bg-surface border border-stroke rounded-nv p-5">
                    <div class="font-semibold">{{ $wallet->vendor->business_name }}</div>
                    <div class="text-3xl font-bold text-nv-blue mt-2">{{ number_format($wallet->balance, 2) }}</div>
                    <div class="text-xs text-gray-400 mt-1">tokens</div>
                    <div class="mt-4 flex gap-3">
                        <a href="{{ route('patron.redeem.offers', $wallet->vendor) }}" class="text-gold text-sm hover:underline">Redeem</a>
                        <a href="{{ route('store.show', $wallet->vendor->slug) }}" class="text-nv-blue text-sm hover:underline">Visit Store</a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 col-span-full">No wallets yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
