<?php

namespace App\Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../config/config.php';

function generate_jwt($user_id)
{
    $issuedAt = time();
    $expirationTime = $issuedAt + JWT_EXPIRATION_TIME;

    $payload = [
        'iss' => JWT_ISSUER,
        'aud' => JWT_AUDIENCE,
        'iat' => $issuedAt,
        'exp' => $expirationTime,
        'data' => [
            'user_id' => $user_id
        ]
    ];

    // Encode the payload to generate the token
    return JWT::encode($payload, JWT_SECRET_KEY, 'HS256');
}

function decode_jwt($jwt)
{
    try {
        // Decode the token
        $decoded = JWT::decode($jwt, new Key(JWT_SECRET_KEY, 'HS256'));
        return (array) $decoded->data; // Return the user data payload as an array
    } catch (\Exception $e) {
        // Handle exceptions for invalid tokens
        return null;
    }
}
