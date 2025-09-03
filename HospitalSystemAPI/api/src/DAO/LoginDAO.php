<?php
require_once "api/src/Database/Database.php";
require_once "api/src/Models/doctor.php";
require_once "api/src/Models/patient.php";

class LoginDAO{
    
    public function LoginVerify(doctor $doctor): array
    {

        $query = ' SELECT 
                        doctorID, 
                        doctorName,
                        doctorDOB,
                        doctorEmail,
                        doctorPhoneNum,
                        doctorCPF
                        FROM doctor
                        WHERE
                            doctorEmail = :email AND
                            doctorPassword = :password
                            ORDER BY doctorName ASC
                        ';

        $statement = Database::getConnection()->prepare($query);

        $statement->bindValue(
            ':email',
            $doctor->getDoctorEmail(),
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':password',
            $doctor->getDoctorPassword(),
            PDO::PARAM_STR
        );

        $statement->execute();

        $doctor = new doctor();

        $row = $statement->fetch(PDO::FETCH_OBJ);

        if (!$row) {
            return [];
        }

        $doctor
            ->setDoctorID($row->doctorID)
            ->setDoctorName($row->doctorName)
            ->setDoctorDOB($row->doctorDOB)
            ->setDoctorEmail($row->doctorEmail)
            ->setDoctorPhoneNum($row->doctorPhoneNum)
            ->setDoctorCPF($row->doctorCPF);

        return [$doctor];
    }
}