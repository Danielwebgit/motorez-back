<?php

namespace App\Services;

use App\Repositories\Eloquents\AuthUserRepository;


class AuthUserService
{
    public function __construct(
        private AuthUserRepository $authUserRepository
    ) {
    }

    public function authUserLogin($formData)
    {
        return $this->authUserRepository->authUserLogin($formData);
    }
}