<?php

namespace App\Http\Controllers;


use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->paginate();

        return ProductResource::collection($products);
    }

    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();

        $product = Product::query()->create($data);

        $specifications = [];
        foreach ($data['specifications'] as $spec) {
            $specifications[$spec['id']] = ['value' => $spec['value']];
        }

        $product->specifications()->attach($specifications);

        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource(
            $product->load('catalog')
        );
    }
}
