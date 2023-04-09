<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Color;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('colors')->paginate(10);
        return new ProductCollection($products);
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());



        $product->colors()->sync($request->colors);
        $product->tags()->sync($request->tags);

        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $product->update($request->all());
        $product->colors()->sync($request->colors);
        $product->tags()->sync($request->tags);
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response(null, 202);
    }
}
