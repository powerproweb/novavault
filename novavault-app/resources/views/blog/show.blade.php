<x-app-layout>
    <div class="py-8 max-w-3xl mx-auto px-4">
        <a href="{{ route('blog.index') }}" class="text-nv-blue text-sm hover:underline">&larr; All Posts</a>
        @if($post->category)<div class="mt-4 text-xs text-gold">{{ $post->category }}</div>@endif
        <h1 class="text-3xl font-bold mt-2">{{ $post->title }}</h1>
        <div class="text-sm text-gray-400 mt-2">{{ $post->published_at->format('M d, Y') }} · {{ $post->author->name }}</div>
        @if($post->featured_image)<img src="{{ Storage::url($post->featured_image) }}" class="w-full rounded-nv mt-6" alt="">@endif
        <article class="prose prose-invert max-w-none mt-8">{!! $post->html !!}</article>
    </div>
</x-app-layout>
