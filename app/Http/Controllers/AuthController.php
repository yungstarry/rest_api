<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);


        if (!Auth::attempt($credentials, $remember)) {
            return response()->json([
                'error' => 'Invalid login details'
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'access token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();

            $user = User::create($data);

            $token = $user->createToken('api_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Error Creating user: ' . $e->getMessage());
            return response([
                'error' => 'There was an error processing your request.'
            ], 500);
        }
    }
}
