<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Repositories\Contracts\AuthUserRepositoryInterface;

class AuthUserRepository implements AuthUserRepositoryInterface
{
    public function __construct(protected User $model)
    {
    }

    public function authUserLogin($data)
    {
        dd("Fazendo login");
    }

   
}
