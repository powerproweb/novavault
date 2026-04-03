<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Support Tickets</h2>
            <a href="{{ route('support.create') }}" class="bg-nv-blue text-navy-950 px-4 py-2 rounded-nv-sm text-sm font-semibold">New Ticket</a>
        </div>
    </x-slot>
    <div class="py-8 max-w-5xl mx-auto px-4">
        <div class="bg-surface border border-stroke rounded-nv overflow-hidden">
            <table class="w-full text-sm"><thead class="bg-navy-800 text-gray-400 text-left"><tr><th class="p-3">#</th><th class="p-3">Subject</th><th class="p-3">Priority</th><th class="p-3">Status</th><th class="p-3">Updated</th><th class="p-3"></th></tr></thead>
            <tbody>
                @forelse($tickets as $t)
                    <tr class="border-t border-stroke"><td class="p-3">{{ $t->id }}</td><td class="p-3 font-medium">{{ $t->subject }}</td><td class="p-3"><span class="px-2 py-0.5 rounded text-xs {{ $t->priority === 'high' ? 'bg-red-900 text-red-300' : ($t->priority === 'medium' ? 'bg-yellow-900 text-yellow-300' : 'bg-gray-700 text-gray-400') }}">{{ $t->priority }}</span></td><td class="p-3"><span class="px-2 py-0.5 rounded text-xs {{ $t->status === 'open' ? 'bg-green-900 text-green-300' : 'bg-gray-700 text-gray-400' }}">{{ $t->status }}</span></td><td class="p-3 text-gray-400">{{ $t->updated_at->diffForHumans() }}</td><td class="p-3"><a href="{{ route('support.show', $t) }}" class="text-nv-blue hover:underline text-xs">View</a></td></tr>
                @empty
                    <tr><td colspan="6" class="p-6 text-center text-gray-500">No tickets.</td></tr>
                @endforelse
            </tbody></table>
        </div>
    </div>
</x-app-layout>
