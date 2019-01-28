/**
 * @warning deprecated
 */

/**
 * Création de la table schedules-V1.0
 * dans laquelle se trouve les horaires d'ouvertures de la clinique
 */
CREATE TABLE `schedules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `day` varchar(8) NOT NULL,
  `schedule` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `day_unique` (`day`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/**
 * Initialisation de schedules-V1.0
 */

INSERT INTO `schedules` VALUES (1,'Lundi','De 8h30 à 19h30'),(2,'Mardi','De 8h30 à 19h30'),(3,'Mercredi','De 8h30 à 19h30'),(4,'Jeudi','De 8h30 à 19h30'),(5,'Vendredi','De 8h30 à 19h30'),(6,'Samedi','de 8h30 à 18h00'),(7,'Dimanche','10h00 à 12h00');

SELECT * FROM schedules;

