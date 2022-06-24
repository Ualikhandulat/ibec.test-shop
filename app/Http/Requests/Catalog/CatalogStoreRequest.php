<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CatalogStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:255|unique:catalogs',
            'parent_id' => [
                'nullable', 'present', 'integer', Rule::exists('catalogs', 'id')->whereIn('level', [1, 2])
            ],
        ];
    }
}
