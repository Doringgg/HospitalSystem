<?php

require_once "api/src/Models/patient.php";
require_once "api/src/DAO/PatientDAO.php";

class PatientControl
{
    
    public function createControl(stdClass $stdPatient): never
    {
        $patient = new patient();

        $patient->setPatientName($stdPatient->patient->patientName);
        $patient->setPatientDOB($stdPatient->patient->patientDOB);
        $patient->setPatientEmail($stdPatient->patient->patientEmail);
        $patient->setPatientPhoneNum($stdPatient->patient->patientPhoneNum);
        $patient->setPatientCPF($stdPatient->patient->patientCPF);

        $patientDAO = new PatientDAO();

        $newPatient = $patientDAO->create($patient);
        (new Response(
            true,
            'Patient sucessfully registered',
            [
                'Patients' => $newPatient
            ],
            httpCode: 200
        ))->send();
        
        exit();
    }

    public function readALLControl(): never
    {
        $patientDAO = new PatientDAO();

        $patients = $patientDAO->readALL();

        (new Response(
            true,
            'Data sucessfully selected',
            ['Patients' => $patients],
            httpCode: 200
        ))->send();

        exit();
    }

    public function readByIDControl(int $PatientID): never
    {
        $patientDAO = new PatientDAO();
        $patients = $patientDAO->readByID( $PatientID);
        (new Response(
            true,
            'Data sucessfully selected',
            ['Patients' => $patients],
            httpCode: 200
        ))->send();

        exit();
    }

    public function updateControl (stdClass $stdPatient): never
    {
        $patient = new patient();

        $patient->setPatientID($stdPatient->patient->patientID);
        $patient->setPatientName($stdPatient->patient->patientName);
        $patient->setPatientDOB($stdPatient->patient->patientDOB);
        $patient->setPatientEmail($stdPatient->patient->patientEmail);
        $patient->setPatientPhoneNum($stdPatient->patient->patientPhoneNum);
        $patient->setPatientCPF($stdPatient->patient->patientCPF);

        $patientDAO = new PatientDAO;

        if ($patientDAO->update($patient)) {
            (new Response(
                true,
                'Patient sucessfully updated',
                [
                    'patients' => $patient
                ],
                httpCode: 200
            ))->send();
        }else{
            (new Response(
                false,
                'Patient could not get updated',
                error: [
                    'code' => 'patient_update',
                    'message'=> 'It was not possible to update the Patient'
                ],
                httpCode: 400
            ))->send();
        }

        exit();
    }

    public function deleteControl($PatientID): never
    {

        $patientDAO = new PatientDAO();

        if($patientDAO->delete($PatientID)) {
            (new Response(
                true,
                'Patient deleted sucessfully',
                httpCode: 204
            ))->send();
        }else{
            (new Response(
                false,
                'Patient could not be deleted',
                error: [
                    'cod' => 'delete_error',
                    'message' => 'It was not possible to delete the Patient'
                ],
                httpCode: 400
            ))->send();
        }
    }
}