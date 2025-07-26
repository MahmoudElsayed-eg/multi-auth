<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $admin = Admin::where('email', $request->email)->first();
        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Invalid credentials'], 400);
        }
        $token = $admin->createToken('admin')->plainTextToken;
        return response()->json(['message' => 'Admin Logged in successfully', 'token'=> $token]);
    }

    public function logout(Request $request)
    {
        $request->user('admin')->currentAccessToken()->delete();
        return response()->json(['message' => 'Admin Logged out successfully']);
    }
}
