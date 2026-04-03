<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">New Blog Post</h2></x-slot>
    <div class="py-8 max-w-3xl mx-auto px-4">
        <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div><x-input-label for="title" value="Title" /><x-text-input id="title" name="title" class="w-full mt-1" required /></div>
            <div><x-input-label for="category" value="Category" /><x-text-input id="category" name="category" class="w-full mt-1" placeholder="e.g. News, Case Study" /></div>
            <div><x-input-label for="body" value="Body (Markdown)" /><textarea id="body" name="body" rows="15" class="w-full mt-1 rounded-nv-sm bg-navy-800 border-stroke text-white font-mono text-sm" required></textarea></div>
            <div><x-input-label for="featured_image" value="Featured Image" /><input id="featured_image" name="featured_image" type="file" accept="image/*" class="mt-1 text-sm text-gray-400" /></div>
            <div><x-input-label for="status" value="Status" /><select id="status" name="status" class="w-full mt-1 rounded-nv-sm bg-navy-800 border-stroke text-white"><option value="draft">Draft</option><option value="published">Published</option></select></div>
            <x-primary-button>Create Post</x-primary-button>
        </form>
    </div>
</x-app-layout>
