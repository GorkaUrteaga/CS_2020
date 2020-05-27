/*
	INSERTS DE LES TAULES PEL CREDIT DE SINTESI 2020
*/

/* INSERT ADMINISTRADORS Marc i Gorka */
INSERT INTO USUARIO (email, password, es_admin, activado) VALUES ('03acdad1148f03a359b52d96e5255932','983a21a1216c2f1e25479180031f58bb', true, true);
INSERT INTO USUARIO (email, password, es_admin, activado) VALUES ('d09663e78d67c9e8291134cde7ab014a','dc6ae7fd83dab1a4a706311971b6f2aa', true, true);

/* Sempre han de donar 100% */ 
INSERT INTO SINTOMA (nombre, porcentaje) VALUES ('Fiebre',40);
INSERT INTO SINTOMA (nombre, porcentaje) VALUES ('Tos seca',50);
INSERT INTO SINTOMA (nombre, porcentaje) VALUES ('Dolor de cabeza',10);