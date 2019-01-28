SHOW DATABASES;

USE VETERINARY_2;

/**
 * Création de la table member
 */
CREATE TABLE IF NOT EXISTS `member`(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	label VARCHAR(4) NOT NULL,
	firstname VARCHAR(40) NOT NULL,
	name VARCHAR(50) NOT NULL,
	email VARCHAR(100) NOT NULL,
	password VARCHAR(20) NOT NULL,
	sign_up_date INT NOT NULL,
	status INT(1),
	phone VARCHAR(14)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

/**
 * Création de l'index unique sur la conlone des emails.
 * nom de l'index unique:
 * UK_email_member
 */
CREATE UNIQUE INDEX UK_email_member ON `member`(email);

/**
 * Création d'un index sur les colonnes email et member.
 * nom de l'index:
 * IX_email_password_member
 */
CREATE INDEX IX_email_password_member ON `member`(email, `password`);

DESCRIBE `member`;