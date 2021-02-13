<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name'  => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
        ]);

        return response()->json([
            'message' => request('name') . ' Berhasil Mendaftar! silahkan login'
        ]);
    }
}
