SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `mundopet` DEFAULT CHARACTER SET utf8 ;
USE `mundopet` ;

CREATE TABLE IF NOT EXISTS `mundopet`.`endereco` (
  `idendereco` INT NOT NULL AUTO_INCREMENT,
  `rua` VARCHAR(90) NOT NULL,
  `cidade` VARCHAR(45) NOT NULL,
  `bairro` VARCHAR(45) NOT NULL,
  `numero` VARCHAR(45) NOT NULL,
  `complemento` VARCHAR(45) NULL,
  PRIMARY KEY (`idendereco`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `mundopet`.`cliente` (
  `idcliente` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(90) NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  `email` VARCHAR(60) NOT NULL,
  `celular` VARCHAR(11) NOT NULL,
  `enderecoclientefk` INT NOT NULL,
  PRIMARY KEY (`idcliente`),
  INDEX `fk_clientes_endereco_idx` (`enderecoclientefk` ASC),
  CONSTRAINT `fk_clientes_endereco`
    FOREIGN KEY (`enderecoclientefk`) REFERENCES `mundopet`.`endereco` (`idendereco`)
    ON DELETE NO ACTION ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `mundopet`.`funcionario` (
  `idfuncionario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(90) NOT NULL,
  `celular` VARCHAR(11) NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  `salario` DECIMAL(8,2) NOT NULL,
  `enderecofuncionariofk` INT NOT NULL,
  PRIMARY KEY (`idfuncionario`),
  INDEX `fk_funcionario_endereco1_idx` (`enderecofuncionariofk` ASC),
  CONSTRAINT `fk_funcionario_endereco1`
    FOREIGN KEY (`enderecofuncionariofk`) REFERENCES `mundopet`.`endereco` (`idendereco`)
    ON DELETE NO ACTION ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `mundopet`.`veterinario` (
  `idveterinario` INT NOT NULL AUTO_INCREMENT,
  `crmv` VARCHAR(11) NOT NULL,
  `funcionarioveterinariofk` INT NOT NULL,
  `descricao` VARCHAR(400) NULL,
  PRIMARY KEY (`idveterinario`),
  INDEX `fk_veterinario_funcionario1_idx` (`funcionarioveterinariofk` ASC),
  CONSTRAINT `fk_veterinario_funcionario1`
    FOREIGN KEY (`funcionarioveterinariofk`) REFERENCES `mundopet`.`funcionario` (`idfuncionario`)
    ON DELETE NO ACTION ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `mundopet`.`pet` (
  `idpet` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `especie` VARCHAR(45) NOT NULL,
  `raca` VARCHAR(45) NOT NULL,
  `idade` VARCHAR(45) NOT NULL,
  `clientepetfk` INT NOT NULL,
  PRIMARY KEY (`idpet`),
  INDEX `fk_pet_clientes1_idx` (`clientepetfk` ASC),
  CONSTRAINT `fk_pet_clientes1`
    FOREIGN KEY (`clientepetfk`) REFERENCES `mundopet`.`cliente` (`idcliente`)
    ON DELETE NO ACTION ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `mundopet`.`produto` (
  `idproduto` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `quantidade` INT NOT NULL,
  `descricao` VARCHAR(400) NOT NULL,
  `preco` DECIMAL(8,2) NOT NULL,
  PRIMARY KEY (`idproduto`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `mundopet`.`vacina` (
  `idvacina` INT NOT NULL AUTO_INCREMENT,
  `produtovacinafk` INT NOT NULL,
  `ativo` VARCHAR(45) NOT NULL,
  `lote` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`idvacina`),
  INDEX `fk_vacinas_produtos1_idx` (`produtovacinafk` ASC),
  CONSTRAINT `fk_vacinas_produtos1`
    FOREIGN KEY (`produtovacinafk`) REFERENCES `mundopet`.`produto` (`idproduto`)
    ON DELETE NO ACTION ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `mundopet`.`historico_vacinacao` (
  `idhistorico` INT NOT NULL AUTO_INCREMENT,
  `pethistorico_vacinacaofk` INT NOT NULL,
  `vacinahistorico_vacinacaofk` INT NOT NULL,
  `data_aplicacao` DATE NOT NULL,
  `dosagem` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idhistorico`),
  INDEX `fk_historico_pet1_idx` (`pethistorico_vacinacaofk` ASC),
  INDEX `fk_historico_vacinacao_vacina1_idx` (`vacinahistorico_vacinacaofk` ASC),
  CONSTRAINT `fk_historico_pet1`
    FOREIGN KEY (`pethistorico_vacinacaofk`) REFERENCES `mundopet`.`pet` (`idpet`)
    ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_historico_vacinacao_vacina1`
    FOREIGN KEY (`vacinahistorico_vacinacaofk`) REFERENCES `mundopet`.`vacina` (`idvacina`)
    ON DELETE NO ACTION ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `mundopet`.`sala` (
  `numero` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(400) NOT NULL,
  PRIMARY KEY (`numero`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `mundopet`.`remedio` (
  `idremedio` INT NOT NULL AUTO_INCREMENT,
  `produtoremediofk` INT NOT NULL,
  `ativo` VARCHAR(40) NOT NULL,
  `lote` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idremedio`),
  INDEX `fk_remedio_produtos1_idx` (`produtoremediofk` ASC),
  CONSTRAINT `fk_remedio_produtos1`
    FOREIGN KEY (`produtoremediofk`) REFERENCES `mundopet`.`produto` (`idproduto`)
    ON DELETE NO ACTION ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `mundopet`.`forma_pagamento` (
  `idforma_pagamento` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`idforma_pagamento`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `mundopet`.`pagamento` (
  `idpagamento` INT NOT NULL AUTO_INCREMENT,
  `prestacoes` INT NOT NULL,
  `valor` DECIMAL(8,2) NOT NULL,
  `data_pagamento` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `formapagamentofk` INT NOT NULL,
  `clientepagamentofk` INT NOT NULL,
  PRIMARY KEY (`idpagamento`),
  INDEX `fk_pagamento_forma_pagamento1_idx` (`formapagamentofk` ASC),
  INDEX `fk_pagamento_cliente1_idx` (`clientepagamentofk` ASC),
  CONSTRAINT `fk_pagamento_forma_pagamento1`
    FOREIGN KEY (`formapagamentofk`) REFERENCES `mundopet`.`forma_pagamento` (`idforma_pagamento`)
    ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pagamento_cliente1`
    FOREIGN KEY (`clientepagamentofk`) REFERENCES `mundopet`.`cliente` (`idcliente`)
    ON DELETE NO ACTION ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `mundopet`.`consulta` (
  `idconsulta` INT NOT NULL AUTO_INCREMENT,
  `petconsultafk` INT NOT NULL,
  `veterinarioconsultafk` INT NOT NULL,
  `salaconsultafk` INT NOT NULL,
  `pagamentoconsultafk` INT NULL, 
  `data_consulta` DATE NOT NULL,
  `horario` TIME NOT NULL, 
  `status` VARCHAR(45) NOT NULL DEFAULT 'Agendada',
  `processos_feitos` VARCHAR(400) NOT NULL,
  PRIMARY KEY (`idconsulta`),
  INDEX `fk_consulta_veterinario1_idx` (`veterinarioconsultafk` ASC),
  INDEX `fk_consulta_sala1_idx` (`salaconsultafk` ASC),
  INDEX `fk_consulta_pagamento1_idx` (`pagamentoconsultafk` ASC),
  CONSTRAINT `fk_consulta_pet1`
    FOREIGN KEY (`petconsultafk`) REFERENCES `mundopet`.`pet` (`idpet`)
    ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_consulta_veterinario1`
    FOREIGN KEY (`veterinarioconsultafk`) REFERENCES `mundopet`.`veterinario` (`idveterinario`)
    ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_consulta_sala1`
    FOREIGN KEY (`salaconsultafk`) REFERENCES `mundopet`.`sala` (`numero`)
    ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_consulta_pagamento1`
    FOREIGN KEY (`pagamentoconsultafk`) REFERENCES `mundopet`.`pagamento` (`idpagamento`)
    ON DELETE NO ACTION ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `mundopet`.`prescricao` (
  `idprescricao` INT NOT NULL AUTO_INCREMENT,
  `consultaprescricaofk` INT NOT NULL,
  `remedioprescricaofk` INT NOT NULL,
  `pagamentoprescricaofk` INT NULL,
  `dosagem` VARCHAR(400) NOT NULL,
  PRIMARY KEY (`idprescricao`),
  INDEX `fk_prescricao_consulta1_idx` (`consultaprescricaofk` ASC),
  INDEX `fk_prescricao_remedio1_idx` (`remedioprescricaofk` ASC),
  INDEX `fk_prescricao_pagamento1_idx` (`pagamentoprescricaofk` ASC),
  CONSTRAINT `fk_prescricao_consulta1`
    FOREIGN KEY (`consultaprescricaofk`) REFERENCES `mundopet`.`consulta` (`idconsulta`)
    ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_prescricao_remedio1`
    FOREIGN KEY (`remedioprescricaofk`) REFERENCES `mundopet`.`remedio` (`idremedio`)
    ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_prescricao_pagamento1`
    FOREIGN KEY (`pagamentoprescricaofk`) REFERENCES `mundopet`.`pagamento` (`idpagamento`)
    ON DELETE NO ACTION ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `mundopet`.`venda` (
  `idvenda` INT NOT NULL AUTO_INCREMENT,
  `pagamentovendafk` INT NOT NULL,
  `produtovendafk` INT NOT NULL,
  `quantidade` INT NOT NULL,
  `valor_unitario` DECIMAL(8,2) NOT NULL,
  PRIMARY KEY (`idvenda`),
  INDEX `fk_venda_pagamento1_idx` (`pagamentovendafk` ASC),
  INDEX `fk_venda_produtos1_idx` (`produtovendafk` ASC),
  CONSTRAINT `fk_venda_pagamento1`
    FOREIGN KEY (`pagamentovendafk`) REFERENCES `mundopet`.`pagamento` (`idpagamento`)
    ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_venda_produtos1`
    FOREIGN KEY (`produtovendafk`) REFERENCES `mundopet`.`produto` (`idproduto`)
    ON DELETE NO ACTION ON UPDATE NO ACTION)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;