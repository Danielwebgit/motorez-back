<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Repositories\Contracts\AuthUserRepositoryInterface;

class AuthUserRepository implements AuthUserRepositoryInterface
{
    public function __construct(protected User $model)
    {
    }

    public function saveSessionAndRefreshToken($sessionId, $refreshToken)
    {
        return $this->model->query()->update(['session_id' => $sessionId, 'refresh_token' => $refreshToken]);
    }

}
