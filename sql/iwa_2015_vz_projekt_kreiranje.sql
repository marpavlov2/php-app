-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema iwa_2015_vz_projekt
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema iwa_2015_vz_projekt
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `iwa_2015_vz_projekt` DEFAULT CHARACTER SET utf8 ;
USE `iwa_2015_vz_projekt` ;

CREATE USER 'iwa_2015' IDENTIFIED BY 'foi2015';
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE `iwa_2015_vz_projekt`.* 
TO 'iwa_2015'@'localhost' IDENTIFIED BY 'foi2015';

-- -----------------------------------------------------
-- Table `iwa_2015_vz_projekt`.`tip_korisnika`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2015_vz_projekt`.`tip_korisnika` (
  `tip_id` INT(10) NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`tip_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2015_vz_projekt`.`korisnik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2015_vz_projekt`.`korisnik` (
  `korisnik_id` INT(10) NOT NULL AUTO_INCREMENT,
  `tip_id` INT(10) NOT NULL,
  `korisnicko_ime` VARCHAR(50) NOT NULL,
  `lozinka` VARCHAR(50) NOT NULL,
  `ime` VARCHAR(100) NOT NULL,
  `prezime` VARCHAR(100) NOT NULL,
  `email` VARCHAR(50) NULL,
  `slika` TEXT NULL,
  PRIMARY KEY (`korisnik_id`),
  INDEX `fk_korisnik_tip_korisnika_idx` (`tip_id` ASC),
  CONSTRAINT `fk_korisnik_tip_korisnika`
    FOREIGN KEY (`tip_id`)
    REFERENCES `iwa_2015_vz_projekt`.`tip_korisnika` (`tip_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2015_vz_projekt`.`udruga`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2015_vz_projekt`.`udruga` (
  `udruga_id` INT(10) NOT NULL AUTO_INCREMENT,
  `moderator_id` INT(10) NOT NULL,
  `naziv` VARCHAR(50) NOT NULL,
  `slika` TEXT NULL,
  PRIMARY KEY (`udruga_id`),
  INDEX `fk_udruga_korisnik1_idx` (`moderator_id` ASC),
  CONSTRAINT `fk_udruga_korisnik1`
    FOREIGN KEY (`moderator_id`)
    REFERENCES `iwa_2015_vz_projekt`.`korisnik` (`korisnik_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2015_vz_projekt`.`aktivnost`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2015_vz_projekt`.`aktivnost` (
  `aktivnost_id` INT(10) NOT NULL AUTO_INCREMENT,
  `udruga_id` INT(10) NOT NULL,
  `datum_kreiranja` DATE NOT NULL,
  `vrijeme_kreiranja` TIME NOT NULL,
  `datum_odrzavanja` DATE NOT NULL,
  `vrijeme_odrzavanja` TIME NOT NULL,
  `naziv` VARCHAR(50) NOT NULL,
  `slika` TEXT NULL,
  PRIMARY KEY (`aktivnost_id`),
  INDEX `fk_aktivnost_udruga1_idx` (`udruga_id` ASC),
  CONSTRAINT `fk_aktivnost_udruga1`
    FOREIGN KEY (`udruga_id`)
    REFERENCES `iwa_2015_vz_projekt`.`udruga` (`udruga_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2015_vz_projekt`.`sudionik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2015_vz_projekt`.`sudionik` (
  `aktivnost_id` INT(10) NOT NULL,
  `korisnik_id` INT(10) NOT NULL,
  PRIMARY KEY (`aktivnost_id`, `korisnik_id`),
  INDEX `fk_aktivnost_has_korisnik_korisnik1_idx` (`korisnik_id` ASC),
  INDEX `fk_aktivnost_has_korisnik_aktivnost1_idx` (`aktivnost_id` ASC),
  CONSTRAINT `fk_aktivnost_has_korisnik_aktivnost1`
    FOREIGN KEY (`aktivnost_id`)
    REFERENCES `iwa_2015_vz_projekt`.`aktivnost` (`aktivnost_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_aktivnost_has_korisnik_korisnik1`
    FOREIGN KEY (`korisnik_id`)
    REFERENCES `iwa_2015_vz_projekt`.`korisnik` (`korisnik_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
