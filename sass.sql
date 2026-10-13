-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema sass
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sass
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sass` DEFAULT CHARACTER SET utf8 ;
USE `sass` ;

-- -----------------------------------------------------
-- Table `sass`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sass`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `loginId` INT NOT NULL,
  `password` VARCHAR(225) NOT NULL,
  `role` VARCHAR(45) NOT NULL,
  `firstname` VARCHAR(45) NOT NULL,
  `middlename` VARCHAR(45) NOT NULL,
  `lastname` VARCHAR(45) NOT NULL,
  `sex` VARCHAR(45) NOT NULL,
  `age` INT NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `program` VARCHAR(45) NOT NULL,
  `year` VARCHAR(45) NOT NULL,
  `contact` INT NOT NULL,
  `address` VARCHAR(45) NOT NULL,
  `status` VARCHAR(45) NOT NULL DEFAULT 'approved',
  `created_at` DATETIME NULL,
  `verification_remark` TEXT NULL,
  `login_at` TIME NULL,
  `logout_at` TIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sass`.`files`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sass`.`files` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `userId` INT NOT NULL,
  `fileName` VARCHAR(255) NOT NULL,
  `fileType` VARCHAR(45) NOT NULL,
  `fileSize` INT NOT NULL,
  `fileData` MEDIUMBLOB NOT NULL,
  `fileRole` VARCHAR(45) NOT NULL,
  `fileStatus` VARCHAR(45) NOT NULL,
  `critic` LONGTEXT NULL,
  `upload_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `userId_idx` (`userId` ASC) VISIBLE,
  CONSTRAINT `userId`
    FOREIGN KEY (`userId`)
    REFERENCES `sass`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- For an existing files table, run this migration once. The old TIME value
-- cannot recover the original submission date, so existing rows use today's date.
-- ALTER TABLE `sass`.`files`
--   MODIFY `id` INT NOT NULL AUTO_INCREMENT,
--   MODIFY `fileName` VARCHAR(255) NOT NULL,
--   ADD COLUMN `upload_at_new` DATETIME NULL;
-- UPDATE `sass`.`files`
--   SET `upload_at_new` = TIMESTAMP(CURRENT_DATE(), `upload_at`);
-- ALTER TABLE `sass`.`files`
--   DROP COLUMN `upload_at`,
--   CHANGE `upload_at_new` `upload_at` DATETIME NOT NULL;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
