<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Manage Vendors</h2></x-slot>
    <div class="py-8 max-w-7xl mx-auto px-4">
        <div class="flex gap-3 mb-4">
            <a href="{{ route('admin.vendors') }}" class="px-3 py-1 rounded text-sm {{ !request('status') ? 'bg-nv-blue text-navy-950' : 'bg-navy-800 text-gray-300' }}">All</a>
            <a href="{{ route('admin.vendors', ['status' => 'pending']) }}" class="px-3 py-1 rounded text-sm {{ request('status') === 'pending' ? 'bg-gold text-navy-950' : 'bg-navy-800 text-gray-300' }}">Pending</a>
            <a href="{{ route('admin.vendors', ['status' => 'approved']) }}" class="px-3 py-1 rounded text-sm {{ request('status') === 'approved' ? 'bg-green-700 text-white' : 'bg-navy-800 text-gray-300' }}">Approved</a>
        </div>
        <div class="bg-surface border border-stroke rounded-nv overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-navy-800 text-gray-400 text-left"><tr><th class="p-3">Business</th><th class="p-3">Owner</th><th class="p-3">Category</th><th class="p-3">Status</th><th class="p-3">Actions</th></tr></thead>
                <tbody>
                    @forelse($vendors as $v)
                        <tr class="border-t border-stroke">
                            <td class="p-3 font-medium">{{ $v->business_name }}</td>
                            <td class="p-3 text-gray-400">{{ $v->user->name }}</td>
                            <td class="p-3 text-gray-400">{{ $v->category ?? '—' }}</td>
                            <td class="p-3"><span class="px-2 py-0.5 rounded text-xs {{ $v->status === 'approved' ? 'bg-green-900 text-green-300' : ($v->status === 'pending' ? 'bg-yellow-900 text-yellow-300' : 'bg-red-900 text-red-300') }}">{{ $v->status }}</span></td>
                            <td class="p-3 flex gap-2">
                                @if($v->status === 'pending')
                                    <form method="POST" action="{{ route('admin.vendors.approve', $v) }}">@csrf <button class="text-green-400 hover:underline text-xs">Approve</button></form>
                                @endif
                                @if($v->status !== 'suspended')
                                    <form method="POST" action="{{ route('admin.vendors.suspend', $v) }}">@csrf <button class="text-red-400 hover:underline text-xs">Suspend</button></form>
                                @endif
                                <a href="{{ route('admin.vendors.edit', $v) }}" class="text-nv-blue hover:underline text-xs">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-6 text-center text-gray-500">No vendors.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $vendors->links() }}</div>
    </div>
</x-app-layout>
