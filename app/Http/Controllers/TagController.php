<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Requests\StoreTagRequest;

use App\Http\Resources\TagResource;
use App\Http\Resources\TagCollection;


class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::paginate(10);
        return new TagCollection($tags);
    }

    public function store(StoreTagRequest $request)
    {
        $tag = Tag::create($request->all());
        $tag->posts()->sync($request->posts);
        $tag->products()->sync($request->products);
        return new TagResource($tag);
    }

    public function show(Tag $tag)
    {
        return new TagResource($tag);
    }

    public function update(StoreTagRequest $request, Tag $tag)
    {
        $tag->update($request->all());
        $tag->posts()->sync($request->posts);
        $tag->products()->sync($request->products);
        return new TagResource($tag);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response(null, 202);
    }
}
