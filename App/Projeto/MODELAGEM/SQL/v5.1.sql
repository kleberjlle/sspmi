-- MySQL Script generated by MySQL Workbench
-- Wed Apr 24 09:01:18 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema sspmi
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sspmi
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sspmi` DEFAULT CHARACTER SET utf8 ;
USE `sspmi` ;

-- -----------------------------------------------------
-- Table `sspmi`.`secretaria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sspmi`.`secretaria` (
  `idsecretaria` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(100) NOT NULL,
  `endereco` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idsecretaria`),
  UNIQUE INDEX `idsecretaria_UNIQUE` (`idsecretaria` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sspmi`.`departamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sspmi`.`departamento` (
  `iddepartamento` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(100) NOT NULL,
  `endereco` VARCHAR(100) NOT NULL,
  `secretaria_idsecretaria` INT NOT NULL,
  PRIMARY KEY (`iddepartamento`, `secretaria_idsecretaria`),
  UNIQUE INDEX `iddepartamento_UNIQUE` (`iddepartamento` ASC),
  INDEX `fk_departamento_secretaria1_idx` (`secretaria_idsecretaria` ASC),
  CONSTRAINT `fk_departamento_secretaria1`
    FOREIGN KEY (`secretaria_idsecretaria`)
    REFERENCES `sspmi`.`secretaria` (`idsecretaria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sspmi`.`coordenacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sspmi`.`coordenacao` (
  `idcoordenacao` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(100) NOT NULL,
  `endereco` VARCHAR(100) NOT NULL,
  `departamento_secretaria_idsecretaria` INT NOT NULL,
  PRIMARY KEY (`idcoordenacao`, `departamento_secretaria_idsecretaria`),
  UNIQUE INDEX `idcoordenacao_UNIQUE` (`idcoordenacao` ASC),
  INDEX `fk_coordenacao_departamento1_idx` (`departamento_secretaria_idsecretaria` ASC),
  CONSTRAINT `fk_coordenacao_departamento1`
    FOREIGN KEY (`departamento_secretaria_idsecretaria`)
    REFERENCES `sspmi`.`departamento` (`secretaria_idsecretaria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sspmi`.`setor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sspmi`.`setor` (
  `idsetor` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(100) NOT NULL,
  `endereco` VARCHAR(100) NOT NULL,
  `coordenacao_departamento_iddepartamento` INT NULL,
  `coordenacao_departamento_secretaria_idsecretaria` INT NULL,
  PRIMARY KEY (`idsetor`),
  UNIQUE INDEX `idsetor_UNIQUE` (`idsetor` ASC),
  INDEX `fk_setor_coordenacao1_idx` (`coordenacao_departamento_iddepartamento` ASC, `coordenacao_departamento_secretaria_idsecretaria` ASC),
  CONSTRAINT `fk_setor_coordenacao1`
    FOREIGN KEY (`coordenacao_departamento_secretaria_idsecretaria`)
    REFERENCES `sspmi`.`coordenacao` (`departamento_secretaria_idsecretaria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sspmi`.`telefone`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sspmi`.`telefone` (
  `idtelefone` INT NOT NULL AUTO_INCREMENT,
  `whatsApp` CHAR(1) NOT NULL DEFAULT 'N',
  `numero` VARCHAR(11) NULL,
  PRIMARY KEY (`idtelefone`),
  UNIQUE INDEX `idtelefone_UNIQUE` (`idtelefone` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sspmi`.`cargo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sspmi`.`cargo` (
  `idcargo` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idcargo`),
  UNIQUE INDEX `idcargo_UNIQUE` (`idcargo` ASC),
  UNIQUE INDEX `nomenclatura_UNIQUE` (`nomenclatura` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sspmi`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sspmi`.`usuario` (
  `idusuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `sobrenome` VARCHAR(200) NOT NULL,
  `sexo` CHAR(1) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `imagem` VARCHAR(45) NOT NULL DEFAULT 'default.jpg',
  `situacao` CHAR(1) NOT NULL DEFAULT 0,
  `setor_idsetor` INT NULL,
  `coordenacao_idcoordenacao` INT NULL,
  `departamento_iddepartamento` INT NULL,
  `secretaria_idsecretaria` INT NOT NULL,
  `telefone_idtelefone` INT NULL,
  `cargo_idcargo` INT NOT NULL,
  PRIMARY KEY (`idusuario`, `secretaria_idsecretaria`, `cargo_idcargo`),
  UNIQUE INDEX `idusuario_UNIQUE` (`idusuario` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `fk_usuario_setor1_idx` (`setor_idsetor` ASC),
  INDEX `fk_usuario_coordenacao1_idx` (`coordenacao_idcoordenacao` ASC),
  INDEX `fk_usuario_departamento1_idx` (`departamento_iddepartamento` ASC),
  INDEX `fk_usuario_secretaria1_idx` (`secretaria_idsecretaria` ASC),
  INDEX `fk_usuario_telefone1_idx` (`telefone_idtelefone` ASC),
  INDEX `fk_usuario_cargo1_idx` (`cargo_idcargo` ASC),
  CONSTRAINT `fk_usuario_setor1`
    FOREIGN KEY (`setor_idsetor`)
    REFERENCES `sspmi`.`setor` (`idsetor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_coordenacao1`
    FOREIGN KEY (`coordenacao_idcoordenacao`)
    REFERENCES `sspmi`.`coordenacao` (`idcoordenacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_departamento1`
    FOREIGN KEY (`departamento_iddepartamento`)
    REFERENCES `sspmi`.`departamento` (`iddepartamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_secretaria1`
    FOREIGN KEY (`secretaria_idsecretaria`)
    REFERENCES `sspmi`.`secretaria` (`idsecretaria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_telefone1`
    FOREIGN KEY (`telefone_idtelefone`)
    REFERENCES `sspmi`.`telefone` (`idtelefone`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_cargo1`
    FOREIGN KEY (`cargo_idcargo`)
    REFERENCES `sspmi`.`cargo` (`idcargo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sspmi`.`historico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sspmi`.`historico` (
  `idhistorico` INT NOT NULL AUTO_INCREMENT,
  `pagina` VARCHAR(45) NOT NULL,
  `acao` VARCHAR(45) NOT NULL,
  `campo` VARCHAR(100) NOT NULL,
  `valorAtual` VARCHAR(100) NOT NULL,
  `valorAnterior` VARCHAR(100) NOT NULL,
  `dataHora` TIMESTAMP NOT NULL,
  `ip` VARCHAR(12) NOT NULL,
  `navegador` VARCHAR(100) NOT NULL,
  `usuario_idusuario` INT NOT NULL,
  `usuario_secretaria_idsecretaria` INT NOT NULL,
  PRIMARY KEY (`idhistorico`, `usuario_idusuario`, `usuario_secretaria_idsecretaria`),
  UNIQUE INDEX `idhistorico_UNIQUE` (`idhistorico` ASC),
  INDEX `fk_historico_usuario1_idx` (`usuario_idusuario` ASC, `usuario_secretaria_idsecretaria` ASC),
  CONSTRAINT `fk_historico_usuario1`
    FOREIGN KEY (`usuario_idusuario` , `usuario_secretaria_idsecretaria`)
    REFERENCES `sspmi`.`usuario` (`idusuario` , `secretaria_idsecretaria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sspmi`.`telefone_has_secretaria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sspmi`.`telefone_has_secretaria` (
  `telefone_idtelefone` INT NOT NULL,
  `secretaria_idsecretaria` INT NOT NULL,
  PRIMARY KEY (`telefone_idtelefone`, `secretaria_idsecretaria`),
  INDEX `fk_telefone_has_secretaria_secretaria1_idx` (`secretaria_idsecretaria` ASC),
  INDEX `fk_telefone_has_secretaria_telefone1_idx` (`telefone_idtelefone` ASC),
  CONSTRAINT `fk_telefone_has_secretaria_telefone1`
    FOREIGN KEY (`telefone_idtelefone`)
    REFERENCES `sspmi`.`telefone` (`idtelefone`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_telefone_has_secretaria_secretaria1`
    FOREIGN KEY (`secretaria_idsecretaria`)
    REFERENCES `sspmi`.`secretaria` (`idsecretaria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sspmi`.`telefone_has_departamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sspmi`.`telefone_has_departamento` (
  `telefone_idtelefone` INT NOT NULL,
  `departamento_iddepartamento` INT NOT NULL,
  `departamento_secretaria_idsecretaria` INT NOT NULL,
  PRIMARY KEY (`telefone_idtelefone`, `departamento_iddepartamento`, `departamento_secretaria_idsecretaria`),
  INDEX `fk_telefone_has_departamento_departamento1_idx` (`departamento_iddepartamento` ASC, `departamento_secretaria_idsecretaria` ASC),
  INDEX `fk_telefone_has_departamento_telefone1_idx` (`telefone_idtelefone` ASC),
  CONSTRAINT `fk_telefone_has_departamento_telefone1`
    FOREIGN KEY (`telefone_idtelefone`)
    REFERENCES `sspmi`.`telefone` (`idtelefone`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_telefone_has_departamento_departamento1`
    FOREIGN KEY (`departamento_iddepartamento` , `departamento_secretaria_idsecretaria`)
    REFERENCES `sspmi`.`departamento` (`iddepartamento` , `secretaria_idsecretaria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sspmi`.`telefone_has_coordenacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sspmi`.`telefone_has_coordenacao` (
  `telefone_idtelefone` INT NOT NULL,
  `coordenacao_idcoordenacao` INT NOT NULL,
  `coordenacao_departamento_iddepartamento` INT NOT NULL,
  PRIMARY KEY (`telefone_idtelefone`, `coordenacao_idcoordenacao`, `coordenacao_departamento_iddepartamento`),
  INDEX `fk_telefone_has_coordenacao_coordenacao1_idx` (`coordenacao_idcoordenacao` ASC, `coordenacao_departamento_iddepartamento` ASC),
  INDEX `fk_telefone_has_coordenacao_telefone1_idx` (`telefone_idtelefone` ASC),
  CONSTRAINT `fk_telefone_has_coordenacao_telefone1`
    FOREIGN KEY (`telefone_idtelefone`)
    REFERENCES `sspmi`.`telefone` (`idtelefone`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_telefone_has_coordenacao_coordenacao1`
    FOREIGN KEY (`coordenacao_idcoordenacao`)
    REFERENCES `sspmi`.`coordenacao` (`idcoordenacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sspmi`.`telefone_has_setor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sspmi`.`telefone_has_setor` (
  `telefone_idtelefone` INT NOT NULL,
  `setor_idsetor` INT NOT NULL,
  `setor_coordenacao_idcoordenacao` INT NOT NULL,
  PRIMARY KEY (`telefone_idtelefone`, `setor_idsetor`, `setor_coordenacao_idcoordenacao`),
  INDEX `fk_telefone_has_setor_setor1_idx` (`setor_idsetor` ASC, `setor_coordenacao_idcoordenacao` ASC),
  INDEX `fk_telefone_has_setor_telefone1_idx` (`telefone_idtelefone` ASC),
  CONSTRAINT `fk_telefone_has_setor_telefone1`
    FOREIGN KEY (`telefone_idtelefone`)
    REFERENCES `sspmi`.`telefone` (`idtelefone`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_telefone_has_setor_setor1`
    FOREIGN KEY (`setor_idsetor`)
    REFERENCES `sspmi`.`setor` (`idsetor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
