<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class UserController extends Controller
{
    public function Login(Request $req)
    {
        $req->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (
            !Auth::attempt([
                'username' => $req->username,
                'password' => $req->password
            ])
        ) {
            return response()->json([
                'message' => 'Hibás felhasználónév vagy jelszó'
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('api-token', ['*'], now()->addHour())->plainTextToken;

        return response()->json([
            'message' => 'Sikeres bejelentkezés',
            'token' => $token
        ], 200);
    }

    public function Reg(Request $req)
    {
        $req->validate([
            'username' => ['required', 'between:5,255', 'string'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        if (User::where('username', $req->username)->exists()) {
            return response()->json([
                'message' => 'A felhasználónév már foglalt'
            ], 409);
        }

        $data = new User();
        $data->username = $req->username;
        $data->password = Hash::make($req->password);
        $data->save();

        return response()->json([
            'message' => 'Sikeres regisztráció'
        ], 201);
    }
    // public function Registration(Request $req)
    // {
    //     $req->validate([
    //         'username' => ['required', 'unique:user,username', 'between:5,255', 'string'],
    //         'password' => [
    //             'required',
    //             Password::min(4)
    //                 ->max(255)
    //                 ->mixedCase()
    //                 ->letters(),
    //             // 'confirmed',
    //         ],
    //         // 'password_confirmation' => 'required',
    //         // 'permission' => 'required|in:u,a'
    //     ]);

    //     // TODO: if('name')
    //     //    -> 'A
    //     // felhasználónév
    //     // már
    //     // foglalt'

    //     $data = new User();
    //     $data->username = $req->username;
    //     $data->password = Hash::make($req->password);
    //     // $data->permission = $req->permission;
    //     $data->save();

    //     return response()->json([
    //         'message' => 'Sikeres regisztráció'
    //     ], 201);
    // }

    public function Logout(Request $req)
    {
        $req->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Kijelentkezve'
        ], 200);
    }
}
