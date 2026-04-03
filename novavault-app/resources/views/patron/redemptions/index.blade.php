<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">My Redemptions</h2></x-slot>
    <div class="py-8 max-w-5xl mx-auto px-4">
        <div class="bg-surface border border-stroke rounded-nv overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-navy-800 text-gray-400 text-left">
                    <tr><th class="p-3">Vendor</th><th class="p-3">Type</th><th class="p-3">Tokens</th><th class="p-3">Code</th><th class="p-3">Status</th><th class="p-3">Date</th></tr>
                </thead>
                <tbody>
                    @forelse($redemptions as $r)
                        <tr class="border-t border-stroke">
                            <td class="p-3">{{ $r->vendor->business_name }}</td>
                            <td class="p-3">{{ $r->reward_type }}</td>
                            <td class="p-3 text-gold">{{ number_format($r->amount, 2) }}</td>
                            <td class="p-3 font-mono text-nv-blue">{{ $r->confirmation_code }}</td>
                            <td class="p-3"><span class="px-2 py-0.5 rounded text-xs {{ $r->status === 'completed' ? 'bg-green-900 text-green-300' : 'bg-yellow-900 text-yellow-300' }}">{{ $r->status }}</span></td>
                            <td class="p-3 text-gray-400">{{ $r->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-6 text-center text-gray-500">No redemptions yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $redemptions->links() }}</div>
    </div>
</x-app-layout>
