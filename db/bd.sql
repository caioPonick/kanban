-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema kanban-login
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema kanban-login
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `kanban-login` DEFAULT CHARACTER SET utf8 ;
USE `kanban-login` ;

-- -----------------------------------------------------
-- Table `kanban-login`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kanban-login`.`usuario` (
  `idtarefa` INT NOT NULL AUTO_INCREMENT,
  `nomeUsuario` VARCHAR(45) NOT NULL,
  `senhaUsuario` VARCHAR(45) NOT NULL,
  `emailUsuario` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idtarefa`),
  UNIQUE INDEX `idtarefa_UNIQUE` (`idtarefa` ASC) VISIBLE,
  UNIQUE INDEX `senhaUsuario_UNIQUE` (`senhaUsuario` ASC) VISIBLE)
ENGINE = InnoDB;

INSERT INTO `kanban-login`.`usuario` (`nomeUsuario`, `senhaUsuario`, `emailUsuario`) VALUES ('Admin', 'admin123', 'admin@kanban.com');


-- -----------------------------------------------------
-- Table `kanban-login`.`tarefa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kanban-login`.`tarefa` (
  `idtarefa` INT NOT NULL AUTO_INCREMENT,
  `usuario_idtarefa` INT NOT NULL,
  `descricaoTarefa` VARCHAR(45) NOT NULL,
  `setor` VARCHAR(45) NOT NULL,
  `prioridade` ENUM('baixa', 'media', 'alta') NOT NULL,
  `data` DATE NOT NULL,
  `status` ENUM('a fazer', 'fazendo', 'feito') NOT NULL,
  PRIMARY KEY (`idtarefa`),
  UNIQUE INDEX `idtarefa_UNIQUE` (`idtarefa` ASC) VISIBLE,
  INDEX `fk_tarefa_usuario_idx` (`usuario_idtarefa` ASC) VISIBLE,
  CONSTRAINT `fk_tarefa_usuario`
    FOREIGN KEY (`usuario_idtarefa`)
    REFERENCES `kanban-login`.`usuario` (`idtarefa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
