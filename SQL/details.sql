SHOW DATABASES;

USE VETERINARY_2;

/**
 * Création de la table details
 * dans laquelle se trouve les coordonnées du cabinet:
 * adresse postal et numéros de téléphone
 */
CREATE TABLE IF NOT EXISTS details(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	street VARCHAR(200) NOT NULL,
	postal_code VARCHAR(5) NOT NULL,
	city VARCHAR(100) NOT NULL,
	phone VARCHAR(14) NOT NULL,
	fax VARCHAR(14),
	emergency VARCHAR(14) NOT NULL,
	photo_src VARCHAR(40),
	photo_alt VARCHAR(100)
)
ENGINE=innoDB CHARSET=utf8;
	
DESCRIBE details;

SELECT * FROM details;

/**
 * Initialisation de la table.
 */
INSERT INTO details
(street, postal_code, city, phone, fax, emergency)
VALUES('Chemin de la chèvre', '05400', 'VEYNES', '04 92 23 06 66', '01 23 45 67 89', '04 92 23 06 66');

ALTER TABLE details CHANGE longitude longitude FLOAT;

ALTER TABLE details CHANGE latitude latitude FLOAT;



