-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema KANBAN
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema KANBAN
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `KANBAN` DEFAULT CHARACTER SET utf8 ;
USE `KANBAN` ;

-- -----------------------------------------------------
-- Table `KANBAN`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KANBAN`.`usuario` (
  `idusuario` INT NOT NULL AUTO_INCREMENT,
  `nomeUsuario` VARCHAR(45) NOT NULL,
  `emailUsuario` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idusuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `KANBAN`.`tarefa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KANBAN`.`tarefa` (
  `idtarefa` INT NOT NULL AUTO_INCREMENT,
  `usuario_idusuario` INT NOT NULL,
  `descricaoTarefa` VARCHAR(45) NOT NULL,
  `setor` VARCHAR(45) NOT NULL,
  `prioridade` ENUM('baixa', 'media', 'alta') NOT NULL,
  `data` DATE NOT NULL,
  `status` ENUM('a fazer', 'fazendo', 'feito') NOT NULL,
  PRIMARY KEY (`idtarefa`),
  INDEX `fk_tarefa_usuario_idx` (`usuario_idusuario` ASC) VISIBLE,
  CONSTRAINT `fk_tarefa_usuario`
    FOREIGN KEY (`usuario_idusuario`)
    REFERENCES `KANBAN`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


