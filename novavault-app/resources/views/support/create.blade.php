<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">New Support Ticket</h2></x-slot>
    <div class="py-8 max-w-2xl mx-auto px-4">
        <form method="POST" action="{{ route('support.store') }}" class="space-y-5">
            @csrf
            <div><x-input-label for="subject" value="Subject" /><x-text-input id="subject" name="subject" class="w-full mt-1" required /></div>
            <div><x-input-label for="priority" value="Priority" /><select id="priority" name="priority" class="w-full mt-1 rounded-nv-sm bg-navy-800 border-stroke text-white"><option value="low">Low</option><option value="medium" selected>Medium</option><option value="high">High</option></select></div>
            <div><x-input-label for="message" value="Message" /><textarea id="message" name="message" rows="6" class="w-full mt-1 rounded-nv-sm bg-navy-800 border-stroke text-white" required></textarea></div>
            <x-primary-button>Submit Ticket</x-primary-button>
        </form>
    </div>
</x-app-layout>
