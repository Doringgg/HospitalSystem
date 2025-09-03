<?php

use Firebase\JWT\MyTokenJWT;

require_once "api/src/HttpResponse.php";

require_once "api/src/utils/MyTokenJWT.php";

class JWTMiddleware{
    function getAuthorizationHeader(): string|null
    {
        $headers = null;

        if(isset($_SERVER['Authorization'])) {
            $headers = trim ($_SERVER['Authorization']);
        }elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER['HTTP_AUTHORIZATION']);        
        }elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_change_key_case($requestHeaders, CASE_LOWER);
            if (isset($requestHeaders['authorization'])) {
                $headers = trim($requestHeaders['authorization']);
            }
        }
        return $headers;
    }

    public function isValidToken(): stdClass
    {
        $token = $this->getAuthorizationHeader();

        if(!isset($token)) {
            (new Response(
                success: false,
                message: 'Invalid Token',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'It was not given a token'
                ],
                httpCode: 401
            ))->send();
            exit();
        }

        $JWT = new MyTokenJWT();

        if($JWT->validateToken($token)){
            return $JWT->getPayload();
        } else {
            (new Response(
                success: false,
                message: 'Invalid Token',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'The given token is not valid'
                ],
                httpCode: 401
            ))->send();
            exit();
        }

    }
}