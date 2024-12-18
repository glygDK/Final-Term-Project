<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Space Cat')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <nav class="flex items-center gap-2 p-2 bg-black justify-end text-white">
        <a href="/" class="mr-auto text-lg">
            <p>Space Cats Blog</p>
        </a>

        @if (Auth::check())
        <!-- If user is logged in, show logout -->
        <form action="{{ route('logout') }}" method="POST" class="">
            @csrf
            <button type="submit" class="rounded-md px-3 py-2 border border-gray-100">
                Logout
            </button>
        </form>
        @else
        <!-- If user is not logged in, show login and register links -->
        <a href="/login" class="rounded-md px-3 py-2 border border-gray-100">Log in</a>
        <a href="/register" class="rounded-md px-3 py-2 border border-gray-100">Register</a>
        @endif
    </nav>

    <main>
        @yield('content')
    </main>


    <script src="https://cdn.tiny.cloud/1/va9al2e1hep0p30e9n59y8nej1ruvm59su4bkqdu4lqqm4m1/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#search').on('input', function() {
            let searchTerm = $(this).val();

            $.ajax({
                url: "{{ route('pages.dashboard') }}",
                method: "GET",
                data: {
                    search: searchTerm
                },
                success: function(response) {
                    $('#post-list').html(response.html);
                },
                error: function() {
                    alert('There was an error fetching the posts.');
                }
            });
        });


        $('.like-button').on('click', function(event) {
            event.preventDefault();

            const postId = $(this).data('post-id');
            const url = `/posts/${postId}/like`;
            const token = '{{ csrf_token() }}';

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: token,
                },
                xhrFields: {
                    withCredentials: true
                },

                success: function(data) {
                    if (data.success) {
                        const iconContainer = $(`#icon-container-${postId}`);
                        const likeCount = $(`#like-count-${postId}`);


                        if (data.liked) {
                            iconContainer.html('<x-fas-heart class="text-red-500" />');
                        } else {
                            iconContainer.html('<x-far-heart />');
                        }
                        likeCount.text(data.like_count);
                    } else {
                        alert('An error occurred.');

                    }
                },
                error: function() {
                    window.location.href = "{{ route('login') }}";
                }
            });
        });
    });

    tinymce.init({
        selector: '#description',
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
    </script>
</body>


</html>
