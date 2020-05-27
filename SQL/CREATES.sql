/*
	CREACIÓ DE LES TAULES PEL CREDIT DE SINTESI 2020
*/
/* PORCENTAGE QUE TIENE EL USUARIO DE TENER LA ENFERMEDAD*/
CREATE TABLE USUARIO
(
	id BIGINT UNSIGNED primary key AUTO_INCREMENT,
	email VARCHAR(200) not null unique, /* HASH */
	password VARCHAR(200) not null, /* HASH */
	mac_bluetooth VARCHAR(200), /* HASH */
	es_admin BOOLEAN not null DEFAULT false,
	perfil_completado BOOLEAN not null DEFAULT false, /* Boolea per indicar si l'usuari ja ha omplert el seu perfil */
	activado BOOLEAN not null DEFAULT false,
	riesgo INT 
);

/* HABITOS DEL USUARIO */
/* UN HABIT POT SUMAR O RESTAR DEL RISC DE L'USUARI DE TENIR EL VIRUS */
CREATE TABLE HABITO
(
	id BIGINT UNSIGNED primary key AUTO_INCREMENT,
	nombre VARCHAR(200) not null unique,
	porcentaje INT not null 
);

CREATE TABLE RESPUESTA_HABITO
(
	id BIGINT UNSIGNED primary key AUTO_INCREMENT,
	id_habito BIGINT UNSIGNED,
	respuesta VARCHAR(200) not null unique,
	porcentaje INT not null,
	FOREIGN KEY (id_habito) REFERENCES HABITO(id)
);


/* 
	TAULA QUE RELACIONA L'USUARI AMB L'HABIT I INDICA LA RESPOSTA QUE DONA Si, no o a vegades
*/
/* 1 - Si suma el porcentatge | 2 - No | 3 - De vez en cuando suma la meitat */
CREATE TABLE RESPUESTA_HABITO_USUARIO
(
	id BIGINT UNSIGNED primary key AUTO_INCREMENT,
	id_usuario BIGINT UNSIGNED,
	id_respuesta BIGINT UNSIGNED, 
	FOREIGN KEY (id_respuesta) REFERENCES RESPUESTA_HABITO(id),
	FOREIGN KEY (id_usuario) REFERENCES USUARIO(id)
);

 /* UN SINTOMA INCREMENTA EL RISC DE L'USUARI FINS A UN X En total entre tots han de tonar un 100% */

CREATE TABLE SINTOMA
(
	id BIGINT UNSIGNED primary key AUTO_INCREMENT,
	nombre VARCHAR(200) not null unique,
	porcentaje INT not null
);

CREATE TABLE INTERVALO_SINTOMA
(
	id BIGINT UNSIGNED primary key AUTO_INCREMENT,
	fecha_inicio date not null,
	fecha_fin date,
	id_usuario BIGINT UNSIGNED,
	id_sintoma BIGINT UNSIGNED,
	FOREIGN KEY (id_usuario) REFERENCES USUARIO(id),
	FOREIGN KEY (id_sintoma) REFERENCES SINTOMA(id),
	respuesta_sintoma BOOLEAN
);

