<?php

namespace App\Handlers\User;

use Firebase\JWT\JWT;
use DateTimeImmutable;

class AuthHandler
{
    public function GenerateToken($user)
    {
        $secretKey  = env('JWT_SECRET');
        $tokenId    = base64_encode(random_bytes(16));
        $issuedAt   = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+6 hours')->getTimestamp();     
        $serverName = "code-editor";
        $userID   	= $user->id;
		$role     	= "user";

        $data = [
            'iat'  => $issuedAt->getTimestamp(),
            'jti'  => $tokenId,
            'iss'  => $serverName,
            'nbf'  => $issuedAt->getTimestamp(),
            'exp'  => $expire,
            'userID' => $userID,
            'role' => $role,
        ];

        return JWT::encode(
            $data,      
            $secretKey, 
            'HS256'     
        );
    }
}