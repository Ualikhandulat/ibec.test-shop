<?php

namespace App\Http\Controllers;

use App\Http\Requests\Catalog\CatalogStoreRequest;
use App\Http\Resources\CatalogResource;
use App\Models\Catalog;

class CatalogController extends Controller
{
    public function index()
    {
        $catalogs = Catalog::query()
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        return CatalogResource::collection($catalogs);
    }

    public function store(CatalogStoreRequest $request)
    {
        $data = $request->validated();

        // определяем уровень
        $level = 1;
        if ( $data['parent_id'] ) {
            $level = Catalog::query()->where('id', $data['parent_id'])->first()->level + 1;
        }

        $catalog = Catalog::query()->create([
            ...$data,
            'level' => $level,
        ]);

        return new CatalogResource($catalog);
    }
}
