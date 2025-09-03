<?php

require_once "api/src/HttpResponse.php";

class ConsultationMiddleware{

    public function stringJsonToStdClass($requestBody): stdClass
    {
        $stdConsultation = json_decode($requestBody);

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
        } else if (!isset($stdConsultation->Consultation)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Object Consultation was not send'
                ],
                httpCode: 400
            ))->send();

            exit();

        } else if (!isset($stdConsultation->Consultation->doctorID)) {

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
            
        } else if (!isset($stdConsultation->Consultation->patientID)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Consultation ID was not send'
                ],
                httpCode: 400
            ))->send();

            exit();
            
        }

        return $stdConsultation;

    }

    public function isValidConsultationID($consultationID):self
    {
        if (!isset($consultationID)) {

            (new Response(
                false,
                'Invalid Information',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Consultation ID was not send'
                ],
                httpCode: 400
            ))->send();

            exit();
            
        }
        
        if (!is_numeric($consultationID)) {

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

        if ($consultationID <= 0) {
            
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

    public function isValidDoctorID($doctorID):self
    {
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

        return $this;
    }

    public function isValidPatientID($patientID):self
    {
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
}