<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('Token de ' . $user->name)->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'message' => 'No autorizado'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('Token de ' . $user->name)->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'Sesión cerrada'
        ]);
    }

    public function whoami()
    {
        return response([
            'user' => auth()->user()
        ]);
    }
}
