SHOW DATABASES;

USE VETERINARY_2;

/**
 * Création de la table schedules
 * dans laquelle se trouve les horaires d'ouvertures de la clinique
 * par tranche horaire.
 */
CREATE TABLE IF NOT EXISTS `schedules-v2.0`(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	schedule_group VARCHAR(100) NOT NULL,
	Lundi BOOLEAN NOT NULL,
	Mardi BOOLEAN NOT NULL,
	Mercredi BOOLEAN NOT NULL,
	Jeudi BOOLEAN NOT NULL,
	Vendredi BOOLEAN NOT NULL,
	Samedi BOOLEAN NOT NULL,
	Dimanche BOOLEAN NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

/**
 * Création d'un INDEX UNIQUE
 * De façon à se qu'il n'y ai pas de tranche horaires 
 * sur plusieurs jours.
 */
ALTER TABLE `schedules-v2.0` ADD UNIQUE UK_schedules_all (schedule_group, Lundi, Mardi, Mercredi, Jeudi, Vendredi, Samedi, Dimanche);


/**
 * Vidage de la table.
 */
TRUNCATE TABLE `schedules-v2.0`;

/**
 * Description de la table.
 */
DESCRIBE `schedules-v2.0`;


