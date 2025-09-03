<?php

require_once "api/src/Models/patient.php";
require_once "api/src/Database/Database.php";

Class PatientDAO
{
    public function create(patient $patient): patient
    {
        $query = 'INSERT INTO patient (
                            patientName,
                            patientDOB,
                            patientEmail,
                            patientPhoneNum,
                            patientCPF
                            ) VALUES (
                            :patientName,
                            :patientDOB,
                            :patientEmail,
                            :patientPhoneNum,
                            :patientCPF) ;';

        $statement = Database::getConnection()->prepare($query);

        $statement->bindValue(
            ':patientName',
            $patient->getPatientName(),
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':patientDOB',
            $patient->getPatientDOB(),
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':patientEmail',
            $patient->getPatientEmail(),
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':patientPhoneNum',
            $patient->getPatientPhoneNum(),
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':patientCPF',
            $patient->getPatientCPF(),
            PDO::PARAM_STR
        );

        $statement->execute();

        $patient->setPatientID((int) Database::getConnection()->lastInsertId());
        
        return $patient;
    }

    public function readALL(): array
    {
        $query = 'SELECT * FROM patient ;';

        $statement = Database::getConnection()->query($query);

        $results = [];

        while ($line = $statement->fetch(mode: PDO::FETCH_OBJ)) {

            $patient = (new patient())
                ->setPatientID( patientID: $line->patientID)
                ->setPatientName(patientName: $line->patientName)
                ->setPatientDOB(patientDOB: $line->patientDOB)
                ->setPatientEmail(patientEmail: $line->patientEmail)
                ->setPatientPhoneNum(patientPhoneNum: $line->patientPhoneNum)
                ->setPatientCPF(patientCPF: $line->patientCPF);

            $results[] = $patient;

        }

        return $results;
    }

    public function readByID(int $patientID): array
    {
        
        $query = 'SELECT * FROM patient WHERE patientID = :patientID ;';

        $statement = Database::getConnection()->prepare($query);

        $statement->bindValue(
            param: ':patientID',
            value: $patientID,
            type: PDO::PARAM_INT
        );

        $statement->execute();

        $patient = new patient();

        $line = $statement->fetch(PDO::FETCH_OBJ);

        if(!$line) {
            return[];
        }

        $patient
                ->setPatientID($line->patientID)
                ->setPatientName($line->patientName)
                ->setPatientDOB($line->patientDOB)
                ->setPatientEmail($line->patientEmail)
                ->setPatientPhoneNum($line->patientPhoneNum)
                ->setPatientCPF($line->patientCPF);
        
        return [$patient];
    }


    public function update(patient $patient): bool
    {
        $query = 'UPDATE patient
                    SET
                    patientName = :patientName,
                    patientDOB = :patientDOB,
                    patientEmail = :patientEmail,
                    patientPhoneNum = :patientPhoneNum,
                    patientCPF = :patientCPF
                    WHERE
                    patientID = :patientID ;';

        $statement = Database::getConnection()->prepare($query);

        $statement->bindValue(
            ':patientName',
            $patient->getPatientName(),
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':patientDOB',
            $patient->getPatientDOB(),
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':patientEmail',
            $patient->getPatientEmail(),
            PDO::PARAM_STR
        );

        $statement->bindValue(
            'patientPhoneNum',
            $patient->getPatientPhoneNum(),
            PDO::PARAM_STR
        );

        $statement->bindValue(
            'patientCPF',
            $patient->getPatientCPF(),
            PDO::PARAM_STR
        );

        $statement->bindValue(
            'patientID',
            $patient->getPatientID(),
            PDO::PARAM_INT
        );

        $statement->execute();

        if($statement->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function delete(int $patientID): bool
    {
        $query = 'DELETE FROM patient WHERE patientID = :patientID ;';

        $statement = Database::getConnection()->prepare($query);

        $statement->bindValue(
            ':patientID',
            $patientID,
            PDO::PARAM_INT
        );

        $statement->execute();

        return $statement-> rowCount() > 0;
    }

    
}