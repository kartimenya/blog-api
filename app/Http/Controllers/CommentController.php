<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\CommentStoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function show(Post $post)
    {
        return $post->comments;
    }

    public function store(CommentStoreRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['post_id'] = $post->id;

        $comment = Comment::query()->create($data);

        return CommentResource::make($comment);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json('comment deleted');
    }
}
