<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return new CategoryCollection($categories);
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->all());
        $category->posts()->sync($request->posts);
        $category->products()->sync($request->products);
        return new CategoryResource($category);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->all());
        $category->posts()->sync($request->posts);
        $category->products()->sync($request->products);
        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response(null, 202);
    }
}
