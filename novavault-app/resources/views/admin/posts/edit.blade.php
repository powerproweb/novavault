<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Edit: {{ $post->title }}</h2></x-slot>
    <div class="py-8 max-w-3xl mx-auto px-4">
        <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')
            <div><x-input-label for="title" value="Title" /><x-text-input id="title" name="title" class="w-full mt-1" :value="$post->title" required /></div>
            <div><x-input-label for="category" value="Category" /><x-text-input id="category" name="category" class="w-full mt-1" :value="$post->category" /></div>
            <div><x-input-label for="body" value="Body (Markdown)" /><textarea id="body" name="body" rows="15" class="w-full mt-1 rounded-nv-sm bg-navy-800 border-stroke text-white font-mono text-sm" required>{{ $post->body }}</textarea></div>
            <div><x-input-label for="featured_image" value="Featured Image" /><input id="featured_image" name="featured_image" type="file" accept="image/*" class="mt-1 text-sm text-gray-400" />@if($post->featured_image)<p class="text-xs text-gray-500 mt-1">Current: {{ $post->featured_image }}</p>@endif</div>
            <div><x-input-label for="status" value="Status" /><select id="status" name="status" class="w-full mt-1 rounded-nv-sm bg-navy-800 border-stroke text-white"><option value="draft" {{ $post->status === 'draft' ? 'selected' : '' }}>Draft</option><option value="published" {{ $post->status === 'published' ? 'selected' : '' }}>Published</option></select></div>
            <x-primary-button>Update Post</x-primary-button>
        </form>
    </div>
</x-app-layout>
