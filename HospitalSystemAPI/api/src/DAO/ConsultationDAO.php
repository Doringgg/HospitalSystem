<?php

require_once "api/src/Models/consultation.php";
require_once "api/src/Models/doctor.php";
require_once "api/src/Models/patient.php";
require_once "api/src/Database/Database.php";


class ConsultationDAO
{
    public function create(consultation $consultation): consultation
    {
        $query = 'INSERT INTO consultation (
                            doctorID,
                            patientID
                            ) VALUES (
                            :doctorID,
                            :patientID ) ;';

        $statement = Database::getConnection()->prepare($query);

        $statement->bindValue(
            ':doctorID',
            $consultation->getDoctor()->getDoctorID(),
            PDO::PARAM_INT
        );

        $statement->bindValue(
            ':patientID',
            $consultation->getPatient()->getPatientID(),
            PDO::PARAM_INT
        );

        $statement->execute();

        $consultation->setConsultationID((int) Database::getConnection()->lastInsertId());

        return $consultation;
    }

    public function readALL(): array
    {
        $query = 'SELECT * FROM consultation ;';

        $statement = Database::getConnection()->query($query);

        $results = [];

        while ($line = $statement->fetch(PDO::FETCH_OBJ)) {

            $consultation = (new consultation())
                ->setConsultationID($line->consultationID);                
            $consultation->getDoctor()
                    ->setDoctorID($line->doctorID);
            $consultation->getPatient()
                    ->setPatientID($line->patientID);

            $results[] = $consultation;
        }
        return $results;
    }

    public function readById(int $consultationID): array
    {
        $query = 'SELECT * FROM consultation WHERE consultationID = :consultationID ;';

        $statement = Database::getConnection()->prepare($query);

        $statement->bindValue(
            ':consultationID',
            $consultationID,
            PDO::PARAM_INT
        );

        $statement->execute();

        $consultation = new consultation();

        $line = $statement->fetch(PDO::FETCH_OBJ);

        if(!$line) {
            return [];
        }

        $consultation
                ->setConsultationID($line->consultationID);
                
        $consultation->getDoctor()
                    ->setDoctorID($line->doctorID);
            
        $consultation->getPatient()
                    ->setPatientID($line->patientID);

        return [$consultation];
    }


    public function update(consultation $consultation): bool
    {

        $query = 'UPDATE consultation 
                SET
                doctorID = :doctorID,
                patientID = :patientID
                WHERE
                consultationID = :consultationID ;';

        $statement = Database::getConnection()->prepare($query);

        $statement->bindValue(
            param: ':doctorID',
            value: $consultation->getDoctor()->getDoctorID(),
            type: PDO::PARAM_INT
        );

        $statement->bindValue(
            'patientID',
            $consultation->getPatient()->getPatientID(),
            PDO::PARAM_INT
        );

        $statement->bindValue(
            'consultationID',
            $consultation->getConsultationID(),
            PDO::PARAM_INT
        );

        $statement->execute();

        if ($statement->rowCount() > 0) {
            return true;
        }else{
            return false;
        }
    }

    public function delete(int $consultationID): bool
    {
        $query = 'DELETE FROM
                consultation
                WHERE
                consultationID = :consultationID ;';
        
        $statement = Database::getConnection()->prepare($query);

        $statement->bindValue(
            ':consultationID',
            $consultationID,
            PDO::PARAM_INT
        );

        $statement->execute();

        return $statement->rowCount() > 0;
    }

}