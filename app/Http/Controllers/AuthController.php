<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        if(!auth()->attempt($credentials)) {
            return response()->json(['error' => 'Entered email or password is wrong'], 401);
        }
        $user = auth()->user();
        $token = $user->createToken('app_token')->plainTextToken;

        return response()->json([
            'message' => 'Logged in successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);

    }

    public function register(Request $request)
    {
        $user_info = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string'
        ]);
        User::create($user_info);
        return response()->json([
            'message' => 'Registered successfully',
        ]);
    }
}
