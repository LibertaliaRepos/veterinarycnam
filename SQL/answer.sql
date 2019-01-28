SHOW DATABASES;

USE VETERINARY_2;

/**
 * Création de la table answer
 * dans laquelle se trouve les rendez-vous envoyer par 
 * la clinique.
 */

CREATE TABLE IF NOT EXISTS answer(
	id_answer INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	id_req INT UNSIGNED NOT NULL,
	id_doc INT UNSIGNED NOT NULL,
	id_user INT UNSIGNED NOT NULL,
	appointment_date INT UNSIGNED NOT NULL,
	vet_comment TEXT,
	pdf VARCHAR(40)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

DESCRIBE answer;

/**
 * Création des indexes.
 */
ALTER TABLE answer ADD CONSTRAINT fk_employees_id FOREIGN KEY (id_doc) REFERENCES employees(id);
ALTER TABLE answer ADD CONSTRAINT fk_request_id_req FOREIGN KEY (id_req) REFERENCES request(id_req);
ALTER TABLE answer ADD CONSTRAINT fk_member_id_user FOREIGN KEY (id_user) REFERENCES `member`(id);
