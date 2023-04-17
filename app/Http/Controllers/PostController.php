<?php

namespace App\Http\Controllers;


use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\User;
use App\Models\Comment;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(10);
        return new PostCollection($posts);
    }

    public function store(StorePostRequest $request)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;

        $user = User::find($request->user);
        $post->user()->associate($user);


        $post->save();

        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);


        return new PostResource($post);
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function update(StorePostRequest $request, Post $post)
    {
        $post->title = $request->title;
        $post->content = $request->content;

        $user = User::find($request->user);
        $post->user()->associate($user);

        $post->save();


   
        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);


        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response(null, 202);
    }
}
