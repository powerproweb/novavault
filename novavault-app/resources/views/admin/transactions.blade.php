<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">All Transactions</h2></x-slot>
    <div class="py-8 max-w-7xl mx-auto px-4">
        <div class="bg-surface border border-stroke rounded-nv overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-navy-800 text-gray-400 text-left"><tr><th class="p-3">#</th><th class="p-3">Vendor</th><th class="p-3">Customer</th><th class="p-3">Total</th><th class="p-3">Source</th><th class="p-3">Status</th><th class="p-3">Date</th></tr></thead>
                <tbody>
                    @forelse($orders as $o)
                        <tr class="border-t border-stroke"><td class="p-3">{{ $o->id }}</td><td class="p-3">{{ $o->vendor->business_name }}</td><td class="p-3">{{ $o->patron?->name ?? 'Guest' }}</td><td class="p-3 text-gold">${{ number_format($o->total, 2) }}</td><td class="p-3 text-gray-400">{{ $o->source }}</td><td class="p-3"><span class="px-2 py-0.5 rounded text-xs {{ $o->status === 'paid' ? 'bg-green-900 text-green-300' : 'bg-yellow-900 text-yellow-300' }}">{{ $o->status }}</span></td><td class="p-3 text-gray-400">{{ $o->created_at->format('M d') }}</td></tr>
                    @empty
                        <tr><td colspan="7" class="p-6 text-center text-gray-500">No transactions.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $orders->links() }}</div>
    </div>
</x-app-layout>
