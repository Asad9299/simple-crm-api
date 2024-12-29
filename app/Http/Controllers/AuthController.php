<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        # Create User
        $user = User::add([
            'uuid'     => Str::uuid(),
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
        ]);

        # Generate Sanctum Token
        $user->token = $user->createToken($data['name'])->plainTextToken;

        return (new UserResource($user))->additional([
            'message' => __('auth.register_success')
        ]);
    }
}
