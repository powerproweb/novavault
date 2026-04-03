<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Ticket #{{ $ticket->id }}: {{ $ticket->subject }}</h2>
            <span class="px-2 py-0.5 rounded text-xs {{ $ticket->status === 'open' ? 'bg-green-900 text-green-300' : 'bg-gray-700 text-gray-400' }}">{{ $ticket->status }}</span>
        </div>
    </x-slot>
    <div class="py-8 max-w-3xl mx-auto px-4 space-y-4">
        @foreach($ticket->messages as $msg)
            <div class="bg-surface border border-stroke rounded-nv p-4 {{ $msg->user->isAdmin() ? 'border-l-4 border-l-nv-blue' : '' }}">
                <div class="flex justify-between text-sm"><span class="font-semibold">{{ $msg->user->name }}</span><span class="text-gray-400">{{ $msg->created_at->diffForHumans() }}</span></div>
                <p class="mt-2 text-gray-300">{{ $msg->body }}</p>
            </div>
        @endforeach

        @if($ticket->status !== 'closed')
            <form method="POST" action="{{ route('support.reply', $ticket) }}" class="bg-surface border border-stroke rounded-nv p-5 space-y-4">
                @csrf
                <textarea name="message" rows="4" class="w-full rounded-nv-sm bg-navy-800 border-stroke text-white" placeholder="Type your reply..." required></textarea>
                @if(auth()->user()->isAdmin())
                    <select name="status" class="rounded-nv-sm bg-navy-800 border-stroke text-white text-sm">
                        <option value="">— Don't change status —</option>
                        <option value="in_progress">In Progress</option>
                        <option value="resolved">Resolved</option>
                        <option value="closed">Closed</option>
                    </select>
                @endif
                <x-primary-button>Reply</x-primary-button>
            </form>
        @endif
    </div>
</x-app-layout>
