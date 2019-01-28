SHOW DATABASES;

USE VETERINARY_2;

/**
 * Création de la table request
 * dans laquelle sera les demandes de rendez-vous.
 */
CREATE TABLE IF NOT EXISTS request(
	id_req INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	id_user	INT UNSIGNED NOT NULL,
	pet_name VARCHAR(40),
	specie VARCHAR(40) NOT NULL,
	age INT(3) UNSIGNED,
	sexe VARCHAR(1),
	comment TEXT,
	time_req INT UNSIGNED NOT NULL,
	status INT(1) NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

/**
 * Création des indexes.
 */
ALTER TABLE request ADD CONSTRAINT fk_member_id FOREIGN KEY (id_user) REFERENCES `member`(id);

DESCRIBE request;

SELECT * FROM request;

