<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Platform Settings</h2></x-slot>
    <div class="py-8 max-w-3xl mx-auto px-4">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
            @csrf
            @foreach($settings as $group => $items)
                <div class="bg-surface border border-stroke rounded-nv p-5">
                    <h3 class="text-gold font-semibold mb-3">{{ ucfirst($group) }}</h3>
                    @foreach($items as $i => $setting)
                        <div class="mb-3">
                            <input type="hidden" name="settings[{{ $loop->parent->index }}_{{ $i }}][group]" value="{{ $setting->group }}">
                            <input type="hidden" name="settings[{{ $loop->parent->index }}_{{ $i }}][key]" value="{{ $setting->key }}">
                            <x-input-label :value="$setting->key" />
                            <x-text-input name="settings[{{ $loop->parent->index }}_{{ $i }}][value]" class="w-full mt-1" :value="$setting->value" />
                        </div>
                    @endforeach
                </div>
            @endforeach
            @if($settings->isEmpty())
                <p class="text-gray-500">No settings configured yet.</p>
            @endif
            <x-primary-button>Save Settings</x-primary-button>
        </form>
    </div>
</x-app-layout>
