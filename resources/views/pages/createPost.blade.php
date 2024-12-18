@extends('mainLayout')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold mb-6">Create Post</h1>

    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium">Title</label>
            <input type="text" name="title" id="title" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label for="image" class="block text-sm font-medium">Image</label>
            <input type="file" name="image" id="image" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium">Description</label>
            <textarea name="description" id="description" rows="4" class="w-full border rounded p-2"></textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Post</button>
    </form>
</div>
@endsection
