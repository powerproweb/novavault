<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Blog Posts</h2>
            <a href="{{ route('admin.posts.create') }}" class="bg-nv-blue text-navy-950 px-4 py-2 rounded-nv-sm text-sm font-semibold">+ New Post</a>
        </div>
    </x-slot>
    <div class="py-8 max-w-7xl mx-auto px-4">
        <div class="bg-surface border border-stroke rounded-nv overflow-hidden">
            <table class="w-full text-sm"><thead class="bg-navy-800 text-gray-400 text-left"><tr><th class="p-3">Title</th><th class="p-3">Category</th><th class="p-3">Status</th><th class="p-3">Author</th><th class="p-3">Date</th><th class="p-3"></th></tr></thead>
            <tbody>@forelse($posts as $post)<tr class="border-t border-stroke"><td class="p-3 font-medium">{{ $post->title }}</td><td class="p-3 text-gray-400">{{ $post->category ?? '—' }}</td><td class="p-3"><span class="px-2 py-0.5 rounded text-xs {{ $post->status === 'published' ? 'bg-green-900 text-green-300' : 'bg-yellow-900 text-yellow-300' }}">{{ $post->status }}</span></td><td class="p-3 text-gray-400">{{ $post->author->name }}</td><td class="p-3 text-gray-400">{{ $post->created_at->format('M d') }}</td><td class="p-3 flex gap-2"><a href="{{ route('admin.posts.edit', $post) }}" class="text-nv-blue hover:underline text-xs">Edit</a><form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-400 hover:underline text-xs">Delete</button></form></td></tr>@empty<tr><td colspan="6" class="p-6 text-center text-gray-500">No posts.</td></tr>@endforelse</tbody></table>
        </div>
        <div class="mt-4">{{ $posts->links() }}</div>
    </div>
</x-app-layout>
