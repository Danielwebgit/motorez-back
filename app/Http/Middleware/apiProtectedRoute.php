<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class apiProtectedRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {

            JWTAuth::parseToken()->authenticate();
            
            $tokenTenantId = JWTAuth::getPayload()->get('tenant_id');

            $host = FacadesRequest::getHost();
            $currentTenantId = explode('.', $host)[0];

            if ($tokenTenantId !== $currentTenantId) {
                return response()->json(['error' => 'Token is Invalid'], 401);
            }

        } catch (\Exception $e) {

            return match (true) {
                $e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException => 
                    response()->json(['status' => 'Token is Invalid'], 401),
                $e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException => 
                    response()->json(['status' => 'Token is Expired'], 401),
                $e instanceof \Tymon\JWTAuth\Exceptions\JWTException => 
                    response()->json(['status' => 'Authorization Token not found'], 401),
                default => 
                    response()->json(['status' => 'An error occurred while processing the token'], 500),
            };
        }
        
        return $next($request);
    }
}
