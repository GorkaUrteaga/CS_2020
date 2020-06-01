/*
	INSERTS DE LES TAULES PEL CREDIT DE SINTESI 2020
*/

/* INSERT ADMINISTRADORS Marc i Gorka */
INSERT INTO USUARIO (email, password, es_admin, activado) VALUES ('9b114f70047f2c56e828459c1c3961e14cba22da','9725cf25f6f8f353c773d54141a11f48f3f5934b', true, true);
INSERT INTO USUARIO (email, password, es_admin, activado) VALUES ('41a18d197b32f94b56bdbae9f58e7a05834f00fc','3bb04be0bb2073855d220ed98955942e36a2e1cb', true, true);

/* Sempre han de donar 100% */ 
INSERT INTO SINTOMA (nombre, porcentaje) VALUES ('Fiebre',40);
INSERT INTO SINTOMA (nombre, porcentaje) VALUES ('Tos seca',50);
INSERT INTO SINTOMA (nombre, porcentaje) VALUES ('Dolor de cabeza',10);

/* HABITOS */

INSERT INTO HABITO (nombre) VALUES('Fumas?');
INSERT INTO HABITO (nombre) VALUES('Haces deporte?');
INSERT INTO HABITO (nombre) VALUES('Tienes buena alimentacion?');

/* RESPUESTA HABITOS EL PORCENTAJE AUMENTA EL RIESGO*/

INSERT INTO RESPUESTA_HABITO (id_habito, respuesta, porcentaje) VALUES(1, 'Si', 10);
INSERT INTO RESPUESTA_HABITO (id_habito, respuesta, porcentaje) VALUES(1, 'No', -10);
INSERT INTO RESPUESTA_HABITO (id_habito, respuesta, porcentaje) VALUES(1, 'A veces', 5);

INSERT INTO RESPUESTA_HABITO (id_habito, respuesta, porcentaje) VALUES(2, 'Si', -10);
INSERT INTO RESPUESTA_HABITO (id_habito, respuesta, porcentaje) VALUES(2, 'No', 5);
INSERT INTO RESPUESTA_HABITO (id_habito, respuesta, porcentaje) VALUES(2, 'A veces', 0);

INSERT INTO RESPUESTA_HABITO (id_habito, respuesta, porcentaje) VALUES(3, 'Si', -15);
INSERT INTO RESPUESTA_HABITO (id_habito, respuesta, porcentaje) VALUES(3, 'No', 5);
INSERT INTO RESPUESTA_HABITO (id_habito, respuesta, porcentaje) VALUES(3, 'A veces', -5);