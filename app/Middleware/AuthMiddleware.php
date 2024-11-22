<?php

namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Response $response)
    {
        // Handling authentication using Session 
        // if (!Session::has("USER_ID")) {
        //     $response->jsonResponse(['error' => 'Unauthorized'], 401);
        // }

        // Handling JWT token 
        // // Get the Authorization header
        // $authHeader = $request->getHeader('Authorization');

        // if (!$authHeader) {
        //     return $response->jsonResponse(['error' => 'Authorization header is missing'], 401);
        // }

        // // Extract the token from the Authorization header
        // $matches = [];
        // if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        //     $jwt = $matches[1];
        // } else {
        //     return $response->jsonResponse(['error' => 'Invalid Authorization header format'], 401);
        // }

        // // Decode the JWT and verify it
        // $decoded = JwtFunctions::decode_jwt($jwt);

        // if ($decoded === null) {
        //     return $response->jsonResponse(['error' => 'Invalid or expired token'], 401);
        // }

        // // Attach the user ID from the JWT to the request for later use
        // $request->user_id = $decoded['user_id'];

        return;
    }
}
