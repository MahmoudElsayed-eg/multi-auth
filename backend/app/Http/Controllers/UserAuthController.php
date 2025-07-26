<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 400);
        }
        $token = $user->createToken('user')->plainTextToken;
        return response()->json(['message' => 'User Logged in successfully', 'token'=> $token]);
    }

    public function logout(Request $request)
    {
        $request->user('user')->currentAccessToken()->delete();
        return response()->json(['message' => 'User Logged out successfully']);
    }
}
