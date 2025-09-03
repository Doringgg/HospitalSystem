<?php

require_once "api/src/Models/doctor.php";
require_once "api/src/Database/Database.php";

Class DoctorDAO
{
    
    //Método para inserir médico no banco de dados
    public function create(doctor $doctor): doctor
    {
        //comando que vai ser dado no Banco
        $query = 'INSERT INTO doctor (
                            doctorName,
                            doctorDOB,
                            doctorEmail,
                            doctorPhoneNum,
                            doctorCPF,
                            doctorPassword
                            ) VALUES (
                            :doctorName,
                            :doctorDOB,
                            :doctorEmail,
                            :doctorPhoneNum,
                            :doctorCPF,
                            :doctorPassword) ;';
        
        //Protege contra SQLInject
        $statement = Database::getConnection()->prepare(query: $query);

        
        //Os statements substituem os parametros no "Values"
        $statement->bindValue(
            param: ':doctorName',
            value: $doctor->getDoctorName(),
            type: PDO::PARAM_STR
        );

        $statement->bindValue(
            param: ':doctorDOB',
            value: $doctor->getDoctorDOB(),
            type: PDO::PARAM_STR
        );

        $statement->bindValue(
            param: ':doctorEmail',
            value: $doctor->getDoctorEmail(),
            type: PDO::PARAM_STR
        );

        $statement->bindValue(
            param: ':doctorPhoneNum',
            value: $doctor->getDoctorPhoneNum(),
            type: PDO::PARAM_STR
        );

        $statement->bindValue(
            param: ':doctorCPF',
            value: $doctor->getDoctorCPF(),
            type: PDO::PARAM_STR
        );

        $statement->bindValue(
            param: ':doctorPassword',
            value: $doctor->getDoctorPassword(),
            type: PDO::PARAM_STR
        );

        //Executa o código no banco
        $statement->execute();

        //Pega o id criado pelo auto increment
        $doctor->setDoctorID(doctorID: (int) Database::getConnection()->lastInsertId());

        return $doctor;
    }

    
    //Método para dar select na tabela inteira 
    public function readALL(): array
    {
        //Comando que vai ser dado no Banco
        $query = 'SELECT * FROM doctor ;';
        
        //Executa a consulta
        $statement = Database::getConnection()->query(query: $query);

        //Array que vai armazenar as informações
        $results = [];

        // Percorre cada linha do resultado da consulta
        // Cada linha é retornada como um objeto genérico (stdClass)
        while ($line = $statement->fetch(mode: PDO::FETCH_OBJ)) {

            // Cria um novo objeto doctor e preenche os dados vindos do banco
            $doctor = (new doctor())
                ->setDoctorID(doctorID: $line->doctorID)
                ->setDoctorName(doctorName: $line->doctorName)
                ->setDoctorDOB(doctorDOB: $line->doctorDOB)
                ->setDoctorEmail(doctorEmail: $line->doctorEmail)
                ->setDoctorPhoneNum(doctorPhoneNum: $line->doctorPhoneNum)
                ->setDoctorCPF(doctorCPF: $line->doctorCPF)
                ;
            

            // Adiciona o objeto completo ao array de resultados
            $results[] = $doctor;

        }
    
        // Retorna o array com todos os funcionários encontrados
        return $results;

    }


    public function readById(int $doctorID): array
    {

        //Comando que vai ser dado no Banco
        $query = 'SELECT * FROM doctor WHERE doctorID = :doctorID ;';

        //Prepara pra executar e tira SQLInjection
        $statement = Database::getConnection()->prepare(query: $query);

        //Substitui o doctorID no comando
        $statement->bindValue(
            ':doctorID',
            $doctorID,
            PDO::PARAM_INT
        );

        //Executa o comando
        $statement->execute();

        $doctor = new doctor();

        // Busca a única linha esperada da consulta como um objeto genérico (stdClass)
        $line = $statement->fetch(mode: PDO::FETCH_OBJ);

        if (!$line) {
            return[]; //Retorna um array vazio se esse ID não existir no banco
        }

        // Preenche os dados básicos do funcionário no objeto Funcionario
        $doctor
            ->setDoctorID(doctorID: $line->doctorID)
            ->setDoctorName(doctorName: $line->doctorName)
            ->setDoctorDOB(doctorDOB: $line->doctorDOB)
            ->setDoctorEmail(doctorEmail: $line->doctorEmail)
            ->setDoctorPhoneNum(doctorPhoneNum: $line->doctorPhoneNum)
            ->setDoctorCPF(doctorCPF: $line->doctorCPF);

        return [$doctor];
    }


    public function update(doctor $doctor): bool
    {
        $query = 'UPDATE doctor
                    SET
                    doctorName = :doctorName,
                    doctorDOB = :doctorDOB,
                    doctorEmail = :doctorEmail,
                    doctorPhoneNum = :doctorPhoneNum,
                    doctorCPF = :doctorCPF,
                    doctorPassword = :doctorPassword
                    WHERE
                    doctorID = :doctorID ;';

        $statement = Database::getConnection()->prepare($query);

        $statement->bindValue(
            param: ':doctorName',
            value: $doctor->getDoctorName(),
            type: PDO::PARAM_STR
        );

        $statement->bindValue(
            param: ':doctorDOB',
            value: $doctor->getDoctorDOB(),
            type: PDO::PARAM_STR
        );

        $statement->bindValue(
            param: ':doctorEmail',
            value: $doctor->getDoctorEmail(),
            type: PDO::PARAM_STR
        );

        $statement->bindValue(
            param: ':doctorPhoneNum',
            value: $doctor->getDoctorPhoneNum(),
            type: PDO::PARAM_STR
        );

        $statement->bindValue(
            param: ':doctorCPF',
            value: $doctor->getDoctorCPF(),
            type: PDO::PARAM_STR
        );

        $statement->bindValue(
            param: ':doctorID',
            value: $doctor->getDoctorID(),
            type: PDO::PARAM_INT
        );

        $statement->bindValue(
            param: ':doctorPassword',
            value: $doctor->getDoctorPassword(),
            type: PDO::PARAM_STR
        );

        $statement->execute();

        if ($statement->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }


    public function delete(int $doctorID): bool
    {
        $query = 'DELETE FROM doctor WHERE doctorID = :doctorID ;';

        $statement = Database::getConnection()->prepare($query);

        $statement->bindValue(
            param: ':doctorID',
            value: $doctorID,
            type: PDO::PARAM_INT
        );

        $statement->execute();

        return $statement->rowCount() > 0;
    } 
}