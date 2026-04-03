<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Blog</h2></x-slot>
    <div class="py-8 max-w-5xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($posts as $post)
                <a href="{{ route('blog.show', $post) }}" class="bg-surface border border-stroke rounded-nv overflow-hidden hover:border-nv-blue transition block">
                    @if($post->featured_image)<img src="{{ Storage::url($post->featured_image) }}" class="w-full h-40 object-cover" alt="">@endif
                    <div class="p-4">
                        @if($post->category)<span class="text-xs text-gold">{{ $post->category }}</span>@endif
                        <h3 class="font-semibold mt-1">{{ $post->title }}</h3>
                        <p class="text-sm text-gray-400 mt-2 line-clamp-3">{{ Str::limit(strip_tags($post->html), 150) }}</p>
                        <div class="text-xs text-gray-500 mt-3">{{ $post->published_at->format('M d, Y') }} · {{ $post->author->name }}</div>
                    </div>
                </a>
            @empty
                <p class="text-gray-500 col-span-full">No posts yet.</p>
            @endforelse
        </div>
        <div class="mt-6">{{ $posts->links() }}</div>
    </div>
</x-app-layout>
