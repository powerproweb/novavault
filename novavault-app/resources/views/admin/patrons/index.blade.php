<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Manage Patrons</h2></x-slot>
    <div class="py-8 max-w-7xl mx-auto px-4">
        <div class="bg-surface border border-stroke rounded-nv overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-navy-800 text-gray-400 text-left"><tr><th class="p-3">Name</th><th class="p-3">Email</th><th class="p-3">Wallets</th><th class="p-3">Joined</th><th class="p-3">Actions</th></tr></thead>
                <tbody>
                    @forelse($patrons as $p)
                        <tr class="border-t border-stroke">
                            <td class="p-3 font-medium">{{ $p->name }}</td>
                            <td class="p-3 text-gray-400">{{ $p->email }}</td>
                            <td class="p-3">{{ $p->wallets_count }}</td>
                            <td class="p-3 text-gray-400">{{ $p->created_at->format('M d, Y') }}</td>
                            <td class="p-3 flex gap-2">
                                <a href="{{ route('admin.patrons.show', $p) }}" class="text-nv-blue hover:underline text-xs">View</a>
                                <form method="POST" action="{{ route('admin.patrons.suspend', $p) }}">@csrf <button class="text-red-400 hover:underline text-xs">Suspend</button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-6 text-center text-gray-500">No patrons.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $patrons->links() }}</div>
    </div>
</x-app-layout>
