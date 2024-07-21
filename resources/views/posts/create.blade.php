<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Post
        </h2>
    </x-slot>

    <section class="flex-1 w-full max-w-4xl mx-auto py-12">
        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data" class="px-4 py-3 bg-white border shadow rounded-xl space-y-2">
            @csrf

            <div>
                <x-input-label for="title" value="Title" />
                <x-text-input id="title" name="title" class="block mt-1 w-full" type="text" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('title')" />
            </div>

            <div>
                <x-input-label for="content" value="Content" />
                <textarea id="content" name="content" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
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
        plugins: 'link image code imagetools',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | code | image',
        automatic_uploads: true,
        images_upload_url: '{{ route("image.upload") }}',
        images_upload_credentials: true,
        file_picker_types: 'image',
        file_picker_callback: function (cb, value, meta) {
          var input = document.createElement('input');
          input.setAttribute('type', 'file');
          input.setAttribute('accept', 'image/*');
          input.onchange = function () {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function () {
              var id = 'blobid' + (new Date()).getTime();
              var blobCache = tinymce.activeEditor.editorUpload.blobCache;
              var base64 = reader.result.split(',')[1];
              var blobInfo = blobCache.create(id, file, base64);
              blobCache.add(blobInfo);
              cb(blobInfo.blobUri(), { title: file.name });
            };
            reader.readAsDataURL(file);
          };
          input.click();
        }
      });
    </script>
</x-app-layout>
