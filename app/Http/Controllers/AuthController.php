<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $accessToken = $user->createToken('apiapp');

        $response = [
            'user' => $user,
            'token' => $accessToken
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // check email
        $user = User::where('email', $credentials['email'])->first();

        // check password
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response(['message' => 'Your credentials are not valid.'], 401);
        }

        $accessToken = $user->createToken('apiapp');

        $response = [
            'user' => $user,
            'token' => $accessToken
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return ['message' => 'Logged Out'];
    }
}
