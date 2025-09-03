CREATE SCHEMA IF NOT EXISTS `hospitalsystem` DEFAULT CHARACTER SET utf8mb4 ;
USE `hospitalsystem` ;

CREATE TABLE IF NOT EXISTS `hospitalsystem`.`doctor` (
    `doctorID` INT(11) NOT NULL AUTO_INCREMENT,
    `doctorName` VARCHAR(64) NULL DEFAULT NULL,
    `doctorDOB` VARCHAR(30) NULL DEFAULT NULL,
    `doctorEmail` VARCHAR(64) NULL DEFAULT NULL,
    `doctorPhoneNum` VARCHAR(45) NULL DEFAULT NULL,
    `doctorCPF` VARCHAR(45) NULL DEFAULT NULL,
    `doctorPassword` VARCHAR(45) NULL DEFAULT NULL,
    PRIMARY KEY (`doctorID`));

CREATE TABLE IF NOT EXISTS `hospitalsystem`.`patient` (
    `patientID` INT(12) NOT NULL AUTO_INCREMENT,
    `patientName` VARCHAR(64) NULL DEFAULT NULL,
    `patientDOB` VARCHAR(30) NULL DEFAULT NULL,
    `patientEmail` VARCHAR(64) NULL DEFAULT NULL,
    `patientPhoneNum` VARCHAR(45) NULL DEFAULT NULL,
    `patientCPF` VARCHAR(45) NULL DEFAULT NULL,
    PRIMARY KEY (`patientID`));

CREATE TABLE IF NOT EXISTS `hospitalsystem`.`consultation` (
    `consultationID` INT(14) NOT NULL AUTO_INCREMENT,
    `doctorID` INT(11) NOT NULL,
    `patientID` INT(12) NOT NULL,
    PRIMARY KEY (`consultationID`),
    INDEX `doctorID` (`doctorID` ASC),
    INDEX `patientID` (`patientID` ASC),
    CONSTRAINT `consultation_ibfk_1`
    FOREIGN KEY (`doctorID`)
    REFERENCES `hospitalsystem`.`doctor` (`doctorID`),
    CONSTRAINT `consultation_ibfk_2`
    FOREIGN KEY (`patientID`)
    REFERENCES `hospitalsystem`.`patient` (`patientID`));
    
