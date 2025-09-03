<?php

declare(strict_types=1);

class doctor implements JsonSerializable
{

    public function __construct(
        private ?int $doctorID = null,
        private string $doctorName = "",
        private string $doctorDOB = "",
        private string $doctorEmail = "",
        private string $doctorPhoneNum = "",
        private string $doctorCPF = "",
        private string $doctorPassword = ""
    ){
    }

    public function jsonSerialize(): array
    {
        return[
            'doctorID'=> $this->getDoctorID(),
            'doctorName'=>$this->getdoctorName(),
            'doctorDOB'=>$this->getdoctorDOB(),
            'doctorEmail'=>$this->getdoctorEmail(),
            'doctorPhoneNum'=>$this->getdoctorPhoneNum(),
            'doctorCPF'=>$this->getdoctorCPF(),
            'doctorPassword'=>$this->getDoctorPassword()
        ];
    }

    public function getDoctorID(): int|null
    {
        return $this->doctorID;
    }

    public function setDoctorID(int $doctorID): self
    {
        $this->doctorID = $doctorID;
        return $this;
    }

    
    public function getDoctorName(): string
    {
        return $this->doctorName;
    }

    public function setDoctorName(string $doctorName): self
    {
        $this->doctorName = $doctorName;
        return $this;
    }


    public function getDoctorDOB(): string
    {
        return $this->doctorDOB;
    }

    public function setDoctorDOB(string $doctorDOB): self
    {
        $this->doctorDOB = $doctorDOB;
        return $this;
    }


    public function getDoctorEmail(): string
    {
        return $this->doctorEmail;
    }

    public function setDoctorEmail(string $doctorEmail): self
    {
        $this->doctorEmail = $doctorEmail;
        return $this;
    }

    public function getDoctorPassword(): string
    {
        return $this->doctorPassword;
    }

    public function setDoctorPassword(string $doctorPassword): self
    {
        $this->doctorPassword = $doctorPassword;
        return $this;
    }


    public function getDoctorPhoneNum(): string
    {
        return $this->doctorPhoneNum;
    }

    public function setDoctorPhoneNum(string $doctorPhoneNum): self
    {
        $this->doctorPhoneNum = $doctorPhoneNum;
        return $this;
    }


    public function getDoctorCPF(): string
    {
        return $this->doctorCPF;
    }

    public function setDoctorCPF(string $doctorCPF): self
    {
        $this->doctorCPF = $doctorCPF;
        return $this;
    }
}