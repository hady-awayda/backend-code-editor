<?php

namespace App\Helpers\Auth;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use DateTimeImmutable;
use App\Models\User;

class AuthHelper 
{
    public function GetRawJWT()
    {
        if (empty($_SERVER['HTTP_AUTHORIZATION'])) {
            throw new Exception('Authorization header not found', 401);
        }

        if (!preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
            throw new Exception('Token not found', 401);
        }

        $jwt = $matches[1];

        if (!$jwt) {
            throw new Exception('Could not extract token', 401);
        }

        return $jwt;
    }

    public function DecodeRawJWT($jwt)
    {
        $secretKey = env('JWT_SECRET');
        
        try {
            $token = JWT::decode($jwt, new Key($secretKey, 'HS512'));
        }
        catch (Exception $e) {
            throw new Exception('Unauthorized', 401);
        }

        return $token;
    }

    public function GetAuthUser()
    {
        $jwt = $this->GetRawJWT();
        $token = $this->DecodeRawJWT($jwt);
        $userID = $token->userID;

        $user = User::find($userID);

        if (!$user) {
            throw new Exception('User not found', 404);
        }

        return $user;
    }
}