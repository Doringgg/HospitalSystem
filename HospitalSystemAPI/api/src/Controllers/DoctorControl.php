<?php

require_once "api/src/Models/doctor.php";
require_once "api/src/DAO/DoctorDAO.php";

class DoctorControl
{

    public function createControl(stdClass $stdDoctor): never
    {
        $doctor = new doctor();

        $doctor->setDoctorName($stdDoctor->doctor->doctorName);
        $doctor->setDoctorDOB($stdDoctor->doctor->doctorDOB);
        $doctor->setDoctorEmail($stdDoctor->doctor->doctorEmail);
        $doctor->setDoctorPhoneNum($stdDoctor->doctor->doctorPhoneNum);
        $doctor->setDoctorCPF($stdDoctor->doctor->doctorCPF);
        $doctor->setDoctorPassword($stdDoctor->doctor->doctorPassword);

        $doctorDAO = new DoctorDAO();

        $newDoctor = $doctorDAO->create($doctor);
        (new Response(
            success: true,
            message: 'Doctor sucessfully registered',
            data: [
                'Doctors' => $newDoctor
            ],
            httpCode: 200
        ))->send();

        exit();
    }
    
    public function readALLControl(): never
    {
        $doctorDAO = new DoctorDAO;

        $doctors = $doctorDAO->readALL();

        (new Response(
            success: true,
            message: 'Data successfully selected',
            data: ['Doctors' => $doctors],
            httpCode: 200
        ))->send();
    exit();
    }

    public function readByIDControl(int $doctorID): never
    {
        $doctorDAO = new DoctorDAO();
        $doctors = $doctorDAO->readById($doctorID);
        (new Response(
            success: true,
            message: 'Data successfully selected',
            data: [
                'Doctors' => $doctors
            ],
            httpCode: 200
        ))->send();
    }

    public function updateControl(stdClass $stdDoctor): never
    {
        $doctor = new doctor();
        
        $doctor->setDoctorID($stdDoctor->doctor->doctorID);
        $doctor->setDoctorName($stdDoctor->doctor->doctorName);
        $doctor->setDoctorDOB($stdDoctor->doctor->doctorDOB);
        $doctor->setDoctorEmail($stdDoctor->doctor->doctorEmail);
        $doctor->setDoctorPhoneNum($stdDoctor->doctor->doctorPhoneNum);
        $doctor->setDoctorCPF($stdDoctor->doctor->doctorCPF);
        $doctor->setDoctorPassword($stdDoctor->doctor->doctorPassword);

        $doctorDAO = new DoctorDAO();

        if($doctorDAO->update($doctor)) {
            (new Response(
                success: true,
                message: 'Doctor sucessfully updated',
                data: [
                    'doctors' => $doctor
                ],
                httpCode: 200
            ))->send();
        }else{
            (new Response(
                success: true,
                message: 'Doctor could not get updated',
                error: [
                    'code' => 'doctor_update',
                    'message' => 'It was not possible to update the Doctor'
                ],
                httpCode: 400
            ))->send();
        }

        exit();
    }

    public function deleteControl($doctorID): never
    {

        $doctorDAO = new DoctorDAO();

        if ($doctorDAO->delete($doctorID)) {
            (new Response(
                success: true,
                message: 'Doctor deleted sucessfully',
                httpCode: 204
            ))->send();
        } else {
            (new Response(
                success: false,
                message: 'Doctor could not be deleted',
                error: [
                    'cod' => 'delete_error',
                    'message' => 'It was not possible to delete the Doctor'
                ],
                httpCode: 400
            ))->send();
        }
    }

}