SHOW DATABASES;

USE VETERINARY_2;

/**
 * Création de la table employees
 * dans laquelle se trouve les employés de la clinique avec:
 * le nom,
 * le prénom,
 * la date d'entré dans le service,
 * le poste occupé,
 * sa description,
 * sa photo.
 */
CREATE TABLE IF NOT EXISTS employees(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(40) NOT NULL,
	firstname VARCHAR(40) NOT NULL,
	hiring_date INT UNSIGNED NOT NULL,
	job VARCHAR(20) NOT NULL,
	description TEXT NOT NULL,
	photo VARCHAR(40)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;