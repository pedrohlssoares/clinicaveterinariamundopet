-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mundopet
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mundopet
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mundopet` DEFAULT CHARACTER SET utf8 ;
USE `mundopet` ;

-- -----------------------------------------------------
-- Table `mundopet`.`endereco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundopet`.`endereco` (
  `idendereco` INT NOT NULL AUTO_INCREMENT,
  `rua` VARCHAR(90) NOT NULL,
  `cidade` VARCHAR(45) NOT NULL,
  `bairro` VARCHAR(45) NOT NULL,
  `numero` VARCHAR(45) NOT NULL,
  `complemento` VARCHAR(45) NULL,
  PRIMARY KEY (`idendereco`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundopet`.`cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundopet`.`cliente` (
  `idcliente` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(90) NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  `email` VARCHAR(60) NOT NULL,
  `celular` VARCHAR(11) NOT NULL,
  `enderecoclientefk` INT NOT NULL,
  PRIMARY KEY (`idcliente`),
  INDEX `fk_clientes_endereco_idx` (`enderecoclientefk` ASC) VISIBLE,
  CONSTRAINT `fk_clientes_endereco`
    FOREIGN KEY (`enderecoclientefk`)
    REFERENCES `mundopet`.`endereco` (`idendereco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundopet`.`funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundopet`.`funcionario` (
  `idfuncionario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(90) NOT NULL,
  `celular` VARCHAR(11) NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  `salario` DECIMAL(6,2) NOT NULL,
  `enderecofuncionariofk` INT NOT NULL,
  PRIMARY KEY (`idfuncionario`),
  INDEX `fk_funcionario_endereco1_idx` (`enderecofuncionariofk` ASC) VISIBLE,
  CONSTRAINT `fk_funcionario_endereco1`
    FOREIGN KEY (`enderecofuncionariofk`)
    REFERENCES `mundopet`.`endereco` (`idendereco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundopet`.`veterinario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundopet`.`veterinario` (
  `idveterinario` INT NOT NULL AUTO_INCREMENT,
  `crmv` VARCHAR(11) NOT NULL,
  `funcionarioveterinariofk` INT NOT NULL,
  `descricao` VARCHAR(120) NULL,
  PRIMARY KEY (`idveterinario`),
  INDEX `fk_veterinario_funcionario1_idx` (`funcionarioveterinariofk` ASC) VISIBLE,
  CONSTRAINT `fk_veterinario_funcionario1`
    FOREIGN KEY (`funcionarioveterinariofk`)
    REFERENCES `mundopet`.`funcionario` (`idfuncionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundopet`.`pet`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundopet`.`pet` (
  `idpet` INT NOT NULL AUTO_INCREMENT,
  `petcolnome` VARCHAR(45) NOT NULL,
  `especie` VARCHAR(45) NOT NULL,
  `raca` VARCHAR(45) NOT NULL,
  `idade` VARCHAR(45) NOT NULL,
  `clientepetfk` INT NOT NULL,
  PRIMARY KEY (`idpet`),
  INDEX `fk_pet_clientes1_idx` (`clientepetfk` ASC) VISIBLE,
  CONSTRAINT `fk_pet_clientes1`
    FOREIGN KEY (`clientepetfk`)
    REFERENCES `mundopet`.`cliente` (`idcliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundopet`.`historico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundopet`.`historico` (
  `idhistorico` INT NOT NULL AUTO_INCREMENT,
  `consultas` VARCHAR(45) NOT NULL,
  `tratamentos` VARCHAR(45) NOT NULL,
  `pethistoricofk` INT NOT NULL,
  PRIMARY KEY (`idhistorico`),
  INDEX `fk_historico_pet1_idx` (`pethistoricofk` ASC) VISIBLE,
  CONSTRAINT `fk_historico_pet1`
    FOREIGN KEY (`pethistoricofk`)
    REFERENCES `mundopet`.`pet` (`idpet`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundopet`.`sala`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundopet`.`sala` (
  `numero` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`numero`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundopet`.`consulta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundopet`.`consulta` (
  `idconsulta` INT NOT NULL AUTO_INCREMENT,
  `petconsultafk` INT NOT NULL,
  `veterinarioconsultafk` INT NOT NULL,
  `salaconsultafk` INT NOT NULL,
  `data` DATE NOT NULL,
  PRIMARY KEY (`idconsulta`),
  INDEX `fk_consulta_pet1_idx` (`petconsultafk` ASC) VISIBLE,
  INDEX `fk_consulta_veterinario1_idx` (`veterinarioconsultafk` ASC) VISIBLE,
  INDEX `fk_consulta_sala1_idx` (`salaconsultafk` ASC) VISIBLE,
  CONSTRAINT `fk_consulta_pet1`
    FOREIGN KEY (`petconsultafk`)
    REFERENCES `mundopet`.`pet` (`idpet`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_consulta_veterinario1`
    FOREIGN KEY (`veterinarioconsultafk`)
    REFERENCES `mundopet`.`veterinario` (`idveterinario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_consulta_sala1`
    FOREIGN KEY (`salaconsultafk`)
    REFERENCES `mundopet`.`sala` (`numero`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundopet`.`produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundopet`.`produto` (
  `idproduto` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `quantidade` INT(3) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `preco` DECIMAL(6,2) NOT NULL,
  PRIMARY KEY (`idproduto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundopet`.`remedio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundopet`.`remedio` (
  `idremedio` INT NOT NULL AUTO_INCREMENT,
  `produtoremediofk` INT NOT NULL,
  `ativo` VARCHAR(40) NOT NULL,
  `lote` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idremedio`),
  INDEX `fk_remedio_produtos1_idx` (`produtoremediofk` ASC) VISIBLE,
  CONSTRAINT `fk_remedio_produtos1`
    FOREIGN KEY (`produtoremediofk`)
    REFERENCES `mundopet`.`produto` (`idproduto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundopet`.`prescricao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundopet`.`prescricao` (
  `idprescricao` INT NOT NULL AUTO_INCREMENT,
  `consultaprescricaofk` INT NOT NULL,
  `remedioprescricaofk` INT NOT NULL,
  PRIMARY KEY (`idprescricao`),
  INDEX `fk_prescricao_consulta1_idx` (`consultaprescricaofk` ASC) VISIBLE,
  INDEX `fk_prescricao_remedio1_idx` (`remedioprescricaofk` ASC) VISIBLE,
  CONSTRAINT `fk_prescricao_consulta1`
    FOREIGN KEY (`consultaprescricaofk`)
    REFERENCES `mundopet`.`consulta` (`idconsulta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_prescricao_remedio1`
    FOREIGN KEY (`remedioprescricaofk`)
    REFERENCES `mundopet`.`remedio` (`idremedio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundopet`.`forma_pagamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundopet`.`forma_pagamento` (
  `idforma_pagamento` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  PRIMARY KEY (`idforma_pagamento`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundopet`.`pagamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundopet`.`pagamento` (
  `idpagamento` INT NOT NULL AUTO_INCREMENT,
  `pretacoes` INT(2) NOT NULL,
  `valor` DECIMAL(6,2) NOT NULL,
  `formapagamentofk` INT NOT NULL,
  PRIMARY KEY (`idpagamento`),
  INDEX `fk_pagamento_forma_pagamento1_idx` (`formapagamentofk` ASC) VISIBLE,
  CONSTRAINT `fk_pagamento_forma_pagamento1`
    FOREIGN KEY (`formapagamentofk`)
    REFERENCES `mundopet`.`forma_pagamento` (`idforma_pagamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundopet`.`venda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundopet`.`venda` (
  `idvenda` INT NOT NULL AUTO_INCREMENT,
  `pagamentovendafk` INT NOT NULL,
  `produtovendafk` INT NOT NULL,
  PRIMARY KEY (`idvenda`),
  INDEX `fk_venda_pagamento1_idx` (`pagamentovendafk` ASC) VISIBLE,
  INDEX `fk_venda_produtos1_idx` (`produtovendafk` ASC) VISIBLE,
  CONSTRAINT `fk_venda_pagamento1`
    FOREIGN KEY (`pagamentovendafk`)
    REFERENCES `mundopet`.`pagamento` (`idpagamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_venda_produtos1`
    FOREIGN KEY (`produtovendafk`)
    REFERENCES `mundopet`.`produto` (`idproduto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundopet`.`consulta_pagamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundopet`.`consulta_pagamento` (
  `idconsulta_pagamento` INT NOT NULL AUTO_INCREMENT,
  `pagamento_idpagamento` INT NOT NULL,
  `consulta_idconsulta` INT NOT NULL,
  PRIMARY KEY (`idconsulta_pagamento`),
  INDEX `fk_consulta_pagamento_pagamento1_idx` (`pagamento_idpagamento` ASC) VISIBLE,
  INDEX `fk_consulta_pagamento_consulta1_idx` (`consulta_idconsulta` ASC) VISIBLE,
  CONSTRAINT `fk_consulta_pagamento_pagamento1`
    FOREIGN KEY (`pagamento_idpagamento`)
    REFERENCES `mundopet`.`pagamento` (`idpagamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_consulta_pagamento_consulta1`
    FOREIGN KEY (`consulta_idconsulta`)
    REFERENCES `mundopet`.`consulta` (`idconsulta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundopet`.`prescricaoprescricaopagamentofk`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundopet`.`prescricaoprescricaopagamentofk` (
  `idprescricao_pagamento` INT NOT NULL AUTO_INCREMENT,
  `prescricaoprescricaopagamentofk` INT NOT NULL,
  `pagamentoprescricaopagamentofk` INT NOT NULL,
  PRIMARY KEY (`idprescricao_pagamento`),
  INDEX `fk_prescricao_pagamento_prescricao1_idx` (`prescricaoprescricaopagamentofk` ASC) VISIBLE,
  INDEX `fk_prescricao_pagamento_pagamento1_idx` (`pagamentoprescricaopagamentofk` ASC) VISIBLE,
  CONSTRAINT `fk_prescricao_pagamento_prescricao1`
    FOREIGN KEY (`prescricaoprescricaopagamentofk`)
    REFERENCES `mundopet`.`prescricao` (`idprescricao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_prescricao_pagamento_pagamento1`
    FOREIGN KEY (`pagamentoprescricaopagamentofk`)
    REFERENCES `mundopet`.`pagamento` (`idpagamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundopet`.`vacina`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundopet`.`vacina` (
  `idvacina` INT NOT NULL AUTO_INCREMENT,
  `produtovacinafk` INT NOT NULL,
  `ativo` VARCHAR(45) NOT NULL,
  `lote` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`idvacina`),
  INDEX `fk_vacinas_produtos1_idx` (`produtovacinafk` ASC) VISIBLE,
  CONSTRAINT `fk_vacinas_produtos1`
    FOREIGN KEY (`produtovacinafk`)
    REFERENCES `mundopet`.`produto` (`idproduto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
