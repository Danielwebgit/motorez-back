<?php

namespace App\Repositories\Contracts;

interface AuthUserRepositoryInterface
{
    public function saveSessionAndRefreshToken($sessionId, $refreshToken);
}