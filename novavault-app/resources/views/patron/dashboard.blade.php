<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gold">My Rewards Dashboard</h2></x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 space-y-8">
        <x-stat-card label="Total Token Balance" :value="number_format($totalBalance, 2)" accent="gold" />

        <!-- Wallet Balances -->
        <section>
            <h3 class="text-lg font-semibold mb-3">Wallet Balances</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($wallets as $wallet)
                    <div class="bg-surface border border-stroke rounded-nv p-5">
                        <div class="font-semibold">{{ $wallet->vendor->business_name }}</div>
                        <div class="text-2xl font-bold text-nv-blue mt-1">{{ number_format($wallet->balance, 2) }} <span class="text-sm text-gray-400">tokens</span></div>
                        <a href="{{ route('patron.redeem.offers', $wallet->vendor) }}" class="mt-3 inline-block text-gold text-sm hover:underline">Redeem &rarr;</a>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-full">No tokens earned yet. <a href="{{ route('patron.discover') }}" class="text-nv-blue hover:underline">Discover vendors</a></p>
                @endforelse
            </div>
        </section>

        <!-- Recent Activity -->
        <section>
            <h3 class="text-lg font-semibold mb-3">Recent Activity</h3>
            <div class="bg-surface border border-stroke rounded-nv overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-navy-800 text-gray-400 text-left">
                        <tr><th class="p-3">Type</th><th class="p-3">Amount</th><th class="p-3">Memo</th><th class="p-3">Date</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $tx)
                            <tr class="border-t border-stroke">
                                <td class="p-3"><span class="px-2 py-0.5 rounded text-xs {{ $tx->type === 'earn' ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">{{ $tx->type }}</span></td>
                                <td class="p-3 {{ $tx->type === 'earn' ? 'text-green-400' : 'text-red-400' }}">{{ $tx->type === 'earn' ? '+' : '-' }}{{ number_format($tx->amount, 2) }}</td>
                                <td class="p-3 text-gray-400">{{ $tx->memo ?? '—' }}</td>
                                <td class="p-3 text-gray-400">{{ $tx->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-6 text-center text-gray-500">No activity yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
