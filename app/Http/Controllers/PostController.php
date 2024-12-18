<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('pages.dashboard', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::with(['comments.user', 'likes'])->findOrFail($id);
        return view('pages.post', compact('post')); // Use 'post' as the variable to pass
    }

    public function admin()
    {
        $posts = Post::all();
        return view('pages.dashboardAdmin', compact('posts'));
    }

    public function edit(Post $post)
    {
        return view('pages.editPost', compact('post'));
    }

    public function create()
    {
        return view('pages.createPost');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->query('search');

        if ($searchTerm) {
            $posts = Post::where('title', 'like', '%' . $searchTerm . '%')
                ->orWhere(
                    'description',
                    'like',
                    '%' . $searchTerm . '%'
                )
                ->get();
        } else {
            $posts = Post::all();
        }

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials._post-list', compact('posts'))->render()
            ]);
        }

        return view('pages.dashboard', compact('posts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
        ]);

        // Save image
        $imagePath = $request->file('image')->store('images', 'public');

        Post::create([
            'title' => $validated['title'],
            'image' => $imagePath,
            'description' => $validated['description'],
        ]);

        return redirect()->route('pages.dashboardAdmin');
    }



    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5120', // Optional image field
        ]);

        $post->title = $validated['title'];
        $post->description = $validated['description'];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $post->image = $path;
        }

        $post->save();

        return redirect()->route('pages.dashboardAdmin')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        Storage::disk('public')->delete($post->image);
        $post->delete();

        return redirect()->back()->with('success', 'Post deleted successfully.');
    }



    public function like($id)
    {
        $post = Post::findOrFail($id);

        if (Auth::user()->role !== 'student') {
            return redirect()->back()->with('error', 'Only students can like on posts.');
        }

        $like = Like::where('post_id', $id)->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create([
                'post_id' => $post->id,
                'user_id' => Auth::id(),
            ]);
            $liked = true;
        }

        $likeCount = $post->likes()->count();

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'like_count' => $likeCount,
        ]);
    }


    public function comment(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::user()->role !== 'student') {
            return redirect()->back()->with('error', 'Only students can like on posts.');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $validated['content'],
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }
}