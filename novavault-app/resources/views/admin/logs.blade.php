<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Audit Logs</h2></x-slot>
    <div class="py-8 max-w-7xl mx-auto px-4">
        <div class="bg-surface border border-stroke rounded-nv overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-navy-800 text-gray-400 text-left"><tr><th class="p-3">User</th><th class="p-3">Action</th><th class="p-3">Target</th><th class="p-3">IP</th><th class="p-3">Date</th></tr></thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr class="border-t border-stroke"><td class="p-3">{{ $log->user?->name ?? 'System' }}</td><td class="p-3 font-mono text-nv-blue">{{ $log->action }}</td><td class="p-3 text-gray-400">{{ $log->target_type }}#{{ $log->target_id }}</td><td class="p-3 text-gray-400">{{ $log->ip }}</td><td class="p-3 text-gray-400">{{ $log->created_at->format('M d H:i') }}</td></tr>
                    @empty
                        <tr><td colspan="5" class="p-6 text-center text-gray-500">No logs.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $logs->links() }}</div>
    </div>
</x-app-layout>
