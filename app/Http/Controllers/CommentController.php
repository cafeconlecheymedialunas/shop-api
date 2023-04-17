<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentCollection;
use App\Models\Comment;
use App\Models\User;
use App\Http\Resources\CommentResource;
use App\Models\Post;

class CommentController extends Controller
{
    public function index()
    {
        $categories = Comment::with("post", "user")->paginate(10);
        return new CommentCollection($categories);
    }

    public function store(CommentRequest $request)
    {
        $comment = new Comment();
        $comment->title = $request->title;
        $comment->comment = $request->comment;

        $comment->user()->associate(User::find($request->user));
        $comment->post()->associate(Post::find($request->post));
        //$comment->save();
        return new CommentResource($comment);
    }

    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->title = $request->title;
        $comment->comment = $request->comment;

        $comment->user()->associate(User::find($request->user));
        $comment->post()->associate(Post::find($request->post));
        //$comment->save();
        return new CommentResource($comment);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response(null, 202);
    }
}
