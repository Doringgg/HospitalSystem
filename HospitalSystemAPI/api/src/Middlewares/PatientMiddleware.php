<?php

require_once "api/src/HttpResponse.php";

class PatientMiddleware{

    public function stringJsonToStdClass($requestBody): stdClass
    {
        $stdPatient = json_decode($requestBody);

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
        
        } else if (!isset($stdPatient->patient)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Object patient was not send'
                ],
                httpCode: 400
            ))->send();

            exit();

        } else if (!isset($stdPatient->patient->patientName)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Patient name was not send'
                ],
                httpCode: 400
            ))->send();

            exit();
            
        } else if (!isset($stdPatient->patient->patientDOB)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Patient DOB was not send'
                ],
                httpCode: 400
            ))->send();

            exit();
            
        } else if (!isset($stdPatient->patient->patientEmail)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Patient Email was not send'
                ],
                httpCode: 400
            ))->send();

            exit();
            
        } else if (!isset($stdPatient->patient->patientPhoneNum)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Patient Phone Number was not send'
                ],
                httpCode: 400
            ))->send();

            exit();
            
        } else if (!isset($stdPatient->patient->patientCPF)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Patient CPF was not send'
                ],
                httpCode: 400
            ))->send();

            exit();
            
        }

        return $stdPatient;
    }

    public function isValidPatientName(string $patientName): self
    {
        $patientName = trim($patientName);

        if(strlen($patientName) < 3){

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Patient Name can not be null or be less than 3 letters lengthy'
                ],
                httpCode: 400
            ))->send();

            exit();

        }

        if(preg_match('/\d/',$patientName)){

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Patient Name can not contain numbers'
                ],
                httpCode: 400
            ))->send();

            exit();

        }

        if(preg_match('/[-@_=+#$%&*.()]/',$patientName)){

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Patient Name can not contain numbers'
                ],
                httpCode: 400
            ))->send();

            exit();

        }
        
        return $this;

    }

    public function isValidID($patientID): self
    {
        if (!isset($patientID)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Patient ID was not send'
                ],
                httpCode: 400
            ))->send();

            exit();
            
        }
        
        if (!is_numeric($patientID)) {

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

        if ($patientID <= 0) {
            
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
        
        
        return $this;
    }

    public function isValidEmail($patientEmail): self
    {
        
        if(strlen($patientEmail) < 5){
            
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
        
        if (!filter_var($patientEmail, FILTER_VALIDATE_EMAIL)) {

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

    public function isValidPhoneNum($patientPhoneNum): self{

        if(strlen( $patientPhoneNum) < 9){

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

        if(preg_match('/[A-Z]/', $patientPhoneNum)) {
            
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

        if(preg_match('/[a-z]/', $patientPhoneNum)) {
            
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

    public function isValidDOB($patientDOB): self
    {
        if(strlen($patientDOB) < 8  || strlen($patientDOB) > 10){

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

        if(preg_match('/[A-Z]/', $patientDOB)) {
            
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

        if(preg_match('/[a-z]/', $patientDOB)) {
            
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

        if(preg_match('/[-@_=+#$%&*.()]/', $patientDOB)) {
            
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

    public function isValidCPF($patientCPF): self
    {

        if(strlen($patientCPF) < 11  ) {
            
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
        
        if(preg_match('/[a-z]/', $patientCPF)) {
            
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

        if(preg_match('/[A-Z]/', $patientCPF)) {
            
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

        if(preg_match('/[-@_=+#$%&*.()]/', $patientCPF)) {
            
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
}