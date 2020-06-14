/*
	INSERTS DE LES TAULES PEL CREDIT DE SINTESI 2020
*/

/* INSERT ADMINISTRADORS Marc i Gorka */
INSERT INTO USUARIO (email, password, es_admin, activado) VALUES ('9b114f70047f2c56e828459c1c3961e14cba22da','9725cf25f6f8f353c773d54141a11f48f3f5934b', true, true);
INSERT INTO USUARIO (email, password, es_admin, activado) VALUES ('41a18d197b32f94b56bdbae9f58e7a05834f00fc','3bb04be0bb2073855d220ed98955942e36a2e1cb', true, true);
INSERT INTO USUARIO (email, password, es_admin, activado) VALUES ('ad8f4ea303748f83d319504b6c31ec5dbc32f6a9','e2be40f160248c95f001179ab2b5aaef6ca1c10e', false, true);
INSERT INTO USUARIO (email, password, es_admin, activado) VALUES ('07d7b0aa38981f0fc6bd957d6a0f571c5c66b285','d33c80bc45d65303e33ca83108a9952b745af9ef', false, true);
INSERT INTO USUARIO (email, password, es_admin, activado) VALUES ('874e0bb7252878a7342570d99535c227c592e710','711383a59fda05336fd2ccf70c8059d1523eb41a', false, true);


/* Sempre han de donar 100% */ 
INSERT INTO SINTOMA (nombre, porcentaje) VALUES ('Fiebre',20);
INSERT INTO SINTOMA (nombre, porcentaje) VALUES ('Tos seca',30);
INSERT INTO SINTOMA (nombre, porcentaje) VALUES ('Vomitos',20);
INSERT INTO SINTOMA (nombre, porcentaje) VALUES ('Dolor de cabeza',20);
INSERT INTO SINTOMA (nombre, porcentaje) VALUES ('Cansamiento',10);

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

/* RESPUESTA HABITOS USUARIO */
INSERT INTO RESPUESTA_HABITO_USUARIO (id_habito, id_usuario, id_respuesta) VALUES(1,3,1);
INSERT INTO RESPUESTA_HABITO_USUARIO (id_habito, id_usuario, id_respuesta) VALUES(2,3,4);
INSERT INTO RESPUESTA_HABITO_USUARIO (id_habito, id_usuario, id_respuesta) VALUES(3,3,7);

INSERT INTO RESPUESTA_HABITO_USUARIO (id_habito, id_usuario, id_respuesta) VALUES(1,4,1);
INSERT INTO RESPUESTA_HABITO_USUARIO (id_habito, id_usuario, id_respuesta) VALUES(2,4,4);
INSERT INTO RESPUESTA_HABITO_USUARIO (id_habito, id_usuario, id_respuesta) VALUES(3,4,7);

INSERT INTO RESPUESTA_HABITO_USUARIO (id_habito, id_usuario, id_respuesta) VALUES(1,5,1);
INSERT INTO RESPUESTA_HABITO_USUARIO (id_habito, id_usuario, id_respuesta) VALUES(2,5,4);
INSERT INTO RESPUESTA_HABITO_USUARIO (id_habito, id_usuario, id_respuesta) VALUES(3,5,7);

/* INTERVALO SINTOMAS */

INSERT INTO INTERVALO_SINTOMA (fecha_inicio, fecha_fin, id_usuario, id_sintoma) VALUES('2020-05-12','2020-05-20',3,1);
INSERT INTO INTERVALO_SINTOMA (fecha_inicio, fecha_fin, id_usuario, id_sintoma) VALUES('2020-05-12','2020-05-20',3,3);
INSERT INTO INTERVALO_SINTOMA (fecha_inicio, fecha_fin, id_usuario, id_sintoma) VALUES('2020-05-22','2020-06-01',3,4);
