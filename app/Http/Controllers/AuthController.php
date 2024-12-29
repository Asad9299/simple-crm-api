<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Log\LoggerInterface;

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

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $remember = $data['remember_token'];

        unset($data['remember_token']);

        if (Auth::attempt($data, $remember)) {
            $user = Auth::user();
            // Generate Sanctum token
            $user->token = $user->createToken($user->name)->plainTextToken;

            return (new UserResource($user))->additional([
                'message' => __('auth.login_success')
            ]);
        }
        return response([
            'error' => __('auth.invalid_credentials')
        ], 401);
    }
}
