<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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

        } catch (\Exception $e) {

            return match (true) {
                $e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException => 
                    response()->json(['status' => 'Token is Invalid'], 401),
                $e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException => 
                    response()->json(['status' => 'Token is Expired'], 401),
                default =>  response()->json(['status' => 'Authorization Token not found']),
            };
        }
        
        return $next($request);
    }
}
