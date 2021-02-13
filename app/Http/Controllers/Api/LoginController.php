<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        $this->validate(request(), [
            'email' => 'required|min:3',
            'password' => 'required|min:6'
        ]);

        $user = User::where('email', request('email'))->first();
        if (!$user || !Hash::check(request('password'), $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'email dan password salah'
            ], 404);
        }

        $token = $user->createToken('ApiToken')->plainTextToken;
        $response = [
            'success' => true,
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'success' => true
        ], 200);
    }
}
