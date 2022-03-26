<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepositoryInterface;

class AuthController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = $this->userRepository->createUser($fields);

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
        $user = $this->userRepository->getUserWithEmail($credentials['email']);

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
