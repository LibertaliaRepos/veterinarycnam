SELECT * FROM member;

UPDATE member SET status = 0 WHERE id = 1;

SELECT * FROM details WHERE id = 1;

SHOW DATABASES;

SHOW TABLES FROM VETERINARY_2;

SELECT * FROM `schedules-v2.0`;

SELECT * FROM employees;

SELECT * FROM `member`;

SELECT * FROM details;

SELECT * FROM request;

SELECT * FROM answer;

SELECT COUNT(*) FROM request WHERE status = 1 OR status = 2;

-- SELECT COUNT(*) FROM `member` WHERE `email` = `gillesgandner@gmail.com`;
