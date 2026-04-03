<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Redeem at {{ $vendor->business_name }}</h2></x-slot>

    <div class="py-8 max-w-2xl mx-auto px-4 space-y-6">
        <div class="bg-surface border border-stroke rounded-nv p-5">
            <div class="text-sm text-gray-400">Your Balance</div>
            <div class="text-3xl font-bold text-nv-blue">{{ number_format($balance, 2) }} <span class="text-sm text-gray-400">tokens</span></div>
        </div>

        <form method="POST" action="{{ route('patron.redeem') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">

            <div>
                <x-input-label for="amount" value="Tokens to Redeem" />
                <x-text-input id="amount" name="amount" type="number" step="0.00000001" min="0.00000001" :max="$balance" class="w-full mt-1" required />
                <x-input-error :messages="$errors->get('amount')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="reward_type" value="Reward Type" />
                <select id="reward_type" name="reward_type" class="w-full mt-1 rounded-nv-sm bg-navy-800 border-stroke text-white" required>
                    <option value="discount_pct">Percentage Discount</option>
                    <option value="discount_flat">Flat Discount</option>
                    <option value="free_product">Free Product</option>
                    <option value="service">Service Reward</option>
                    <option value="promo">Promotion</option>
                </select>
            </div>

            <div>
                <x-input-label for="reward_detail" value="Note (optional)" />
                <x-text-input id="reward_detail" name="reward_detail" class="w-full mt-1" placeholder="e.g. 10% off next purchase" />
            </div>

            <x-primary-button>Redeem Tokens</x-primary-button>
        </form>
    </div>
</x-app-layout>
