SHOW DATABASES;

USE VETERINARY_2;

/**
 * Création de la table HTML
 * dans laquelle se trouve les pages html brut.
 */
CREATE TABLE IF NOT EXISTS `HTML`(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	page_name VARCHAR(40) NOT NULL,
	html TEXT NOT NULL
)
ENGINE=InnODB DEFAULT CHARSET=utf8;

DESCRIBE HTML;

SELECT * FROM HTML;

