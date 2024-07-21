<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Posts
        </h2>
    </x-slot>

    <section class="flex-1 w-full max-w-4xl mx-auto py-12 flex flex-col gap-8">
        @foreach($posts as $post)
            <article class="px-4 py-3 bg-white border shadow rounded-xl space-y-4">
                <h3 class="text-xl font-bold">{{ $post->title }}</h3>
                <p>{!! $post->content !!}</p>
                @if($post->image_path)
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="mt-2">
                @endif
                @if($post->video_path)
                    <video src="{{ asset('storage/' . $post->video_path) }}" controls class="mt-2" style="max-width: 100%;"></video>
                @endif
                @if($post->video_url)
                    @if(preg_match('/(youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $post->video_url, $matches))
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $matches[2] }}" frameborder="0" allowfullscreen></iframe>
                    @else
                        <a href="{{ $post->video_url }}">{{ $post->video_url }}</a>
                    @endif
                @endif
                <div>
                    @if($post->user)
                        <p class="leading-none">{{ $post->user->name }}</p>
                    @else
                        <p class="leading-none">Anonymous</p>
                    @endif
                    <time class="text-sm text-slate-500">{{ $post->created_at->diffForHumans() }}</time>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Upvote Button -->
                    <form action="{{ route('posts.upvote', $post) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                            </svg>
                        </button>
                    </form>

                    <!-- Vote Count -->
                    <span>{{ $post->upvotes()->count() - $post->downvotes()->count() }}</span>

                    <!-- Downvote Button -->
                    <form action="{{ route('posts.downvote', $post) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </form>

                    <!-- Comment Icon -->
                    <a href="{{ route('posts.show', $post) }}" class="flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8m-4-4h4m2 8h2m-8 4H8l-4 4V4a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2z" />
                        </svg>
                        <span>{{ $post->replies->count() }}</span>
                    </a>
                </div>
            </article>
        @endforeach
    </section>
</x-app-layout>
