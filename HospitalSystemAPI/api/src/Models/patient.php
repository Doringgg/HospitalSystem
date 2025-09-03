<?php

declare(strict_types=1);

class patient implements JsonSerializable
{

    public function __construct(
        private ?int $patientID = null,
        private string $patientName = "",
        private string $patientDOB = "",
        private string $patientEmail = "",
        private string $patientPhoneNum = "",
        private string $patientCPF = "",
        private string $patientPassword = ""
        
    ){
    }


    public function jsonSerialize(): array
    {
        return[
            'patientID'=> $this->getpatientID(),
            'patientName'=>$this->getpatientName(),
            'patientDOB'=>$this->getpatientDOB(),
            'patientEmail'=>$this->getpatientEmail(),
            'patientPhoneNum'=>$this->getpatientPhoneNum(),
            'patientCPF'=>$this->getpatientCPF()
        ];
    }
        public function getPatientID(): int|null
        {
            return $this->patientID;
        }

        public function setPatientID(int $patientID): self
        {
            $this->patientID = $patientID;
            return $this;
        }


        public function getPatientName(): string
        {
            return $this->patientName;
        }

        public function setPatientName(string $patientName): self
        {
            $this->patientName = $patientName;
            return $this;
        }


        public function getPatientDOB(): string
        {
            return $this->patientDOB;
        }

        public function setPatientDOB(string $patientDOB): self
        {
            $this->patientDOB = $patientDOB;
            return $this;
        }

        
        public function getPatientEmail(): string
        {
            return $this->patientEmail;
        }

        public function setPatientEmail(string $patientEmail): self
        {
            $this->patientEmail = $patientEmail;
            return $this;
        }

        public function getPatientPhoneNum(): string
        {
            return $this->patientPhoneNum;
        }

        public function setPatientPhoneNum(string $patientPhoneNum): self
        {
            $this->patientPhoneNum = $patientPhoneNum;
            return $this;
        }


        public function getPatientCPF(): string
        {
            return $this->patientCPF;
        }

        public function setPatientCPF(string $patientCPF): self
        {
            $this->patientCPF = $patientCPF;
            return $this;
        }
} 