<?php

namespace App\Repositories\Contracts;

interface AuthUserRepositoryInterface
{
    public function authUserLogin($data);
}