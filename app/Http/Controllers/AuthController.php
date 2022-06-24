<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        // validation data
        $data = $request->validated();

        // try auth
        if (!Auth::attempt($data, true)) {
            throw new AuthenticationException();
        }

        // delete other tokens
        \auth()->user()->tokens()->delete();

        // return token
        return response()->json([
            'token' => \auth()->user()->createToken('authorization')->plainTextToken,
        ]);
    }


    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::query()->create([
            ...$data,
            'password' => Hash::make($data['password']),
        ]);

        return new UserResource($user);
    }
}
