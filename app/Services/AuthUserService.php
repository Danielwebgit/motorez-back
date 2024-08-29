<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

use App\Repositories\Eloquents\AuthUserRepository;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Illuminate\Support\Str;

class AuthUserService
{
    public function __construct(
        private AuthUserRepository $authUserRepository
    ) {}

    public function authUserLogin($formData)
    {
        $email = $formData->input('email');
        $password = $formData->input('password');

        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        if (!$user || !password_verify($password, $user->getAuthPassword())) {
            return throw new \Exception('Credenciais inválidas');
        }

        $refreshTTL = config('jwt.refresh_ttl');
        $expiresAt = Carbon::now()->addMinutes($refreshTTL);

        $expiresAt = Carbon::now()->addDays(30);

        $customClaims = [
            'iss' => url('/api/v1/auth/user/login'),
            'sub' => $user->getAuthIdentifier(),
            'exp' => $expiresAt->timestamp,
            'iat' => Carbon::now()->timestamp,
        ];

        $payload = JWTFactory::customClaims($customClaims)->make();

        $refreshToken = JWTAuth::encode($payload)->get();

        $sessionId = Str::uuid()->toString();

        $this->authUserRepository->saveSessionAndRefreshToken($sessionId, $refreshToken);

        $token = [
            'access_token' => auth('api')->attempt($credentials),
            'session_id' => $sessionId
        ];

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'id' => auth()->id(),
            'email' => Auth::user()->email,
            'name' => Auth::user()->name,
            'cpf' => Auth::user()->cpf_cnpj,
            'access_token' => $token['access_token'],
            'session_id' => $token['session_id'],
            'token_type' => 'bearer',
            'expires_in' => 86400,

        ]);
    }

    public function authUserLogout()
    {
        auth()->logout();
        return response()->json(['message' => 'Deslogado com sucesso!']);
    }
}
