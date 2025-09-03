<?php

require_once "api/src/Routes/Router.php";
require_once "api/src/HttpResponse.php";

require_once "api/src/Controllers/DoctorControl.php";
require_once "api/src/Middlewares/DoctorMiddleware.php";

require_once "api/src/Controllers/PatientControl.php";
require_once "api/src/Middlewares/PatientMiddleware.php";

require_once "api/src/Controllers/ConsultationControl.php";
require_once "api/src/Middlewares/ConsultationMiddleware.php";

require_once "api/src/Controllers/LoginControl.php";
require_once "api/src/Middlewares/LoginMiddleware.php";

require_once "api/src/Middlewares/JWTMiddleware.php";

class Roteador
{
    public function __construct(private Router $router = new Router())
    {
        $this->router = new Router();

        $this->setupHeaders();
        
        $this->setupDoctorRoutes();
        $this->setupPatientRoutes();
        $this->setupConsultationRoutes();
        $this->setupLoginRoutes();
        
    }

    private function setupHeaders(): void
    {
        header(header: 'Access-Control-Allow-Method: GET, POST, PUT, DELETE');
        header(header: 'Access-Control-Allow-Origin: *');
        header(header: 'Access-Control-Allow-Headers: Content-Type, Authorization');
    }

    private function sendErrorResponse(Throwable $throwable, string $message): never
    {
        (new Response(
            success: false,
            message: $message,
            error: [
                'code' => $throwable->getCode(),
                'message' => $throwable->getMessage()
            ],
            httpCode: 500
        ))->send();
    }

