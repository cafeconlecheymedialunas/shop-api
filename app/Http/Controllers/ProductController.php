<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('colors',"tags","categories","ratings","orders")->paginate(10);
        return new ProductCollection($products);
    }

    public function store(StoreProductRequest $request)
    {  

        $product = new Product();
        $product->title = $request->title;
        $product->price = $request->price;
        $product->sale_price = $request->sale_price;
        $product->size = $request->size;
        $product->description = $request->description;
        $product->additional_info = $request->additional_info;
        $product->tech_details = $request->tech_details;

        $product->save();

        $product->colors()->sync($request->colors);
        $product->categories()->sync($request->categories);
        $product->tags()->sync($request->tags);

        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $product->title = $request->title;
        $product->price = $request->price;
        $product->sale_price = $request->sale_price;
        $product->size = $request->size;
        $product->description = $request->description;
        $product->additional_info = $request->additional_info;
        $product->tech_details = $request->tech_details;

        $product->save();

        $product->colors()->sync($request->colors);
        $product->categories()->sync($request->categories);
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
