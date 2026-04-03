<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Ban Management</h2></x-slot>
    <div class="py-8 max-w-5xl mx-auto px-4 space-y-6">
        <form method="POST" action="{{ route('admin.bans.store') }}" class="bg-surface border border-stroke rounded-nv p-5 flex gap-4 items-end">
            @csrf
            <div><x-input-label for="type" value="Type" /><select id="type" name="type" class="mt-1 rounded-nv-sm bg-navy-800 border-stroke text-white"><option value="ip">IP</option><option value="email">Email</option><option value="username">Username</option></select></div>
            <div class="flex-1"><x-input-label for="value" value="Value" /><x-text-input id="value" name="value" class="w-full mt-1" required /></div>
            <div class="flex-1"><x-input-label for="reason" value="Reason" /><x-text-input id="reason" name="reason" class="w-full mt-1" /></div>
            <x-primary-button>Add Ban</x-primary-button>
        </form>
        <div class="bg-surface border border-stroke rounded-nv overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-navy-800 text-gray-400 text-left"><tr><th class="p-3">Type</th><th class="p-3">Value</th><th class="p-3">Reason</th><th class="p-3">By</th><th class="p-3">Date</th><th class="p-3"></th></tr></thead>
                <tbody>
                    @forelse($bans as $ban)
                        <tr class="border-t border-stroke"><td class="p-3">{{ $ban->type }}</td><td class="p-3 font-mono">{{ $ban->value }}</td><td class="p-3 text-gray-400">{{ $ban->reason ?? '—' }}</td><td class="p-3 text-gray-400">{{ $ban->admin?->name ?? '—' }}</td><td class="p-3 text-gray-400">{{ $ban->created_at->format('M d') }}</td><td class="p-3"><form method="POST" action="{{ route('admin.bans.destroy', $ban) }}">@csrf @method('DELETE')<button class="text-red-400 hover:underline text-xs">Remove</button></form></td></tr>
                    @empty
                        <tr><td colspan="6" class="p-6 text-center text-gray-500">No bans.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
