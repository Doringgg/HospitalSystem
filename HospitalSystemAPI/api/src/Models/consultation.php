<?php

declare(strict_types=1);

require_once "api/src/Models/Doctor.php";
require_once "api/src/Models/Patient.php";

class consultation implements JsonSerializable
{
    public function __construct(
        private ?int $consultationID = null,
        private Doctor $doctor = new doctor(),
        private Patient $patient = new patient()
    ){}

    public function jsonSerialize(): array
    {
        return[
            'ConsultationID'=> $this->getConsultationID(),
            'DoctorID'=> $this->doctor->getDoctorID(),
            'PatientID'=> $this->patient->getpatientID(),
        ];
    }

    
    public function getConsultationID(): int|null
    {
        return $this->consultationID;
    }

    public function setConsultationID(int $consultationID): self
    {
        $this->consultationID = $consultationID;
        return $this;
    }

    public function getDoctor(): Doctor
    {
        return $this->doctor;
    }

    public function setDoctor($doctor): self
    {
        $this->doctor = $doctor;
        return $this;
    }

    
    public function getPatient(): Patient
    {
        return $this->patient;
    }

    public function setPatient($patient): self
    {
        $this->patient = $patient;
        return $this;
    }
}