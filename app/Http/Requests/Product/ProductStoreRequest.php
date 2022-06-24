<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            // принадлежат к одной из категорий второго/третьего уровня
            'catalog_id' => [
                'required', 'integer', Rule::exists('catalogs', 'id')->whereIn('level', [2, 3])
            ],
            'title' => 'required|string|max:255|unique:products',
            'description' => 'required|string|max:5000',
            'price' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'catalog_id.exists' => 'Выберите категорию второго/третьего уровня',
        ];
    }
}