    private function setupDoctorRoutes(): void
    {
        $this->router->get(pattern: '/Doctors', fn: function (): never{
            try{

                $tokenMiddleware = new JWTMiddleware();
                $payload = $tokenMiddleware->isValidToken();

                $doctorControl = new DoctorControl();
                $doctorControl->readALLControl();

            } catch (Throwable $throwable){
                $this->sendErrorResponse(
                    $throwable,
                    'Error in data selection'
                );
            }
            exit();
        });

        $this->router->get(pattern: '/Doctors/(\d+)', fn: function ($doctorID): never{
            try{

                $tokenMiddleware = new JWTMiddleware();
                $payload = $tokenMiddleware->isValidToken();

                $doctorControl = new DoctorControl();
                $doctorControl->readByIDControl($doctorID);
                
            } catch (Throwable $throwable){
                $this->sendErrorResponse(
                    $throwable,
                    'Error in data selection'
                );
            }
            exit();
        });

        $this->router->post(pattern: '/Doctors', fn: function (): never{
            try{

                $tokenMiddleware = new JWTMiddleware();
                $payload = $tokenMiddleware->isValidToken();

                $requestBody = file_get_contents('php://input');

                $doctorMiddleware = new DoctorMiddleware();

                $stdDoctor = $doctorMiddleware->stringJsonToStdClass($requestBody);

                $doctorMiddleware
                    ->isValidDoctorName($stdDoctor->doctor->doctorName)
                    ->isValidDOB($stdDoctor->doctor->doctorDOB)
                    ->isValidEmail($stdDoctor->doctor->doctorEmail)
                    ->isValidPhoneNum($stdDoctor->doctor->doctorPhoneNum)
                    ->isValidCPF($stdDoctor->doctor->doctorCPF)
                    ->isvalidPassword($stdDoctor->doctor->doctorPassword);

                $doctorControl = new DoctorControl();
                $doctorControl->createControl($stdDoctor);

            } catch (Throwable $throwable){
                $this->sendErrorResponse(
                    $throwable,
                    'Error in data insertion'
                );
            }
            exit();
        });

        $this->router->put(pattern: '/Doctors/(\d+)', fn: function ($doctorID): never{
            try{

                $tokenMiddleware = new JWTMiddleware();
                $payload = $tokenMiddleware->isValidToken();

                $requestBody = file_get_contents('php://input');

                $doctorMiddleware = new DoctorMiddleware();

                $stdDoctor = $doctorMiddleware->stringJsonToStdClass($requestBody);

                $doctorMiddleware
                    ->isValidID($stdDoctor->doctor->doctorID)
                    ->isValidDoctorName($stdDoctor->doctor->doctorName)
                    ->isValidDOB($stdDoctor->doctor->doctorDOB)
                    ->isValidEmail($stdDoctor->doctor->doctorEmail)
                    ->isValidPhoneNum($stdDoctor->doctor->doctorPhoneNum)
                    ->isValidCPF($stdDoctor->doctor->doctorCPF);

                $doctorControl = new DoctorControl();
                $doctorControl->updateControl($stdDoctor);

            } catch (Throwable $throwable){
                $this->sendErrorResponse(
                    $throwable,
                    'Error in data update'
                );
            }
            exit();
        });

        $this->router->delete(pattern: '/Doctors/(\d+)', fn: function ($doctorID): never{
            try{

                $tokenMiddleware = new JWTMiddleware();
                $payload = $tokenMiddleware->isValidToken();

                $doctorMiddleware = new DoctorMiddleware();

                $doctorMiddleware
                    ->isValidID($doctorID);

                $doctorControl = new DoctorControl();
                $doctorControl->deleteControl($doctorID);
                
            } catch (Throwable $throwable){
                $this->sendErrorResponse(
                    $throwable,
                    'Error in data exclusion'
                );
            }

            exit();
        });

    }
    private function setupPatientRoutes(): void
    {
        $this->router->get(pattern: '/Patients', fn: function (): never{
            try{

                $tokenMiddleware = new JWTMiddleware();
                $payload = $tokenMiddleware->isValidToken();

                $patientControl = new patientControl();
                $patientControl->readALLControl();

            } catch (Throwable $throwable){
                $this->sendErrorResponse(
                    $throwable,
                    'Error in data selection'
                );
            }

            exit();
        });

        $this->router->get(pattern: '/Patients/(\d+)', fn: function ($patientID): never{
            try{

                $tokenMiddleware = new JWTMiddleware();
                $payload = $tokenMiddleware->isValidToken();

                $patientControl = new PatientControl();
                $patientControl->readByIDControl($patientID);

            } catch (Throwable $throwable){
                $this->sendErrorResponse(
                    $throwable,
                    'Error in data selection'
                );
            }
            
            exit();
        });

        $this->router->post(pattern: '/Patients', fn: function (): never{
            try{

                $tokenMiddleware = new JWTMiddleware();
                $payload = $tokenMiddleware->isValidToken();
                
                $requestBody = file_get_contents( 'php://input');

                $patientMiddleware = new PatientMiddleware();

                $stdPatient = $patientMiddleware->stringJsonToStdClass($requestBody);

                $patientMiddleware
                    ->isValidPatientName($stdPatient->patient->patientName)
                    ->isValidDOB($stdPatient->patient->patientDOB)
                    ->isValidEmail($stdPatient->patient->patientEmail)
                    ->isValidPhoneNum($stdPatient->patient->patientPhoneNum)
                    ->isValidCPF($stdPatient->patient->patientCPF);

                $patientControl = new PatientControl();
                $patientControl->createControl($stdPatient);

            } catch (Throwable $throwable){
                $this->sendErrorResponse(
                    $throwable,
                    'Error in data insertion'
                );
            }
            
            exit();
        });

        $this->router->put(pattern: '/Patients/(\d+)', fn: function ($patientID): never{
            try{

                $tokenMiddleware = new JWTMiddleware();
                $payload = $tokenMiddleware->isValidToken();

                $requestBody = file_get_contents( 'php://input');

                $patientMiddleware = new PatientMiddleware();

                $stdPatient = $patientMiddleware->stringJsonToStdClass($requestBody);

                $patientMiddleware
                    ->isValidID($stdPatient->patient->patientID)
                    ->isValidPatientName($stdPatient->patient->patientName)
                    ->isValidDOB($stdPatient->patient->patientDOB)
                    ->isValidEmail($stdPatient->patient->patientEmail)
                    ->isValidPhoneNum($stdPatient->patient->patientPhoneNum)
                    ->isValidCPF($stdPatient->patient->patientCPF);

                $patientControl = new PatientControl();
                $patientControl->updateControl($stdPatient);

            } catch (Throwable $throwable){
                $this->sendErrorResponse(
                    $throwable,
                    'Error in data update'
                );
            }
            
            exit();
        });

        $this->router->delete(pattern: '/Patients/(\d+)', fn: function ($patientID): never{
            try{

                $tokenMiddleware = new JWTMiddleware();
                $payload = $tokenMiddleware->isValidToken();

                $patientMiddleware = new PatientMiddleware();

                $patientMiddleware
                    ->isValidID($patientID);

                $patientControl = new PatientControl();
                $patientControl->deleteControl($patientID);

            } catch (Throwable $throwable){
                $this->sendErrorResponse(
                    $throwable,
                    'Error in data exclusion'
                );
            }
            
            exit();
        });
    }

