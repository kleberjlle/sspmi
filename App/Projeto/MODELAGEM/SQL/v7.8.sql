-- MySQL Script generated by MySQL Workbench
-- Wed Jul 24 13:12:11 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema itapoaap_sspmi
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema itapoaap_sspmi
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `itapoaap_sspmi` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `itapoaap_sspmi` ;

-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`ambiente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`ambiente` (
  `idambiente` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idambiente`),
  UNIQUE INDEX `idambiente_UNIQUE` (`idambiente` ASC),
  UNIQUE INDEX `nomenclatura_UNIQUE` (`nomenclatura` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`secretaria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`secretaria` (
  `idsecretaria` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(100) NOT NULL,
  `endereco` VARCHAR(100) NOT NULL,
  `ambiente_idambiente` INT NOT NULL,
  PRIMARY KEY (`idsecretaria`, `ambiente_idambiente`),
  UNIQUE INDEX `idsecretaria_UNIQUE` (`idsecretaria` ASC),
  INDEX `fk_secretaria_ambiente1_idx` (`ambiente_idambiente` ASC),
  CONSTRAINT `fk_secretaria_ambiente1`
    FOREIGN KEY (`ambiente_idambiente`)
    REFERENCES `itapoaap_sspmi`.`ambiente` (`idambiente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`setor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`setor` (
  `idsetor` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(100) NOT NULL,
  `endereco` VARCHAR(100) NOT NULL,
  `secretaria_idsecretaria` INT NOT NULL,
  PRIMARY KEY (`idsetor`, `secretaria_idsecretaria`),
  UNIQUE INDEX `idsetor_UNIQUE` (`idsetor` ASC),
  INDEX `fk_setor_secretaria1_idx` (`secretaria_idsecretaria` ASC),
  CONSTRAINT `fk_setor_secretaria1`
    FOREIGN KEY (`secretaria_idsecretaria`)
    REFERENCES `itapoaap_sspmi`.`secretaria` (`idsecretaria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`coordenacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`coordenacao` (
  `idcoordenacao` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(100) NOT NULL,
  `endereco` VARCHAR(100) NOT NULL,
  `secretaria_idsecretaria` INT NOT NULL,
  PRIMARY KEY (`idcoordenacao`),
  UNIQUE INDEX `idcoordenacao_UNIQUE` (`idcoordenacao` ASC),
  INDEX `fk_coordenacao_secretaria1_idx` (`secretaria_idsecretaria` ASC),
  CONSTRAINT `fk_coordenacao_secretaria1`
    FOREIGN KEY (`secretaria_idsecretaria`)
    REFERENCES `itapoaap_sspmi`.`secretaria` (`idsecretaria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`departamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`departamento` (
  `iddepartamento` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(100) NOT NULL,
  `endereco` VARCHAR(100) NOT NULL,
  `secretaria_idsecretaria` INT NOT NULL,
  PRIMARY KEY (`iddepartamento`, `secretaria_idsecretaria`),
  UNIQUE INDEX `iddepartamento_UNIQUE` (`iddepartamento` ASC),
  INDEX `fk_departamento_secretaria1_idx` (`secretaria_idsecretaria` ASC),
  CONSTRAINT `fk_departamento_secretaria1`
    FOREIGN KEY (`secretaria_idsecretaria`)
    REFERENCES `itapoaap_sspmi`.`secretaria` (`idsecretaria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`telefone`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`telefone` (
  `idtelefone` INT NOT NULL AUTO_INCREMENT,
  `whatsApp` TINYINT NOT NULL DEFAULT 0,
  `numero` VARCHAR(11) NULL,
  PRIMARY KEY (`idtelefone`),
  UNIQUE INDEX `idtelefone_UNIQUE` (`idtelefone` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`cargo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`cargo` (
  `idcargo` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idcargo`),
  UNIQUE INDEX `idcargo_UNIQUE` (`idcargo` ASC),
  UNIQUE INDEX `nomenclatura_UNIQUE` (`nomenclatura` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`email`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`email` (
  `idemail` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(100) NULL,
  `senha` VARCHAR(100) NULL,
  PRIMARY KEY (`idemail`),
  UNIQUE INDEX `idemail_UNIQUE` (`idemail` ASC),
  UNIQUE INDEX `nomenclatura_UNIQUE` (`nomenclatura` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`permissao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`permissao` (
  `idpermissao` INT NOT NULL AUTO_INCREMENT,
  `nivel` INT NOT NULL,
  `nomenclatura` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idpermissao`),
  UNIQUE INDEX `idpermissao_UNIQUE` (`idpermissao` ASC),
  UNIQUE INDEX `nomenclatura_UNIQUE` (`nomenclatura` ASC),
  UNIQUE INDEX `nivel_UNIQUE` (`nivel` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`usuario` (
  `idusuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `sobrenome` VARCHAR(200) NOT NULL,
  `sexo` CHAR(1) NOT NULL,
  `imagem` VARCHAR(45) NOT NULL DEFAULT 'default.jpg',
  `situacao` TINYINT NOT NULL DEFAULT 0,
  `setor_idsetor` INT NULL,
  `coordenacao_idcoordenacao` INT NULL,
  `departamento_iddepartamento` INT NULL,
  `secretaria_idsecretaria` INT NOT NULL,
  `telefone_idtelefone` INT NULL,
  `cargo_idcargo` INT NOT NULL,
  `email_idemail` INT NOT NULL,
  `permissao_idpermissao` INT NOT NULL,
  PRIMARY KEY (`idusuario`, `secretaria_idsecretaria`, `cargo_idcargo`, `email_idemail`, `permissao_idpermissao`),
  UNIQUE INDEX `idusuario_UNIQUE` (`idusuario` ASC),
  INDEX `fk_usuario_setor1_idx` (`setor_idsetor` ASC),
  INDEX `fk_usuario_coordenacao1_idx` (`coordenacao_idcoordenacao` ASC),
  INDEX `fk_usuario_departamento1_idx` (`departamento_iddepartamento` ASC),
  INDEX `fk_usuario_secretaria1_idx` (`secretaria_idsecretaria` ASC),
  INDEX `fk_usuario_telefone1_idx` (`telefone_idtelefone` ASC),
  INDEX `fk_usuario_cargo1_idx` (`cargo_idcargo` ASC),
  INDEX `fk_usuario_email1_idx` (`email_idemail` ASC),
  INDEX `fk_usuario_permissao1_idx` (`permissao_idpermissao` ASC),
  CONSTRAINT `fk_usuario_setor1`
    FOREIGN KEY (`setor_idsetor`)
    REFERENCES `itapoaap_sspmi`.`setor` (`idsetor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_coordenacao1`
    FOREIGN KEY (`coordenacao_idcoordenacao`)
    REFERENCES `itapoaap_sspmi`.`coordenacao` (`idcoordenacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_departamento1`
    FOREIGN KEY (`departamento_iddepartamento`)
    REFERENCES `itapoaap_sspmi`.`departamento` (`iddepartamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_secretaria1`
    FOREIGN KEY (`secretaria_idsecretaria`)
    REFERENCES `itapoaap_sspmi`.`secretaria` (`idsecretaria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_telefone1`
    FOREIGN KEY (`telefone_idtelefone`)
    REFERENCES `itapoaap_sspmi`.`telefone` (`idtelefone`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_cargo1`
    FOREIGN KEY (`cargo_idcargo`)
    REFERENCES `itapoaap_sspmi`.`cargo` (`idcargo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_email1`
    FOREIGN KEY (`email_idemail`)
    REFERENCES `itapoaap_sspmi`.`email` (`idemail`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_permissao1`
    FOREIGN KEY (`permissao_idpermissao`)
    REFERENCES `itapoaap_sspmi`.`permissao` (`idpermissao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`historico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`historico` (
  `idhistorico` INT NOT NULL AUTO_INCREMENT,
  `pagina` VARCHAR(254) NOT NULL,
  `acao` VARCHAR(254) NOT NULL,
  `campo` VARCHAR(254) NOT NULL,
  `valorAtual` VARCHAR(254) NOT NULL,
  `valorAnterior` VARCHAR(254) NULL,
  `dataHora` TIMESTAMP NOT NULL,
  `ip` VARCHAR(254) NOT NULL,
  `navegador` VARCHAR(254) NOT NULL,
  `sistemaOperacional` VARCHAR(254) NOT NULL,
  `nomeDoDispositivo` VARCHAR(254) NOT NULL,
  `idusuario` VARCHAR(254) NULL,
  PRIMARY KEY (`idhistorico`),
  UNIQUE INDEX `idhistorico_UNIQUE` (`idhistorico` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`telefone_has_secretaria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`telefone_has_secretaria` (
  `telefone_idtelefone` INT NOT NULL,
  `secretaria_idsecretaria` INT NOT NULL,
  PRIMARY KEY (`telefone_idtelefone`, `secretaria_idsecretaria`),
  INDEX `fk_telefone_has_secretaria_secretaria1_idx` (`secretaria_idsecretaria` ASC),
  INDEX `fk_telefone_has_secretaria_telefone1_idx` (`telefone_idtelefone` ASC),
  CONSTRAINT `fk_telefone_has_secretaria_telefone1`
    FOREIGN KEY (`telefone_idtelefone`)
    REFERENCES `itapoaap_sspmi`.`telefone` (`idtelefone`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_telefone_has_secretaria_secretaria1`
    FOREIGN KEY (`secretaria_idsecretaria`)
    REFERENCES `itapoaap_sspmi`.`secretaria` (`idsecretaria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`telefone_has_departamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`telefone_has_departamento` (
  `telefone_idtelefone` INT NOT NULL,
  `departamento_iddepartamento` INT NOT NULL,
  PRIMARY KEY (`telefone_idtelefone`, `departamento_iddepartamento`),
  INDEX `fk_telefone_has_departamento_departamento1_idx` (`departamento_iddepartamento` ASC),
  INDEX `fk_telefone_has_departamento_telefone1_idx` (`telefone_idtelefone` ASC),
  CONSTRAINT `fk_telefone_has_departamento_telefone1`
    FOREIGN KEY (`telefone_idtelefone`)
    REFERENCES `itapoaap_sspmi`.`telefone` (`idtelefone`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_telefone_has_departamento_departamento1`
    FOREIGN KEY (`departamento_iddepartamento`)
    REFERENCES `itapoaap_sspmi`.`departamento` (`iddepartamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`telefone_has_coordenacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`telefone_has_coordenacao` (
  `telefone_idtelefone` INT NOT NULL,
  `coordenacao_idcoordenacao` INT NOT NULL,
  PRIMARY KEY (`telefone_idtelefone`, `coordenacao_idcoordenacao`),
  INDEX `fk_telefone_has_coordenacao_coordenacao1_idx` (`coordenacao_idcoordenacao` ASC),
  INDEX `fk_telefone_has_coordenacao_telefone1_idx` (`telefone_idtelefone` ASC),
  CONSTRAINT `fk_telefone_has_coordenacao_telefone1`
    FOREIGN KEY (`telefone_idtelefone`)
    REFERENCES `itapoaap_sspmi`.`telefone` (`idtelefone`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_telefone_has_coordenacao_coordenacao1`
    FOREIGN KEY (`coordenacao_idcoordenacao`)
    REFERENCES `itapoaap_sspmi`.`coordenacao` (`idcoordenacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`telefone_has_setor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`telefone_has_setor` (
  `telefone_idtelefone` INT NOT NULL,
  `setor_idsetor` INT NOT NULL,
  PRIMARY KEY (`telefone_idtelefone`, `setor_idsetor`),
  INDEX `fk_telefone_has_setor_setor1_idx` (`setor_idsetor` ASC),
  INDEX `fk_telefone_has_setor_telefone1_idx` (`telefone_idtelefone` ASC),
  CONSTRAINT `fk_telefone_has_setor_telefone1`
    FOREIGN KEY (`telefone_idtelefone`)
    REFERENCES `itapoaap_sspmi`.`telefone` (`idtelefone`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_telefone_has_setor_setor1`
    FOREIGN KEY (`setor_idsetor`)
    REFERENCES `itapoaap_sspmi`.`setor` (`idsetor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`email_has_setor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`email_has_setor` (
  `email_idemail` INT NOT NULL,
  `setor_idsetor` INT NOT NULL,
  PRIMARY KEY (`email_idemail`, `setor_idsetor`),
  INDEX `fk_email_has_setor_setor1_idx` (`setor_idsetor` ASC),
  INDEX `fk_email_has_setor_email1_idx` (`email_idemail` ASC),
  CONSTRAINT `fk_email_has_setor_email1`
    FOREIGN KEY (`email_idemail`)
    REFERENCES `itapoaap_sspmi`.`email` (`idemail`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_email_has_setor_setor1`
    FOREIGN KEY (`setor_idsetor`)
    REFERENCES `itapoaap_sspmi`.`setor` (`idsetor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`email_has_coordenacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`email_has_coordenacao` (
  `email_idemail` INT NOT NULL,
  `coordenacao_idcoordenacao` INT NOT NULL,
  PRIMARY KEY (`email_idemail`, `coordenacao_idcoordenacao`),
  INDEX `fk_email_has_coordenacao_coordenacao1_idx` (`coordenacao_idcoordenacao` ASC),
  INDEX `fk_email_has_coordenacao_email1_idx` (`email_idemail` ASC),
  CONSTRAINT `fk_email_has_coordenacao_email1`
    FOREIGN KEY (`email_idemail`)
    REFERENCES `itapoaap_sspmi`.`email` (`idemail`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_email_has_coordenacao_coordenacao1`
    FOREIGN KEY (`coordenacao_idcoordenacao`)
    REFERENCES `itapoaap_sspmi`.`coordenacao` (`idcoordenacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`email_has_departamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`email_has_departamento` (
  `email_idemail` INT NOT NULL,
  `departamento_iddepartamento` INT NOT NULL,
  PRIMARY KEY (`email_idemail`, `departamento_iddepartamento`),
  INDEX `fk_email_has_departamento_departamento1_idx` (`departamento_iddepartamento` ASC),
  INDEX `fk_email_has_departamento_email1_idx` (`email_idemail` ASC),
  CONSTRAINT `fk_email_has_departamento_email1`
    FOREIGN KEY (`email_idemail`)
    REFERENCES `itapoaap_sspmi`.`email` (`idemail`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_email_has_departamento_departamento1`
    FOREIGN KEY (`departamento_iddepartamento`)
    REFERENCES `itapoaap_sspmi`.`departamento` (`iddepartamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`email_has_secretaria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`email_has_secretaria` (
  `email_idemail` INT NOT NULL,
  `secretaria_idsecretaria` INT NOT NULL,
  PRIMARY KEY (`email_idemail`, `secretaria_idsecretaria`),
  INDEX `fk_email_has_secretaria_secretaria1_idx` (`secretaria_idsecretaria` ASC),
  INDEX `fk_email_has_secretaria_email1_idx` (`email_idemail` ASC),
  CONSTRAINT `fk_email_has_secretaria_email1`
    FOREIGN KEY (`email_idemail`)
    REFERENCES `itapoaap_sspmi`.`email` (`idemail`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_email_has_secretaria_secretaria1`
    FOREIGN KEY (`secretaria_idsecretaria`)
    REFERENCES `itapoaap_sspmi`.`secretaria` (`idsecretaria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`protocolo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`protocolo` (
  `idprotocolo` INT NOT NULL AUTO_INCREMENT,
  `dataHoraAbertura` TIMESTAMP NOT NULL,
  `dataHoraEncerramento` DATETIME NULL,
  `nomeDoRequerente` VARCHAR(45) NOT NULL,
  `sobrenomeDoRequerente` VARCHAR(100) NOT NULL,
  `telefoneDoRequerente` VARCHAR(45) NULL,
  `whatsAppDoRequerente` VARCHAR(11) NOT NULL,
  `emailDoRequerente` VARCHAR(100) NOT NULL,
  `usuario_idusuario` INT NOT NULL,
  `secretaria` VARCHAR(100) NOT NULL,
  `departamento` VARCHAR(100) NOT NULL,
  `coordenacao` VARCHAR(100) NOT NULL,
  `setor` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idprotocolo`, `usuario_idusuario`),
  UNIQUE INDEX `idprotocolo_UNIQUE` (`idprotocolo` ASC),
  INDEX `fk_protocolo_usuario1_idx` (`usuario_idusuario` ASC),
  CONSTRAINT `fk_protocolo_usuario1`
    FOREIGN KEY (`usuario_idusuario`)
    REFERENCES `itapoaap_sspmi`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`categoria` (
  `idcategoria` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(100) NOT NULL DEFAULT 'indefinida',
  PRIMARY KEY (`idcategoria`),
  UNIQUE INDEX `idcategoria_UNIQUE` (`idcategoria` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`tensao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`tensao` (
  `idtensao` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`idtensao`),
  UNIQUE INDEX `idtensao_UNIQUE` (`idtensao` ASC),
  UNIQUE INDEX `nomenclatura_UNIQUE` (`nomenclatura` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`corrente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`corrente` (
  `idcorrente` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`idcorrente`),
  UNIQUE INDEX `idcorrente_UNIQUE` (`idcorrente` ASC),
  UNIQUE INDEX `nomenclatura_UNIQUE` (`nomenclatura` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`sistemaOperacional`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`sistemaOperacional` (
  `idsistemaOperacional` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idsistemaOperacional`),
  UNIQUE INDEX `idsistemaOperacional_UNIQUE` (`idsistemaOperacional` ASC),
  UNIQUE INDEX `nomenclatura_UNIQUE` (`nomenclatura` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`marca`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`marca` (
  `idmarca` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idmarca`),
  UNIQUE INDEX `idmarca_UNIQUE` (`idmarca` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`modelo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`modelo` (
  `idmodelo` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(100) NOT NULL,
  `marca_idmarca` INT NOT NULL,
  PRIMARY KEY (`idmodelo`, `marca_idmarca`),
  UNIQUE INDEX `idmodelo_UNIQUE` (`idmodelo` ASC),
  INDEX `fk_modelo_marca1_idx` (`marca_idmarca` ASC),
  CONSTRAINT `fk_modelo_marca1`
    FOREIGN KEY (`marca_idmarca`)
    REFERENCES `itapoaap_sspmi`.`marca` (`idmarca`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`equipamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`equipamento` (
  `idequipamento` INT NOT NULL AUTO_INCREMENT,
  `patrimonio` VARCHAR(10) NOT NULL,
  `categoria_idcategoria` INT NOT NULL,
  `tensao_idtensao` INT NULL,
  `corrente_idcorrente` INT NULL,
  `sistemaOperacional_idsistemaOperacional` INT NULL,
  `numeroDeSerie` VARCHAR(100) NULL,
  `etiquetaDeServico` VARCHAR(100) NULL,
  `modelo_idmodelo` INT NOT NULL,
  `ambiente_idambiente` INT NOT NULL,
  PRIMARY KEY (`idequipamento`, `categoria_idcategoria`, `modelo_idmodelo`, `ambiente_idambiente`),
  UNIQUE INDEX `idequipamento_UNIQUE` (`idequipamento` ASC),
  INDEX `fk_equipamento_categoria1_idx` (`categoria_idcategoria` ASC),
  INDEX `fk_equipamento_tensao1_idx` (`tensao_idtensao` ASC),
  INDEX `fk_equipamento_corrente1_idx` (`corrente_idcorrente` ASC),
  INDEX `fk_equipamento_sistemaOperacional1_idx` (`sistemaOperacional_idsistemaOperacional` ASC),
  INDEX `fk_equipamento_modelo1_idx` (`modelo_idmodelo` ASC),
  INDEX `fk_equipamento_ambiente1_idx` (`ambiente_idambiente` ASC),
  CONSTRAINT `fk_equipamento_categoria1`
    FOREIGN KEY (`categoria_idcategoria`)
    REFERENCES `itapoaap_sspmi`.`categoria` (`idcategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipamento_tensao1`
    FOREIGN KEY (`tensao_idtensao`)
    REFERENCES `itapoaap_sspmi`.`tensao` (`idtensao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipamento_corrente1`
    FOREIGN KEY (`corrente_idcorrente`)
    REFERENCES `itapoaap_sspmi`.`corrente` (`idcorrente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipamento_sistemaOperacional1`
    FOREIGN KEY (`sistemaOperacional_idsistemaOperacional`)
    REFERENCES `itapoaap_sspmi`.`sistemaOperacional` (`idsistemaOperacional`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipamento_modelo1`
    FOREIGN KEY (`modelo_idmodelo`)
    REFERENCES `itapoaap_sspmi`.`modelo` (`idmodelo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipamento_ambiente1`
    FOREIGN KEY (`ambiente_idambiente`)
    REFERENCES `itapoaap_sspmi`.`ambiente` (`idambiente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`local`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`local` (
  `idlocal` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idlocal`),
  UNIQUE INDEX `idlocal_UNIQUE` (`idlocal` ASC),
  UNIQUE INDEX `nomenclatura_UNIQUE` (`nomenclatura` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`prioridade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`prioridade` (
  `idprioridade` INT NOT NULL AUTO_INCREMENT,
  `nomenclatura` VARCHAR(45) NOT NULL DEFAULT 'normal',
  PRIMARY KEY (`idprioridade`),
  UNIQUE INDEX `idprioridade_UNIQUE` (`idprioridade` ASC),
  UNIQUE INDEX `nomenclatura_UNIQUE` (`nomenclatura` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`etapa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`etapa` (
  `idetapa` INT NOT NULL AUTO_INCREMENT,
  `numero` INT NOT NULL,
  `dataHoraAbertura` TIMESTAMP NOT NULL,
  `dataHoraEncerramento` DATETIME NULL,
  `acessoRemoto` VARCHAR(45) NULL,
  `descricao` VARCHAR(254) NOT NULL,
  `equipamento_idequipamento` INT NOT NULL,
  `protocolo_idprotocolo` INT NOT NULL,
  `local_idlocal` INT NOT NULL,
  `prioridade_idprioridade` INT NOT NULL,
  PRIMARY KEY (`idetapa`, `equipamento_idequipamento`, `protocolo_idprotocolo`, `local_idlocal`, `prioridade_idprioridade`),
  UNIQUE INDEX `idetapa_UNIQUE` (`idetapa` ASC),
  INDEX `fk_etapa_equipamento1_idx` (`equipamento_idequipamento` ASC),
  INDEX `fk_etapa_protocolo1_idx` (`protocolo_idprotocolo` ASC),
  INDEX `fk_etapa_local1_idx` (`local_idlocal` ASC),
  INDEX `fk_etapa_prioridade1_idx` (`prioridade_idprioridade` ASC),
  CONSTRAINT `fk_etapa_equipamento1`
    FOREIGN KEY (`equipamento_idequipamento`)
    REFERENCES `itapoaap_sspmi`.`equipamento` (`idequipamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_etapa_protocolo1`
    FOREIGN KEY (`protocolo_idprotocolo`)
    REFERENCES `itapoaap_sspmi`.`protocolo` (`idprotocolo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_etapa_local1`
    FOREIGN KEY (`local_idlocal`)
    REFERENCES `itapoaap_sspmi`.`local` (`idlocal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_etapa_prioridade1`
    FOREIGN KEY (`prioridade_idprioridade`)
    REFERENCES `itapoaap_sspmi`.`prioridade` (`idprioridade`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `itapoaap_sspmi`.`solicitacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `itapoaap_sspmi`.`solicitacao` (
  `idsolicitacao` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `sobrenome` VARCHAR(100) NOT NULL,
  `sexo` CHAR(1) NOT NULL,
  `telefone` VARCHAR(11) NULL,
  `whatsApp` TINYINT NULL,
  `email` VARCHAR(100) NOT NULL,
  `secretaria_idsecretaria` INT NOT NULL,
  `departamento_iddepartamento` INT NULL,
  `coordenacao_idcoordenacao` INT NULL,
  `setor_idsetor` INT NULL,
  `cargo_idcargo` INT NOT NULL,
  `situacao` TINYINT NULL,
  `examinador` INT NULL,
  `dataHoraSolicitacao` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `dataHoraExaminador` TIMESTAMP NULL,
  PRIMARY KEY (`idsolicitacao`),
  UNIQUE INDEX `idsolicitacao_UNIQUE` (`idsolicitacao` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
