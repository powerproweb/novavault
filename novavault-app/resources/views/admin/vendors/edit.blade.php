<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Edit Vendor: {{ $vendor->business_name }}</h2></x-slot>
    <div class="py-8 max-w-2xl mx-auto px-4">
        <form method="POST" action="{{ route('admin.vendors.update', $vendor) }}" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <x-input-label value="Business Name" /><p class="text-white">{{ $vendor->business_name }}</p>
            </div>
            <div>
                <x-input-label value="Owner" /><p class="text-gray-400">{{ $vendor->user->name }} ({{ $vendor->user->email }})</p>
            </div>
            <div>
                <x-input-label for="pricing_tier" value="Pricing Tier" />
                <x-text-input id="pricing_tier" name="pricing_tier" class="w-full mt-1" :value="old('pricing_tier', $vendor->pricing_tier)" placeholder="e.g. starter, growth, enterprise" />
            </div>
            <div>
                <x-input-label for="status" value="Status" />
                <select id="status" name="status" class="w-full mt-1 rounded-nv-sm bg-navy-800 border-stroke text-white">
                    @foreach(['pending','approved','suspended'] as $s)
                        <option value="{{ $s }}" {{ $vendor->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <x-primary-button>Update Vendor</x-primary-button>
        </form>
    </div>
</x-app-layout>
