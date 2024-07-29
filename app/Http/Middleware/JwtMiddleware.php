<?php

namespace App\Http\Middleware;

use App\Helpers\Auth\AuthHelper;
use Closure;
use Exception;
use Illuminate\Http\Request;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $publicHelper = new AuthHelper();

        try {
            $user = $publicHelper->GetAuthUser();

            $request->merge(['user_id' => $user->id]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        return $next($request);
    }
}