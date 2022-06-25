<?php

namespace App\Http\Controllers;

use App\Http\Helpers\CatalogHelper;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Resources\ProductResource;
use App\Models\Catalog;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $search = mb_substr(request()->get('search'), 0, 20);
        $catalog = intval(request()->get('catalog'));

        $products = Product::query()
            ->search($search)
            ->catalog($catalog)
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
