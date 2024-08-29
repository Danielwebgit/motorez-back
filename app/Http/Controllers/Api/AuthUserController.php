<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\AuthUserService;
use Illuminate\Http\Client\Request;

class AuthUserController extends Controller
{

    public function __construct(private AuthUserService $authUserService) {}

    /**
     * Display a listing of the resource.
     */
    public function login(UserRequest $request)
    {
        try {

            $response = $this->authUserService->authUserLogin($request);

            return response()->json($response);
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 422);
        }
    }

    public function logout()
    {
        return $this->authUserService->authUserLogout();
    }
}
