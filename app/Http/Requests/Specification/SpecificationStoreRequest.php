<?php

namespace App\Http\Requests\Specification;

use Illuminate\Foundation\Http\FormRequest;

class SpecificationStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:255|unique:specifications',
        ];
    }
}
