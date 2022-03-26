<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function createUser($details)
    {
        return User::create([
            'name' => $details['name'],
            'email' => $details['email'],
            'password' => bcrypt($details['password']),
        ]);
    }

    public function getUserWithEmail($email)
    {
        return User::where('email', $email)->first();
    }
}
