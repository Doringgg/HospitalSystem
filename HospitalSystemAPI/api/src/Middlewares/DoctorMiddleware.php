<?php
require_once "api/src/HttpResponse.php";

class DoctorMiddleware{

    public function stringJsonToStdClass($requestBody): stdClass
    {
        $stdDoctor = json_decode($requestBody);

        if(json_last_error() !== JSON_ERROR_NONE) {
            
            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Invalid Json'
                ],
                httpCode: 400
            ))->send();
            
            exit();
        
        } else if (!isset($stdDoctor->doctor)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Object Doctor was not send'
                ],
                httpCode: 400
            ))->send();

            exit();

        } else if (!isset($stdDoctor->doctor->doctorName)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Doctor name was not send'
                ],
                httpCode: 400
            ))->send();

            exit();
            
        } else if (!isset($stdDoctor->doctor->doctorDOB)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Doctor DOB was not send'
                ],
                httpCode: 400
            ))->send();

            exit();
            
        } else if (!isset($stdDoctor->doctor->doctorEmail)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Doctor Email was not send'
                ],
                httpCode: 400
            ))->send();

            exit();
            
        } else if (!isset($stdDoctor->doctor->doctorPhoneNum)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Doctor Phone Number was not send'
                ],
                httpCode: 400
            ))->send();

            exit();
            
        } else if (!isset($stdDoctor->doctor->doctorCPF)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Doctor CPF was not send'
                ],
                httpCode: 400
            ))->send();

            exit();
            
        } else if (!isset($stdDoctor->doctor->doctorPassword)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Doctor Password was not send'
                ],
                httpCode: 400
            ))->send();

            exit();
            
        }

        return $stdDoctor;
    }

    public function isValidDoctorName(string $doctorName): self
    {
        $doctorName = trim($doctorName);

        if(strlen($doctorName) < 3){

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Doctor Name can not be null or be less than 3 letters lengthy'
                ],
                httpCode: 400
            ))->send();

            exit();

        }

        if(preg_match('/\d/',$doctorName)){

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Doctor Name can not contain numbers'
                ],
                httpCode: 400
            ))->send();

            exit();

        }

        if(preg_match('/[-@_=+#$%&*.()]/',$doctorName)){

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Doctor Name can not contain numbers'
                ],
                httpCode: 400
            ))->send();

            exit();

        }
        
        return $this;

    }

    public function isValidID($doctorID): self
    {
        if (!isset($doctorID)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Doctor ID was not send'
                ],
                httpCode: 400
            ))->send();

            exit();
            
        }

        if (!is_numeric($doctorID)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'ID given is not valid'
                ],
                httpCode: 400
            ))->send();

            exit();

        }

        if ($doctorID <= 0) {
            
            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'ID given is not valid'
                ],
                httpCode: 400
            ))->send();

            exit();
        }

        $doctorDAO = new DoctorDAO();
        
        return $this;
    }

    public function isValidEmail($doctorEmail): self
    {
        
        if(strlen($doctorEmail) < 5){
            
            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Email is not valid'
                ],
                httpCode: 400
            ))->send();

            exit();
        }
        
        if (!filter_var($doctorEmail, FILTER_VALIDATE_EMAIL)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Email is not valid'
                ],
                httpCode: 400
            ))->send();

            exit();

        }
        
        return $this;
    }

    public function isValidPhoneNum($doctorPhoneNum): self{

        if(strlen( $doctorPhoneNum) < 9){

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Phone Number is not valid'
                ],
                httpCode: 400
            ))->send();

            exit();

        }

        if(preg_match('/[A-Z]/', $doctorPhoneNum)) {
            
            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Phone Number is not valid'
                ],
                httpCode: 400
            ))->send();

            exit();

        }

        if(preg_match('/[a-z]/', $doctorPhoneNum)) {
            
            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Phone Number is not valid'
                ],
                httpCode: 400
            ))->send();

            exit();

        }

        return $this;
    }

    public function isValidDOB($doctorDOB): self
    {
        if(strlen($doctorDOB) < 8  || strlen($doctorDOB) > 10){

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Date of birth is not valid'
                ],
                httpCode: 400
            ))->send();

            exit();

        }

        if(preg_match('/[A-Z]/', $doctorDOB)) {
            
            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Date of birth is not valid'
                ],
                httpCode: 400
            ))->send();

            exit();

        }

        if(preg_match('/[a-z]/', $doctorDOB)) {
            
            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Date of birth is not valid'
                ],
                httpCode: 400
            ))->send();

            exit();

        }

        if(preg_match('/[-@_=+#$%&*.()]/', $doctorDOB)) {
            
            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Date of birth is not valid'
                ],
                httpCode: 400
            ))->send();

            exit();

        }

        return $this;
    }

    public function isValidCPF($doctorCPF): self
    {

        if(strlen($doctorCPF) < 11  || strlen($doctorCPF) > 14) {
            
            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'CPF is not valid'
                ],
                httpCode: 400
            ))->send();

            exit();

        } 
        
        if(preg_match('/[a-z]/', $doctorCPF)) {
            
            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'CPF is not valid'
                ],
                httpCode: 400
            ))->send();

            exit();

        } 

        if(preg_match('/[A-Z]/', $doctorCPF)) {
            
            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'CPF is not valid'
                ],
                httpCode: 400
            ))->send();

            exit();

        }

        if(preg_match('/[-@_=+#$%&*.()]/', $doctorCPF)) {
            
            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'CPF is not valid'
                ],
                httpCode: 400
            ))->send();

            exit();

        }

        return $this;
    }

    public function isvalidPassword(string $password): self
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
