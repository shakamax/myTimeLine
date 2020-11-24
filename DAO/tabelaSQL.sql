-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema myTimeLine
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema myTimeLine
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `myTimeLine` DEFAULT CHARACTER SET utf8 ;
USE `myTimeLine` ;

-- -----------------------------------------------------
-- Table `myTimeLine`.`Usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `myTimeLine`.`Usuarios` (
  `idUser` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(80) NOT NULL,
  `email` VARCHAR(80) NOT NULL,
  `senha` VARCHAR(32) NOT NULL,
  `dtNasc` DATE NULL,
  `estado` VARCHAR(4) NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE INDEX `idUser_UNIQUE` (`idUser` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
