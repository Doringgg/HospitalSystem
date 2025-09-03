<?php

require_once "api/src/Models/consultation.php";
require_once "api/src/DAO/ConsultationDAO.php";

require_once "api/src/Models/patient.php";
require_once "api/src/DAO/PatientDAO.php";

require_once "api/src/Models/doctor.php";
require_once "api/src/DAO/DoctorDAO.php";

require_once "api/src/HttpResponse.php";

class ConsultationControl
{
    
    public function createControl(stdClass $stdConsultation): never
    {

        $consultation = new consultation();

        $consultation->getDoctor()->setDoctorID($stdConsultation->Consultation->doctorID);
        $consultation->getPatient()->setPatientID($stdConsultation->Consultation->patientID);

        $consultationDAO = new ConsultationDAO();

        $newConsultation = $consultationDAO->create($consultation);
        
        (new Response(
            true,
            'Consultation successfully registered',
            data: [
                'Consultation' => $newConsultation
            ],
            httpCode: 200
        ))->send();

        exit();
    }

    public function readALLControl(): never
    {

        $consultationDAO = new ConsultationDAO();

        $consultations = $consultationDAO->readALL();

        (new Response(
            true,
            'Data successfully selected',
            data: ['Consultations' => $consultations],
            httpCode: 200
        ))->send();

        exit();
    }

    public function readByIDControl ($consultationID): never
    {
        
        $consultationDAO = new ConsultationDAO();
        
        $consultation = $consultationDAO->readById($consultationID);
        
        (new Response(
            true,
            'Data successfully selected',
            data: [
                'Consultations' => $consultation
            ],
            httpCode: 200
        ))->send();

        exit();
    }

    public function updateControl(stdClass $stdConsultation): never
    {

        $consultation = new consultation();

        $consultation->setConsultationID($stdConsultation->Consultation->consultationID);
        $consultation->getDoctor()->setDoctorID($stdConsultation->Consultation->doctorID);
        $consultation->getPatient()->setPatientID($stdConsultation->Consultation->patientID);

        $consultationDAO = new ConsultationDAO();

        if ($consultationDAO->update($consultation)) {
            (new Response(
                true,
                'Consultation sucessfully updated',
                [
                    'Consultations' => $consultation
                ],
                httpCode: 200
            ))->send();
        }else{
            (new Response(
                true,
                'Consultation could not be updated',
                error: [
                    'code' => "consultation_update",
                    'message' => "It was not possible to update the Consultation"
                ],
                httpCode: 400
            ))->send();
        }

        exit();

    }

    public function deleteControl($consultationID): never
    {


        $consultationDAO = new ConsultationDAO();

        if ($consultationDAO->delete($consultationID)) {
            (new Response(
                success: true,
                message: 'Consultation sucessfully deleted',
                httpCode: 204
            ))->send();
        } else {
            (new Response(
                success: false,
                message: 'Consultation could not be deleted',
                error: [
                    'cod' => 'delete_error',
                    'message' => 'It was not possible to delete the Consultation'
                ],
                httpCode: 400
            ))->send();
        }

        exit();

    }

}