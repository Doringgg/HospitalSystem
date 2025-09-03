<?php

use Firebase\JWT\MyTokenJTW;
use Firebase\JWT\MyTokenJWT;

require_once "api/src/DAO/LoginDAO.php";
require_once "api/src/Models/doctor.php";
require_once "api/src/Models/patient.php";
require_once "api/src/utils/MyTokenJWT.php";

class LoginControl
{

    public function authenticateDoctor(stdClass $stdLogin): never
    {

        $loginDAO = new LoginDAO();

        $doctor = new doctor();

        $doctor->setDoctorEmail($stdLogin->user->email);
        $doctor->setDoctorPassword($stdLogin->user->password);

        $loggedInDoctor = $loginDAO->LoginVerify($doctor);

        if(empty($loggedInDoctor)) {
            (new Response(
                success: false,
                message: 'Invalid user and password',
                httpCode: 401
            ))->send();
        } else {
            
            $claims = new stdClass();

            $claims->ID = $loggedInDoctor[0]->getDoctorID();
            $claims->name = $loggedInDoctor[0]->getDoctorName();
            $claims->email = $loggedInDoctor[0]->getDoctorEmail();
            $claims->role = "doctor";

            $MyTokenJTW = new MyTokenJWT();

            $token = $MyTokenJTW->generateToken($claims);

            (new Response(
                success: true,
                message: 'User and Password validated',
                data: [
                    'token' => $token,
                    'doctor' => $loggedInDoctor
                ],
                httpCode: 200
            ))->send();
        }
        exit();

        
    }
}