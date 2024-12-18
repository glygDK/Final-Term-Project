@if ($posts->isEmpty())
<p class="col-span-5 text-center text-lg text-gray-500">No posts available</p>
@else
@foreach ($posts as $post)
<div class="h-full rounded-lg overflow-hidden shadow border bg-white hover:scale-105 duration-300">
    <img src="{{ asset('storage/' . $post->image) }}" alt="Image" class="object-cover h-42 w-full">
    <div class="p-4">
        <h2 class="text-xl font-bold text-gray-800 mb-2">{{ ucfirst($post->title) }}</h2>
        <div class="line-clamp-3">
            <p class="text-gray-600 text-sm ">{!! $post->description !!}</p>
        </div>
        <a href="{{ route('post.show', [$post->id]) }}" class="mt-4 flex justify-between items-center">
            <button
                class="bg-blue-500 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-blue-600 focus:outline-none">
                View Post
            </button>
        </a>
    </div>
</div>
@endforeach
@endif
