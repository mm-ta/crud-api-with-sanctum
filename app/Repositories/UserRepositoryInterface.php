<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function createUser($details);
    public function getUserWithEmail($email);
}
