<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function Login(Request $req)
    {
        $req->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (
            !Auth::attemp([
                'username' => $req->username,
                'password' => $req->password
            ])
        ) {
            return response()->json([
                'message' => 'Nem sikerült belépni'
            ], 403);
        }
        $user = Auth::user();

        $token = $user->createToken('api-token', ['*'], now()->addHour())->plainTextToken;

        return response()->json([
            'message' => 'Sikeres belépés',
            'token' => $token,
            'user' => new UserResource($user)

        ], 200);
    }

    public function Logout(Request $req)
    {
        $req->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Kijelentkezve'
        ], 200);
    }
}