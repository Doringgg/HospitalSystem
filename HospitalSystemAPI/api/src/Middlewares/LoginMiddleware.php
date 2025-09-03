<?php

require_once "api/src/HttpResponse.php";

class LoginMiddleware
{
    public function stringJsonToStdClass($requestBody): stdClass
    {
        
        $stdLogin = json_decode($requestBody);

        if (json_last_error() !== JSON_ERROR_NONE) {
            (new Response(
                success: false,
                message: 'Invalid Json',
                error: [
                    'code' => 'validation_error',
                    'message' => 'The JSON given is not valid'
                ],
                httpCode: 400
            ))->send();
            exit();
        
        } else if(!isset($stdLogin->user)) {
            (new Response(
                success: false,
                message: 'Invalid login',
                error: [
                    'code' => 'validation_error',
                    'message' => 'It was not send a object "user"'
                ],
                httpCode: 400
            ))->send();
            exit();
            
        } else if(!isset($stdLogin->user->email)) {
            (new Response(
                success: false,
                message: 'Invalid login',
                error: [
                    'code' => 'validation_error',
                    'message' => 'It was not send a email'
                ],
                httpCode: 400
            ))->send();
            exit();
    
        } else if(!isset($stdLogin->user->password)) {
            (new Response(
                success: false,
                message: 'Invalid login',
                error: [
                    'code' => 'validation_error',
                    'message' => 'It was not send a password'
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        return $stdLogin;
    }

    public function isValidEmail($email): self
    {
        if (!isset($email)) {
            (new Response(
                success: false,
                message: 'Invalid Email',
                error: [
                    'code' => 'validation_error',
                    'message' => 'The email was not sent'
                ],
                httpCode: 400
            ))->send();
            exit();
        } else if (strlen(string: $email) < 5) {
            (new Response(
                success: false,
                message: 'Invalid Email',
                error: [
                    'code' => 'validation_error',
                    'message' => 'The email needs to be at least 5 characters long'
                ],
                httpCode: 400
            ))->send();
            exit();
        } else if (!filter_var(value: $email, filter: FILTER_VALIDATE_EMAIL)) {
            (new Response(
                success: false,
                message: 'Invalid Email',
                error: [
                    'code' => 'validation_error',
                    'message' => 'The email is not in a valid format'
                ],
                httpCode: 400
            ))->send();
            exit();
        }
        return $this;
    }
    public function isvalidSenha(string $password): self
    {
        // Verifica se a password está vazia
        if (!isset($password)) {
            (new Response(
                success: false,
                message: 'Invalid Password',
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'Password is empty',
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        // Verifica o comprimento mínimo
        if (strlen($password) < 8) {
            (new Response(
                success: false,
                message: 'Invalid Password',
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'Password needs to be at least 8 characters long',
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        // Verifica se contém pelo menos uma letra maiúscula
        if (!preg_match(pattern: '/[A-Z]/', subject: $password)) {
            (new Response(
                success: false,
                message: 'Invalid Password',
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'Password should contain at least one capital letter',
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        // Verifica se contém pelo menos uma letra minúscula
        if (!preg_match('/[a-z]/', $password)) {
            (new Response(
                success: false,
                message: 'Invalid Password',
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'Password should contain at least one lowercase letter',
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        // Verifica se contém pelo menos um número
        if (!preg_match('/[0-9]/', $password)) {
            (new Response(
                success: false,
                message: 'Invalid Password',
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'Password should contain at least one number',
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        // Verifica se contém pelo menos um caractere especial
        if (!preg_match('/[\W_]/', $password)) {
            (new Response(
                success: false,
                message: 'Invalid Password',
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'Password should contain at least one special character',
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        return $this;
    }
}