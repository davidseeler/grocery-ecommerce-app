-- MySQL Script generated by MySQL Workbench
-- Wed Nov 11 21:14:39 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema grocery
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema grocery
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `grocery` DEFAULT CHARACTER SET utf8 ;
USE `grocery` ;

-- -----------------------------------------------------
-- Table `grocery`.`Department`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `grocery`.`Department` (
  `id` INT NOT NULL,
  `Name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grocery`.`Products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `grocery`.`Products` (
  `productID` INT NOT NULL,
  `Name` VARCHAR(255) NOT NULL,
  `Price` DOUBLE NOT NULL,
  `departmentID` INT NOT NULL,
  PRIMARY KEY (`productID`),
  UNIQUE INDEX `id_UNIQUE` (`productID` ASC) VISIBLE,
  UNIQUE INDEX `Name_UNIQUE` (`Name` ASC) VISIBLE,
  INDEX `fk_Products_Department1_idx` (`departmentID` ASC) VISIBLE,
  CONSTRAINT `fk_Products_Department1`
    FOREIGN KEY (`departmentID`)
    REFERENCES `grocery`.`Department` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grocery`.`Shopping Cart`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `grocery`.`Shopping Cart` (
  `id` INT NOT NULL,
  `productID` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_Shopping Cart_Products1_idx` (`productID` ASC) VISIBLE,
  CONSTRAINT `fk_Shopping Cart_Products1`
    FOREIGN KEY (`productID`)
    REFERENCES `grocery`.`Products` (`productID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grocery`.`Account`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `grocery`.`Account` (
  `username` VARCHAR(20) NOT NULL,
  `password` VARCHAR(20) NOT NULL,
  `cartID` INT NOT NULL,
  `creditCard` INT NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`username`),
  INDEX `fk_Account_Shopping Cart1_idx` (`cartID` ASC) VISIBLE,
  CONSTRAINT `fk_Account_Shopping Cart1`
    FOREIGN KEY (`cartID`)
    REFERENCES `grocery`.`Shopping Cart` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
