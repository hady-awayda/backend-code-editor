<?php

namespace App\Handlers\Admin;

use Firebase\JWT\JWT;
use DateTimeImmutable;

class AuthHandler
{
    /**
     * Handles operations related to user authentication
     */

    public function GenerateToken($user)
    {
        $secretKey  = env('JWT_SECRET');
        $tokenId    = base64_encode(random_bytes(16));
        $issuedAt   = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+6 months')->getTimestamp();     
        $serverName = "code-editor";
        $userID   	= $user->id;                                    
		$role     	= "user";

        $data = [
            'iat'  => $issuedAt->getTimestamp(),    
            'jti'  => $tokenId,                     
            'iss'  => $serverName,                  
            'nbf'  => $issuedAt->getTimestamp(),    
            'exp'  => $expire,                      
            'data' => [                             
                'userID' => $userID,   
                'role' => $role,         
            ]
        ];

        $token = JWT::encode(
            $data,      
            $secretKey, 
            'HS512'     
        );
        return $token;
    }
}