    private function setupConsultationRoutes(): void
    {
        $this->router->get(pattern: '/Consultations', fn: function (): never{
            
            try{

                $tokenMiddleware = new JWTMiddleware();
                $payload = $tokenMiddleware->isValidToken();

                $consultationControl = new ConsultationControl();
                $consultationControl->readALLControl();

            } catch (Throwable $throwable){
                $this->sendErrorResponse(
                    $throwable,
                    'Error in data selection'
                );
            }
            
            exit();
        });

        $this->router->get(pattern: '/Consultations/(\d+)', fn: function ($consultationID): never{
            
            try{

                $tokenMiddleware = new JWTMiddleware();
                $payload = $tokenMiddleware->isValidToken();

                $consultationControl = new ConsultationControl();
                $consultationControl->readByIDControl($consultationID);

            } catch (Throwable $throwable){
                $this->sendErrorResponse(
                    $throwable,
                    'Error in data selection'
                );
            }
            
            exit();
        });

        $this->router->post(pattern: '/Consultations',fn: function (): never{
            
            try{

                $tokenMiddleware = new JWTMiddleware();
                $payload = $tokenMiddleware->isValidToken();
                
                $requestBody = file_get_contents('php://input');

                $consultationMiddleware = new ConsultationMiddleware();

                $stdConsultation = $consultationMiddleware->stringJsonToStdClass($requestBody);

                $consultationMiddleware
                    ->isValidDoctorID($stdConsultation->Consultation->doctorID)
                    ->isValidPatientID($stdConsultation->Consultation->patientID);

                $consultationControl = new ConsultationControl();
                $consultationControl->createControl($stdConsultation);

            } catch (Throwable $throwable){
                $this->sendErrorResponse(
                    $throwable,
                    'Error in data insertion'
                );
            }
            
            exit();
        });

        $this->router->put(pattern: '/Consultations/(\d+)', fn: function($consultationID): never{
            
            try{

                $tokenMiddleware = new JWTMiddleware();
                $payload = $tokenMiddleware->isValidToken();

                $requestBody = file_get_contents('php://input');

                $consultationMiddleware = new ConsultationMiddleware();

                $stdConsultation = $consultationMiddleware->stringJsonToStdClass($requestBody);

                $consultationMiddleware
                    ->isValidConsultationID($stdConsultation->Consultation->consultationID)
                    ->isValidDoctorID($stdConsultation->Consultation->doctorID)
                    ->isValidPatientID($stdConsultation->Consultation->patientID);

                $consultationControl = new ConsultationControl();
                $consultationControl->updateControl($stdConsultation);

            } catch (Throwable $throwable){
                $this->sendErrorResponse(
                    $throwable,
                    'Error in data update'
                );
            }
            
            exit();
        });

        $this->router->delete(pattern: '/Consultations/(\d+)',fn: function($consultationID): never{
            
            try{

                $tokenMiddleware = new JWTMiddleware();
                $payload = $tokenMiddleware->isValidToken();

                $consultationMiddleware = new ConsultationMiddleware();

                $consultationMiddleware
                    ->isValidConsultationID($consultationID);

                $consultationControl = new ConsultationControl();
                $consultationControl->deleteControl($consultationID);

            } catch (Throwable $throwable){
                $this->sendErrorResponse(
                    $throwable,
                    'Error in data selection'
                );
            }
            
            exit();
        });
    }

    private function setupLoginRoutes() {
        $this->router->post(pattern: '/login', fn: function (): never {
            
            try {
                
                $requestBody = file_get_contents(filename: "php://input");
                
                $loginMiddleware = new LoginMiddleware();
                
                $stdLogin = $loginMiddleware->stringJsonToStdClass($requestBody);
                $loginMiddleware
                    ->isValidEmail($stdLogin->user->email)
                    ->isValidSenha($stdLogin->user->password);
                
                    $loginControl = new LoginControl();
                
                    $loginControl->authenticateDoctor($stdLogin);
            
            } catch (Throwable $throwable) {
                $this->sendErrorResponse(
                    throwable: $throwable,
                    message: 'Error when logging in'
                );
            }

            exit();
        });
    }



    public function start(): void
    {
        $this->router->run();
    }
}