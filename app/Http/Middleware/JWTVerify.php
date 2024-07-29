<?php

namespace App\Http\Middleware;

use App\Helpers\Auth\AuthHelper;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use DateTimeImmutable;
use Exception;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JWTVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) : Response
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