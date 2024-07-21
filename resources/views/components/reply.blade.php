@props(['reply', 'post'])

<article class="px-4 py-3 bg-gray-100 border shadow rounded-xl space-y-4">
    <p>{{ $reply->content }}</p>
    <div>
        @if($reply->user)
            <p class="leading-none">{{ $reply->user->name }}</p>
        @else
            <p class="leading-none">Anonymous</p>
        @endif
        <time class="text-sm text-slate-500">{{ $reply->created_at->diffForHumans() }}</time>
    </div>

    <div class="flex items-center">
        <!-- Comment Icon -->
        <button onclick="toggleReplyForm('replyForm{{ $reply->id }}')" class="flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
            <!-- Icone de message -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8m-4-4h4m2 8h2m-8 4H8l-4 4V4a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2z" />
            </svg>
            <span>{{ $reply->children->count() }}</span>
        </button>
    </div>

    <!-- Hidden Reply Form -->
    <form id="replyForm{{ $reply->id }}" action="{{ route('replies.storeReplyToReply', ['post' => $post, 'parentReply' => $reply]) }}" method="post" class="hidden px-4 py-3 bg-white border shadow rounded-xl space-y-2">
        @csrf
        <div>
            <x-input-label for="content" value="Your Reply" />
            <textarea id="content" name="content" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required></textarea>
            <x-input-error class="mt-2" :messages="$errors->get('content')" />
        </div>
        <x-primary-button>Reply</x-primary-button>
    </form>

    @if($reply->children->isNotEmpty())
        <div class="ml-8 mt-4">
            @foreach($reply->children as $childReply)
                <x-reply :reply="$childReply" :post="$post"/>
            @endforeach
        </div>
    @endif
</article>
