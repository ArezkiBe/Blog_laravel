<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'replies.user')->get();
        return view('posts.index', compact('posts'));
    }

    public function dashboard()
    {
        $posts = Post::where('user_id', Auth::id())->with('replies.user')->get();
        return view('dashboard', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::id();
        $post->save();

        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {
        $post->load('replies.user');
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }

    public function upvote(Post $post)
    {
        $this->toggleVote($post, 'upvote');
        return back()->with('status', 'Vote updated successfully!');
    }

    public function downvote(Post $post)
    {
        $this->toggleVote($post, 'downvote');
        return back()->with('status', 'Vote updated successfully!');
    }

    private function toggleVote(Post $post, $type)
    {
        $user = Auth::user();
        $existingVote = $user->votes()->where('post_id', $post->id)->first();

        if ($existingVote) {
            if ($existingVote->type === $type) {
                // If the same vote type is clicked again, remove the vote
                $existingVote->delete();
            } else {
                // If a different vote type is clicked, update the vote type
                $existingVote->update(['type' => $type]);
            }
        } else {
            // If no existing vote, create a new vote
            $user->votes()->create([
                'post_id' => $post->id,
                'type' => $type,
            ]);
        }
    }
}
