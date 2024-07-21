<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $reply = new Reply();
        $reply->content = $request->content;
        $reply->user_id = Auth::id();
        $reply->post_id = $post->id;
        $reply->parent_id = null;  // Pas de parent_id pour les réponses aux posts
        $reply->save();

        return redirect()->route('posts.show', $post);
    }

    public function storeReplyToReply(Request $request, Post $post, Reply $parentReply)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $reply = new Reply();
        $reply->content = $request->content;
        $reply->user_id = Auth::id();
        $reply->post_id = $post->id;
        $reply->parent_id = $parentReply->id;  // Définir le parent_id pour les réponses aux réponses
        $reply->save();

        return redirect()->route('posts.show', $post);
    }
}

