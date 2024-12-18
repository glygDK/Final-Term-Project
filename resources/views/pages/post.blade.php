@extends('mainLayout')

@section('content')
<div class="flex items-center flex-col gap-2 my-4">
    <div class="border shadow rounded-xl w-2/5 overflow-hidden bg-white">
        <img src="{{ asset('storage/' . $post->image) }}" class="object-cover">
        <div class="p-2">
            <h2 class="text-xl font-bold text-gray-800">{{ ucfirst($post->title) }}</h2>
            <p class="text-gray-600 text-sm">{!! $post->description !!}</p>
        </div>

        <!-- Like Button -->
        <div class="flex justify-between p-2">
            <button type="button" class="like-button flex gap-1 items-center" id="like-button-{{ $post->id }}"
                data-post-id="{{ $post->id }}">
                <span id="icon-container-{{ $post->id }}" class=" w-5 h-5">
                    @if ($post->likes->contains('user_id', Auth::id()))
                    <x-fas-heart class="text-red-500" id="icon-{{ $post->id }}" />
                    @else
                    <x-far-heart class="" id="icon-{{ $post->id }}" />
                    @endif
                </span>
                <span id="like-count-{{ $post->id }}">{{ $post->likes->count() }} </span> Likes
            </button>

            <button class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600" onclick="sharePost()">
                Share
            </button>

        </div>
    </div>

    <!-- Comment Form -->
    <div class="border shadow rounded-xl w-2/5 p-2 bg-white">
        <p class="">Comment</p>
        <form action="{{ route('posts.comment', $post->id) }}" method="POST" class="relative">
            @csrf
            <textarea name="content" class="w-full border-2 rounded-md p-2 min-h-32"
                placeholder="Write your comment here..." required></textarea>

            <button class="absolute bottom-4 right-4 bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">
                Submit
            </button>
        </form>

        @foreach ($post->comments as $comment)
        <div class="p-2">
            <p class="font-bold">{{ ucfirst($comment->user->name) }}</p>
            <p>{{ ucfirst($comment->content) }}</p>
        </div>
        <hr>
        @endforeach
    </div>
</div>

@endsection

<script>
function sharePost(postUrl) {
    const facebookShareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(postUrl)}`;
    window.open(facebookShareUrl, '_blank', 'width=600,height=400');
}
</script>
