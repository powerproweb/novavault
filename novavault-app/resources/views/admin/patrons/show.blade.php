<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Patron: {{ $user->name }}</h2></x-slot>
    <div class="py-8 max-w-4xl mx-auto px-4 space-y-6">
        <div class="bg-surface border border-stroke rounded-nv p-5">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p class="mt-1"><strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}</p>
        </div>
        <h3 class="text-lg font-semibold">Wallets</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @forelse($user->wallets as $w)
                <div class="bg-surface border border-stroke rounded-nv p-4">
                    <div class="font-medium">{{ $w->vendor->business_name }}</div>
                    <div class="text-xl font-bold text-nv-blue mt-1">{{ number_format($w->balance, 2) }} tokens</div>
                </div>
            @empty
                <p class="text-gray-500">No wallets.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
