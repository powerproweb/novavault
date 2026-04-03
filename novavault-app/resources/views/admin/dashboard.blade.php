<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gold">Admin Dashboard</h2></x-slot>
    <div class="py-8 max-w-7xl mx-auto px-4 space-y-8">
        <dl class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <x-stat-card label="Total Vendors" :value="$stats['vendors_total']" />
            <x-stat-card label="Pending Approval" :value="$stats['vendors_pending']" accent="gold" />
            <x-stat-card label="Total Patrons" :value="$stats['patrons_total']" />
            <x-stat-card label="Paid Orders" :value="$stats['orders_total']" />
            <x-stat-card label="Total Revenue" :value="'$' . number_format($stats['revenue_total'], 2)" accent="gold" />
            <x-stat-card label="Tokens Issued" :value="number_format($stats['tokens_issued'], 2)" accent="nv-blue" />
            <x-stat-card label="Tokens Redeemed" :value="number_format($stats['tokens_redeemed'], 2)" />
            <x-stat-card label="Approved Vendors" :value="$stats['vendors_approved']" />
        </dl>
        <section>
            <h3 class="text-lg font-semibold mb-3">Recent Orders</h3>
            <div class="bg-surface border border-stroke rounded-nv overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-navy-800 text-gray-400 text-left"><tr><th class="p-3">#</th><th class="p-3">Vendor</th><th class="p-3">Customer</th><th class="p-3">Total</th><th class="p-3">Status</th><th class="p-3">Date</th></tr></thead>
                    <tbody>
                        @foreach($recentOrders as $o)
                            <tr class="border-t border-stroke"><td class="p-3">{{ $o->id }}</td><td class="p-3">{{ $o->vendor->business_name }}</td><td class="p-3">{{ $o->patron?->name ?? 'Guest' }}</td><td class="p-3 text-gold">${{ number_format($o->total, 2) }}</td><td class="p-3"><span class="px-2 py-0.5 rounded text-xs {{ $o->status === 'paid' ? 'bg-green-900 text-green-300' : 'bg-yellow-900 text-yellow-300' }}">{{ $o->status }}</span></td><td class="p-3 text-gray-400">{{ $o->created_at->diffForHumans() }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
