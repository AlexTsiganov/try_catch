-- MySQL Script generated by MySQL Workbench
-- 02/22/16 19:40:45
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema sales_test_db
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `sales_test_db` ;

-- -----------------------------------------------------
-- Schema sales_test_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sales_test_db` DEFAULT CHARACTER SET utf8 ;
USE `sales_test_db` ;

-- -----------------------------------------------------
-- Table `sales_test_db`.`personal_data`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sales_test_db`.`personal_data` ;

CREATE TABLE IF NOT EXISTS `sales_test_db`.`personal_data` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NOT NULL,
  `secondname` VARCHAR(45) NOT NULL,
  `thirdname` VARCHAR(45) NULL,
  `date_of_birth` DATE NOT NULL,
  `email` VARCHAR(100) NULL,
  `phone_number` VARCHAR(20) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sales_test_db`.`client`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sales_test_db`.`client` ;

CREATE TABLE IF NOT EXISTS `sales_test_db`.`client` (
  `id` INT NOT NULL,
  `personal_data_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_client_personal_data1_idx` (`personal_data_id` ASC),
  UNIQUE INDEX `personal_data_id_UNIQUE` (`personal_data_id` ASC),
  CONSTRAINT `fk_client_personal_data1`
    FOREIGN KEY (`personal_data_id`)
    REFERENCES `sales_test_db`.`personal_data` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sales_test_db`.`seller`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sales_test_db`.`seller` ;

CREATE TABLE IF NOT EXISTS `sales_test_db`.`seller` (
  `id` INT NOT NULL,
  `personal_data_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_seller_personal_data1_idx` (`personal_data_id` ASC),
  UNIQUE INDEX `personal_data_id_UNIQUE` (`personal_data_id` ASC),
  CONSTRAINT `fk_seller_personal_data1`
    FOREIGN KEY (`personal_data_id`)
    REFERENCES `sales_test_db`.`personal_data` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sales_test_db`.`order`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sales_test_db`.`order` ;

CREATE TABLE IF NOT EXISTS `sales_test_db`.`order` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL,
  `client_id` INT NOT NULL,
  `seller_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_order_client1_idx` (`client_id` ASC),
  INDEX `fk_order_seller1_idx` (`seller_id` ASC),
  CONSTRAINT `fk_order_client1`
    FOREIGN KEY (`client_id`)
    REFERENCES `sales_test_db`.`client` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_seller1`
    FOREIGN KEY (`seller_id`)
    REFERENCES `sales_test_db`.`seller` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sales_test_db`.`category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sales_test_db`.`category` ;

CREATE TABLE IF NOT EXISTS `sales_test_db`.`category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `pid` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_category_category1_idx` (`pid` ASC),
  CONSTRAINT `fk_category_category1`
    FOREIGN KEY (`pid`)
    REFERENCES `sales_test_db`.`category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sales_test_db`.`service`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sales_test_db`.`service` ;

CREATE TABLE IF NOT EXISTS `sales_test_db`.`service` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `price_per_month` INT NOT NULL,
  `category_id` INT NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `connection_cost` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_service_category1_idx` (`category_id` ASC),
  CONSTRAINT `fk_service_category1`
    FOREIGN KEY (`category_id`)
    REFERENCES `sales_test_db`.`category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sales_test_db`.`purchased_services`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sales_test_db`.`purchased_services` ;

CREATE TABLE IF NOT EXISTS `sales_test_db`.`purchased_services` (
  `order_id` INT NOT NULL,
  `service_id` INT NOT NULL,
  `backed_price` INT NOT NULL,
  `amount` INT NOT NULL DEFAULT 1,
  INDEX `fk_perchased_services_order1_idx` (`order_id` ASC),
  INDEX `fk_perchased_services_service1_idx` (`service_id` ASC),
  PRIMARY KEY (`order_id`, `service_id`),
  CONSTRAINT `fk_perchased_services_order1`
    FOREIGN KEY (`order_id`)
    REFERENCES `sales_test_db`.`order` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_perchased_services_service1`
    FOREIGN KEY (`service_id`)
    REFERENCES `sales_test_db`.`service` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SET SQL_MODE = '';
GRANT USAGE ON *.* TO admin;
 DROP USER admin;
SET SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';
CREATE USER 'admin' IDENTIFIED BY 'admin';

GRANT ALL ON `sales_test_db`.* TO 'admin';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
