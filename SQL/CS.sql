/*
	CREACIÓ DE LES TAULES PEL CREDIT DE SINTESI 2020
*/

-- DELETE FROM USUARI;

DROP TABLE IF EXISTS USUARIO;
DROP TABLE IF EXISTS ATRIBUTOS_PERFIL;
DROP TABLE IF EXISTS CALENDARIO_SINTOMAS;

CREATE TABLE USUARIO
(
	id BIGINT UNSIGNED primary key AUTO_INCREMENT,
	email VARCHAR(200) not null unique, /* HASH */
	password VARCHAR(200) not null, /* HASH */
	mac_bluetooth VARCHAR(200), /* HASH */
	es_admin BOOLEAN not null,
	activado BOOLEAN not null
);

INSERT INTO USUARIO VALUES ('$2y$10$HLOVbQFwKfjuUk58obER6.b0jBNV90qdNr2miWIW9tFuqzmfTfana','$2y$10$59vKqn565aocUETGk/zEue/ktUo2gC9gFZhw9SIdem.dSYfB1Zy8u',null,true,true);
INSERT INTO USUARIO VALUES ('$2y$10$YHjwkpJ1pga6ziYnxQhONu7TUhDOmJuJ6Z6rMEh7IxHKHS//h4ozO','$2y$10$OWhKHcg536Fs35T3qAa7OeonoMlOF4oqf4IO1vPpAwBnAnTP4qho2',null,true,true);


CREATE TABLE CALENDARIO_SINTOMAS
(
	id BIGINT UNSIGNED primary key AUTO_INCREMENT,
	fecha date

);