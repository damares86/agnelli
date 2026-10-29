-- ############ Estensione Timbrature - struttura DB ############
-- Se usi il prefisso (core/prefix.php) aggiungi il prefisso ai nomi tabella: es. xxx_employee

CREATE TABLE IF NOT EXISTS `employee` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(190) NOT NULL,
  `badge` VARCHAR(50) DEFAULT NULL COMMENT 'User ID del lettore badge',
  `h_mon` DECIMAL(4,2) NOT NULL DEFAULT 8.00,
  `h_tue` DECIMAL(4,2) NOT NULL DEFAULT 8.00,
  `h_wed` DECIMAL(4,2) NOT NULL DEFAULT 8.00,
  `h_thu` DECIMAL(4,2) NOT NULL DEFAULT 8.00,
  `h_fri` DECIMAL(4,2) NOT NULL DEFAULT 8.00,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  `notes` TEXT,
  PRIMARY KEY (`id`),
  KEY `idx_employee_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `punch` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `employee_id` INT(11) NOT NULL,
  `punch_date` DATE NOT NULL,
  `punch_time` TIME NOT NULL,
  `source` VARCHAR(190) DEFAULT NULL COMMENT 'nome file importato',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_punch` (`employee_id`,`punch_date`,`punch_time`),
  KEY `idx_punch_date` (`punch_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Voci di menu (adatta i valori alla tua tabella section)
-- INSERT INTO section (label, link, icon, parent) VALUES
--  ('Dipendenti','allEmployees','users',0),
--  ('Timbrature','importTimbrature','clock',0);
