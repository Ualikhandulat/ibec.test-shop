<?php

namespace App\Http\Controllers;

use App\Http\Requests\Specification\SpecificationStoreRequest;
use App\Http\Resources\SpecificationResource;
use App\Models\Specification;

class SpecificationController extends Controller
{
    public function index()
    {
        $specifications = Specification::all();

        return SpecificationResource::collection($specifications);
    }

    public function store(SpecificationStoreRequest $request)
    {
        $data = $request->validated();

        $specification = Specification::query()->create($data);

        return new SpecificationResource($specification);
    }
}
