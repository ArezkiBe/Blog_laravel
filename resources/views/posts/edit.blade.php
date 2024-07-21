<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Post
        </h2>
    </x-slot>

    <section class="flex-1 w-full max-w-4xl mx-auto py-12">
        <form action="{{ route('posts.update', $post) }}" method="post" class="px-4 py-3 bg-white border shadow rounded-xl space-y-2">
            @csrf
            @method('PATCH')

            <div>
                <x-input-label for="title" value="Title" />
                <x-text-input id="title" name="title" class="block mt-1 w-full" type="text" value="{{ $post->title }}" required />
                <x-input-error class="mt-2" :messages="$errors->get('title')" />
            </div>

            <div>
                <x-input-label for="content" value="Content" />
                <textarea id="content" name="content" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ $post->content }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('content')" />
            </div>

            <x-primary-button>Submit</x-primary-button>
        </form>
    </section>

    <!-- Inclure TinyMCE avec votre clé API -->
    <script src="https://cdn.tiny.cloud/1/yxbahgb778q6n15jxb41lmpf5xu8n3vtljwom9ebqdr2yj61/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: '#content',
        plugins: 'link image code',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | code'
      });
    </script>
</x-app-layout>
