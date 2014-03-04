SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `mtfw` ;
CREATE SCHEMA IF NOT EXISTS `mtfw` DEFAULT CHARACTER SET utf8 ;
USE `mtfw` ;

-- -----------------------------------------------------
-- Table `mtfw`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mtfw`.`user` ;

CREATE  TABLE IF NOT EXISTS `mtfw`.`user` (
  `u_id` INT NOT NULL AUTO_INCREMENT ,
  `u_name` VARCHAR(255) NOT NULL ,
  `u_pwd` VARCHAR(255) NOT NULL ,
  `u_mail` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`u_id`) )
ENGINE = InnoDB;

GRANT ALL PRIVILEGES  ON mtfw.* TO `mtfw_user`@`localhost` IDENTIFIED BY 'password' WITH GRANT OPTION;
