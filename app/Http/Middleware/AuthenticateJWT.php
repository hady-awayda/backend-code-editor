<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticateJWT
{
    public function handle($request, Closure $next) : Response
    {
        if (! $user = Auth::guard('api')->user()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->merge(['user_id' => $user->id]);

        return $next($request);
    }
}