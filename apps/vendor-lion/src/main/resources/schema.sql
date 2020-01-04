CREATE TABLE `currency` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `code_UNIQUE` (`code` ASC) VISIBLE);

CREATE TABLE `card` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `balance` INT NOT NULL,
  `currency_id` INT NOT NULL,
  `activation_date` DATE NOT NULL,
  `expire_date` DATE NOT NULL,
  `reference` VARCHAR(255) NOT NULL,
  `card_number` VARCHAR(255) NOT NULL,
  `cvc` VARCHAR(255) NOT NULL,
  `active` TINYINT(1) NULL DEFAULT 1,
  `is_deleted` TINYINT(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `cardNumber_UNIQUE` (`card_number` ASC) VISIBLE,
  INDEX `currency_id_idx` (`currency_id` ASC) VISIBLE,
  INDEX `is_deleted_idx` (`is_deleted` ASC) VISIBLE,
  CONSTRAINT `currency_idx`
      FOREIGN KEY (`currency_id`)
          REFERENCES `vendor_lion`.`currency` (`id`)
          ON DELETE CASCADE
          ON UPDATE CASCADE);
