@extends('mainLayout')

@section('content')
<div class="container mx-auto p-4">

    <!-- Link to Create Post Page -->
    <div class="mb-6 flex justify-between items-baseline">
        <h1 class="text-3xl font-semibold ">Admin Dashboard</h1>
        <a href="{{ route('post.create') }}" class="bg-blue-500 h-fit text-white px-4 py-2 rounded hover:bg-blue-600">
            Create New Post
        </a>
    </div>

    <!-- List of Posts -->
    <h2 class="text-2xl font-semibold mb-4">Posts</h2>
    <table class="w-full border table-fixed">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2 w-1/12">Title</th>
                <th class="border px-4 py-2 w-1/6">Image</th>
                <th class="border px-4 py-2 w-1/2">Description</th>
                <th class="border px-4 py-2 w-1/6">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
            <tr>
                <td class="border px-4 py-2">{{ $post->title }}</td>
                <td class="border px-4 py-2">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Image" class="w-24 h-24 mx-auto">
                </td>
                <td class="border px-4 py-2">{!! $post->description !!}</td>
                <td class="border px-4 py-2">
                    <div class="flex gap-2 justify-center">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                            onclick="openEditModal('{{ $post->id }}', '{{ $post->title }}', '{{ $post->description }}')">
                            Edit
                        </button>
                        <form action="{{ route('post.destroy', $post) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

<!-- Edit Post Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
    style="display: none;">
    <div class="bg-white p-6 rounded shadow-lg w-1/3">
        <h2 class="text-xl font-semibold mb-4">Edit Post</h2>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="editTitle" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" id="editTitle" name="title" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="editDescription" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="editDescription" name="description" class="w-full border rounded px-3 py-2" rows="4"
                    required></textarea>
            </div>

            <div class="mb-4">
                <label for="editImage" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" id="editImage" name="image" class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()"
                    class="px-4 py-2 bg-gray-400 text-white rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- TinyMCE Script -->
<script src="https://cdn.tiny.cloud/1/va9al2e1hep0p30e9n59y8nej1ruvm59su4bkqdu4lqqm4m1/tinymce/6/tinymce.min.js"
    referrerpolicy="origin"></script>

<script>
    // Open the modal and populate the fields
    function openEditModal(id, title, description) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        const titleInput = document.getElementById('editTitle');
        const descriptionInput = document.getElementById('editDescription');

        modal.style.display = 'flex';
        form.action = `/posts/${id}`; // Correct action URL
        titleInput.value = title;
        descriptionInput.value = description;

        // Initialize TinyMCE on the description field inside the modal
        tinymce.init({
            selector: '#editDescription',
            height: 300,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | \
                  alignleft aligncenter alignright alignjustify | \
                  bullist numlist outdent indent | removeformat | help'
        });
    }

    // Close the modal
    function closeEditModal() {
        const modal = document.getElementById('editModal');
        modal.style.display = 'none';
        tinymce
            .remove('#editDescription'); // Remove TinyMCE instance
    }
</script>

@endsection
