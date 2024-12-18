@extends('mainLayout')

@section('content')
<div class="px-4 pt-4">
    <!-- Search Input -->
    <input type="text" id="search" placeholder="Search posts..." value="{{ request()->query('search') }}"
        class="border-2 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">

    <!-- List of Posts -->
    <div id="post-list" class="justify-center grid grid-cols-5 gap-4 px-4 pt-4">
        @if ($posts->isEmpty())
        <p class="col-span-5 text-center text-lg text-gray-500">No posts available</p>
        @else
        @foreach ($posts as $post)
        <div
            class="h-full flex flex-col rounded-lg overflow-hidden shadow border bg-white hover:scale-105 duration-300">
            <img src="{{ asset('storage/' . $post->image) }}" alt="Image" class="object-cover h-42 w-full">
            <div class="p-4 relative grow mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-2">{{ ucfirst($post->title) }}</h2>
                <div class="line-clamp-3">
                    <p class="text-gray-600 text-sm ">{!! $post->description !!}</p>
                </div>
                <a href="{{ route('post.show', [$post->id]) }}"
                    class=" absolute -bottom-4 right-2 flex justify-between items-center">
                    <button
                        class="bg-blue-500 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-blue-600 focus:outline-none">
                        View Post
                    </button>
                </a>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>


@endsection
