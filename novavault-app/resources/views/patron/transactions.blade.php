<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Transaction History</h2></x-slot>
    <div class="py-8 max-w-5xl mx-auto px-4">
        <div class="bg-surface border border-stroke rounded-nv overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-navy-800 text-gray-400 text-left">
                    <tr><th class="p-3">Vendor</th><th class="p-3">Type</th><th class="p-3">Amount</th><th class="p-3">Memo</th><th class="p-3">Date</th></tr>
                </thead>
                <tbody>
                    @forelse($entries as $e)
                        <tr class="border-t border-stroke">
                            <td class="p-3">{{ $e->vendor_name }}</td>
                            <td class="p-3"><span class="px-2 py-0.5 rounded text-xs {{ $e->type === 'earn' ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">{{ $e->type }}</span></td>
                            <td class="p-3">{{ number_format($e->amount, 2) }}</td>
                            <td class="p-3 text-gray-400">{{ $e->memo ?? '—' }}</td>
                            <td class="p-3 text-gray-400">{{ $e->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-6 text-center text-gray-500">No transactions yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $entries->links() }}</div>
    </div>
</x-app-layout>
