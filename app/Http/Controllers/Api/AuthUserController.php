<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\AuthUserService;

class AuthUserController extends Controller
{

    public function __construct(private AuthUserService $authUserService)
    {}

    /**
     * Display a listing of the resource.
     */
    public function login(UserRequest $request)
    {
        $response = $this->authUserService->authUserLogin($request);
        return response()->json([$response]);
    }


}
