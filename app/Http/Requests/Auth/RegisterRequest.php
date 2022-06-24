<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:70|unique:users',
            'password' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
        ];
    }
}
