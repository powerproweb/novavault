<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Referrals & Badges</h2></x-slot>
    <div class="py-8 max-w-5xl mx-auto px-4 space-y-8">
        @if(count($referralLinks))
        <section>
            <h3 class="text-lg font-semibold mb-3">Your Referral Links</h3>
            <div class="space-y-3">
                @foreach($referralLinks as $link)
                    <div class="bg-surface border border-stroke rounded-nv p-4 flex justify-between items-center">
                        <div><span class="font-medium">{{ $link['vendor']->business_name }}</span><br><span class="text-sm text-gray-400 font-mono">{{ $link['url'] }}</span></div>
                        <button onclick="navigator.clipboard.writeText('{{ $link['url'] }}')" class="bg-nv-blue text-navy-950 px-3 py-1 rounded text-xs font-semibold">Copy</button>
                    </div>
                @endforeach
            </div>
        </section>
        @endif
        @if($badges->count())
        <section>
            <h3 class="text-lg font-semibold mb-3">Your Badges</h3>
            <div class="flex gap-4 flex-wrap">
                @foreach($badges as $badge)
                    <div class="bg-surface border border-stroke rounded-nv p-4 text-center w-32">
                        <div class="text-3xl">{{ $badge->icon }}</div>
                        <div class="font-medium text-sm mt-2">{{ $badge->name }}</div>
                    </div>
                @endforeach
            </div>
        </section>
        @endif
        <section>
            <h3 class="text-lg font-semibold mb-3">Referral History</h3>
            <div class="bg-surface border border-stroke rounded-nv overflow-hidden">
                <table class="w-full text-sm"><thead class="bg-navy-800 text-gray-400 text-left"><tr><th class="p-3">Referred</th><th class="p-3">Vendor</th><th class="p-3">Bonus</th><th class="p-3">Status</th></tr></thead>
                <tbody>@forelse($referrals as $r)<tr class="border-t border-stroke"><td class="p-3">{{ $r->referred->name }}</td><td class="p-3">{{ $r->vendor->business_name }}</td><td class="p-3 text-gold">{{ number_format($r->bonus_amount, 2) }}</td><td class="p-3"><span class="px-2 py-0.5 rounded text-xs {{ $r->status === 'completed' ? 'bg-green-900 text-green-300' : 'bg-yellow-900 text-yellow-300' }}">{{ $r->status }}</span></td></tr>@empty<tr><td colspan="4" class="p-6 text-center text-gray-500">No referrals yet. Share your links above!</td></tr>@endforelse</tbody></table>
            </div>
        </section>
    </div>
</x-app-layout>
