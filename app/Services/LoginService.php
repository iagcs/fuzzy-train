<?php

namespace App\Services;


use App\Exceptions\UserLoginDataIncorrect;
use App\Models\User;

class LoginService
{
    public function getUser(array $loginData)
    {
        return User::query()
            ->where('email', $loginData['email'])
            ->where('password', $loginData['password'])
            ->firstOr(static fn() => abort(404, 'User password is incorrect.'));
    }
}
