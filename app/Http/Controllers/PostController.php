<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection(Post::query()->paginate());
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        if (array_key_exists('picture', $data)) {
            $image_path = Storage::disk('public')->put('/images', $data['picture']);
            $data['picture'] = url('/storage/' . $image_path);
        }

        $post = Post::query()->create($data);

        return PostResource::make($post);
    }

    public function show(Post $post)
    {
        return PostResource::make($post);
    }

    public function update(Post $post, UpdatePostRequest $request)
    {
        $data = $request->validated();

        if (array_key_exists('picture', $data)) {
            $image_path = Storage::disk('public')->put('/images', $data['picture']);
            $data['picture'] = url('/storage/' . $image_path);
        }

        $post->update($data);

        return PostResource::make($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json('Post deleted');
    }
}
