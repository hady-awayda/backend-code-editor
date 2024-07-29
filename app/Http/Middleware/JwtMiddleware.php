<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        try {
            $key = config('app.jwt_secret');
            $credentials = JWT::decode($token, new Key($key, 'HS256'));
            Log::info('Decoded JWT: ', (array) $credentials);
            $userId = $credentials->userId;

            $request->merge(['user_id' => $userId]);
        } catch (Exception $e) {
            Log::error('JWT decoding error: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid token: ' . $e->getMessage()], 401);
        }

        return $next($request);
    }
}
