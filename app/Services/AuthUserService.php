<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Eloquents\AuthUserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
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

        $expiresAt = Carbon::now()->addDays(30);

        $host = Request::getHost();
        $tenantId = explode('.', $host)[0];

        $customClaims = $this->customClaims($tenantId, $user, $expiresAt);

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

    public function customClaims($tenantId, $user, $expiresAt)
    {
        return [
            'tenant_id' => $tenantId,
            'iss' => url('/api/v1/auth/user/login'),
            'sub' => $user->getAuthIdentifier(),
            'exp' => $expiresAt,
            'iat' => Carbon::now()->timestamp,
        ];
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

    public function refreshToken($data)
    {
        $sessionId = $data['session_id'] ?? null;

        if (!$sessionId) {
            return response()->json(['message' => 'Session id não encontrado'], 401);
        }

        $user = User::where('session_id', $sessionId)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado.'], 401);
        }

        try {
            JWTAuth::setToken($user->refresh_token)->checkOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['message' => 'Refresh token expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['message' => 'Invalid refresh token'], 401);
        }

        $expiresAt = Carbon::now()->addDays(30);

        $host = Request::getHost();
        $tenantId = explode('.', $host)[0];

        $customClaims = $this->customClaims($tenantId, $user, $expiresAt);

        $payload = JWTFactory::customClaims($customClaims)->make();

        $refreshToken = JWTAuth::encode($payload)->get();

        $sessionId = Str::uuid()->toString();

        $this->authUserRepository->saveSessionAndRefreshToken($sessionId, $refreshToken);

        $accessToken = JWTAuth::fromUser($user);

        return response()->json([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'session_id' => $sessionId
        ]);
    }

    public function authUserLogout()
    {
        auth()->logout();
        return response()->json(['message' => 'Deslogado com sucesso!']);
    }
}
