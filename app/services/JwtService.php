<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    public function createToken($user)
    {
        $payload = [
            'iss' => env('APP_URL'),
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + env('JWT_TTL') * 60, // 1hora
        ];

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    public function validateToken($token)
    {
        try {
            return JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        } catch (\Exception $e) {
            return null;
        }
    }
}
