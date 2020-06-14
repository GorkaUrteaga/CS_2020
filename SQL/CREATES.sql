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
	codigo_recuperacion VARCHAR(5),
	riesgo FLOAT(5,2) 
);

/* HABITOS DEL USUARIO */
/* UN HABIT POT SUMAR O RESTAR DEL RISC DE L'USUARI DE TENIR EL VIRUS */
CREATE TABLE HABITO
(
	id BIGINT UNSIGNED primary key AUTO_INCREMENT,
	nombre VARCHAR(200) not null unique
);

CREATE TABLE RESPUESTA_HABITO
(
	id BIGINT UNSIGNED primary key AUTO_INCREMENT,
	id_habito BIGINT UNSIGNED,
	respuesta VARCHAR(200) not null,
	porcentaje FLOAT(5,2) not null,
	FOREIGN KEY (id_habito) REFERENCES HABITO(id)
);

/* 
	TAULA QUE RELACIONA L'USUARI AMB L'HABIT I INDICA LA RESPOSTA QUE DONA Si, no o a vegades
*/
/* 1 - Si suma el porcentatge | 2 - No | 3 - De vez en cuando suma la meitat */
CREATE TABLE RESPUESTA_HABITO_USUARIO
(
	id BIGINT UNSIGNED primary key AUTO_INCREMENT,
	id_habito BIGINT UNSIGNED,
	id_usuario BIGINT UNSIGNED,
	id_respuesta BIGINT UNSIGNED, 
	FOREIGN KEY (id_habito) REFERENCES HABITO(id),
	FOREIGN KEY (id_respuesta) REFERENCES RESPUESTA_HABITO(id),
	FOREIGN KEY (id_usuario) REFERENCES USUARIO(id)
);

 /* UN SINTOMA INCREMENTA EL RISC DE L'USUARI FINS A UN X En total entre tots han de tonar un 100% */

CREATE TABLE SINTOMA
(
	id BIGINT UNSIGNED primary key AUTO_INCREMENT,
	nombre VARCHAR(200) not null unique,
	porcentaje FLOAT(5,2) not null
);

CREATE TABLE INTERVALO_SINTOMA
(
	id BIGINT UNSIGNED primary key AUTO_INCREMENT,
	fecha_inicio date not null,
	fecha_fin date,
	id_usuario BIGINT UNSIGNED,
	id_sintoma BIGINT UNSIGNED,
	FOREIGN KEY (id_usuario) REFERENCES USUARIO(id),
	FOREIGN KEY (id_sintoma) REFERENCES SINTOMA(id)
);

/* ****************************************************** */
/* ************************ VIEWS *********************** */
/* ****************************************************** */
CREATE VIEW vw_habito_respuestas
AS
SELECT *, (select porcentaje from respuesta_habito where id_habito = h.id and respuesta = 'Si') as si
,(select porcentaje from respuesta_habito where id_habito = h.id and respuesta = 'No') as no,
(select porcentaje from respuesta_habito where id_habito = h.id and respuesta = 'A veces') as a_veces
from habito h;

CREATE VIEW vw_sintomas_diferentes
AS
select * from intervalo_sintoma
group by id_usuario,id_sintoma;

/* ****************************************************** */
/* ********************** TRIGGERS ********************** */
/* ****************************************************** */

/* ------------------------- RESPUESTAS_HABITO_USUARIO ------------------------- */

/* AFTER INSERT RESPUESTAS_HABITO_USUARIO */
DELIMITER $$
CREATE TRIGGER trgAIRiesgoUsuarioRespuestaHabitoUsuario
    AFTER INSERT
    ON RESPUESTA_HABITO_USUARIO FOR EACH ROW
    BEGIN

		CALL recalcular_riesgo_usuario(NEW.id_usuario);
	
	END;
	$$
DELIMITER ;

/* AFTER UPDATE RESPUESTAS_HABITO_USUARIO */

DELIMITER $$
CREATE TRIGGER trgAURiesgoUsuarioRespuestaHabitoUsuario
    AFTER UPDATE
    ON RESPUESTA_HABITO_USUARIO FOR EACH ROW
    BEGIN

		CALL recalcular_riesgo_usuario(NEW.id_usuario);
		
	END;
	$$
DELIMITER ;

/* AFTER DELETE RESPUESTAS_HABITO_USUARIO */

DELIMITER $$
CREATE TRIGGER trgADRiesgoUsuarioRespuestaHabitoUsuario
    AFTER DELETE
    ON RESPUESTA_HABITO_USUARIO FOR EACH ROW
    BEGIN

		CALL recalcular_riesgo_usuario(OLD.id_usuario);

	END;
	$$
DELIMITER ;

/* ------------------------- RESPUESTAS_HABITO ------------------------- */

/* AFTER INSERT RESPUESTAS_HABITO */

DELIMITER $$
CREATE TRIGGER trgAIRiesgoUsuarioRespuestaHabito
    AFTER INSERT
    ON RESPUESTA_HABITO FOR EACH ROW
    BEGIN
		DECLARE done INT DEFAULT FALSE;
		DECLARE id_usuario BIGINT;
		
		DECLARE id_usuarios CURSOR FOR
		SELECT id_usuario FROM respuesta_habito_usuario WHERE id_habito = NEW.id;
		
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
		
		OPEN id_usuarios;
		
		read_loop: LOOP
			IF done THEN
				LEAVE read_loop;
			END IF;
			FETCH id_usuarios INTO id_usuario;
			CALL recalcular_riesgo_usuario(id_usuario);
			
		END LOOP read_loop;
	END;
	$$
DELIMITER ;

/* AFTER UPDATE RESPUESTAS_HABITO */

DELIMITER $$
CREATE TRIGGER trgAURiesgoUsuarioRespuestaHabito
    AFTER UPDATE
    ON RESPUESTA_HABITO FOR EACH ROW
    BEGIN
		DECLARE done INT DEFAULT FALSE;
		DECLARE id_usuario BIGINT;
		
		DECLARE id_usuarios CURSOR FOR
		SELECT id_usuario FROM respuesta_habito_usuario WHERE id_habito = NEW.id;
		
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
		
		OPEN id_usuarios;
		
		read_loop: LOOP
			IF done THEN
				LEAVE read_loop;
			END IF;
			FETCH id_usuarios INTO id_usuario;
			CALL recalcular_riesgo_usuario(id_usuario);
			
		END LOOP read_loop;
	END;
	$$
DELIMITER ;

/* AFTER DELETE RESPUESTAS_HABITO */

DELIMITER $$
CREATE TRIGGER trgADRiesgoUsuarioRespuestaHabito
    AFTER DELETE
    ON RESPUESTA_HABITO FOR EACH ROW
    BEGIN
        DECLARE done INT DEFAULT FALSE;
		DECLARE id_usuario BIGINT;
		
		DECLARE id_usuarios CURSOR FOR
		SELECT id_usuario FROM respuesta_habito_usuario WHERE id_habito = OLD.id;
		
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
		
		OPEN id_usuarios;
		
		read_loop: LOOP
			IF done THEN
				LEAVE read_loop;
			END IF;
			FETCH id_usuarios INTO id_usuario;
			CALL recalcular_riesgo_usuario(id_usuario);
			
		END LOOP read_loop;
	END;
	$$
DELIMITER ;

/* ------------------------- SINTOMA ------------------------- */

/* AFTER INSERT SINTOMA */

DELIMITER $$
CREATE TRIGGER trgAIRiesgoUsuarioSintoma
    AFTER INSERT
    ON SINTOMA FOR EACH ROW
    BEGIN
		DECLARE done INT DEFAULT FALSE;
		DECLARE id_usuario BIGINT;
		
		DECLARE id_usuarios CURSOR FOR
		SELECT id_usuario FROM intervalo_sintoma WHERE id_sintoma = NEW.id;
		
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
		
		OPEN id_usuarios;
		
		read_loop: LOOP
			IF done THEN
				LEAVE read_loop;
			END IF;
			FETCH id_usuarios INTO id_usuario;
			CALL recalcular_riesgo_usuario(id_usuario);
			
		END LOOP read_loop;
			
	END;
	$$
DELIMITER ;

/* AFTER UPDATE SINTOMA */

DELIMITER $$
CREATE TRIGGER trgAURiesgoUsuarioSintoma
    AFTER UPDATE
    ON SINTOMA FOR EACH ROW
    BEGIN
        DECLARE done INT DEFAULT FALSE;
		DECLARE id_usuario BIGINT;
		
		DECLARE id_usuarios CURSOR FOR
		SELECT id_usuario FROM intervalo_sintoma WHERE id_sintoma = NEW.id;
		
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
		
		OPEN id_usuarios;
		
		read_loop: LOOP
			IF done THEN
				LEAVE read_loop;
			END IF;
			FETCH id_usuarios INTO id_usuario;
			CALL recalcular_riesgo_usuario(id_usuario);
			
		END LOOP read_loop;
	END;
	$$
DELIMITER ;

/* AFTER DELETE SINTOMA */

DELIMITER $$
CREATE TRIGGER trgADRiesgoUsuarioSintoma
    AFTER DELETE
    ON SINTOMA FOR EACH ROW
    BEGIN
        DECLARE done INT DEFAULT FALSE;
		DECLARE id_usuario BIGINT;
		
		DECLARE id_usuarios CURSOR FOR
		SELECT id_usuario FROM intervalo_sintoma WHERE id_sintoma = OLD.id;
		
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
		
		OPEN id_usuarios;
		
		read_loop: LOOP
			IF done THEN
				LEAVE read_loop;
			END IF;
			FETCH id_usuarios INTO id_usuario;
			CALL recalcular_riesgo_usuario(id_usuario);
			
		END LOOP read_loop;
	END;
	$$
DELIMITER ;

/* ------------------------- INTERVALO_SINTOMA ------------------------- */


/* AFTER INSERT INTERVALO_SINTOMA */

DELIMITER $$
CREATE TRIGGER trgAIRiesgoUsuarioIntervaloSintoma
    AFTER INSERT
    ON INTERVALO_SINTOMA FOR EACH ROW
    BEGIN

		CALL recalcular_riesgo_usuario(NEW.id_usuario);

	END;
	$$
DELIMITER ;

/* AFTER UPDATE INTERVALO_SINTOMA */

DELIMITER $$
CREATE TRIGGER trgAURiesgoUsuarioIntervaloSintoma
    AFTER UPDATE
    ON INTERVALO_SINTOMA FOR EACH ROW
    BEGIN

		CALL recalcular_riesgo_usuario(NEW.id_usuario);

	END;
	$$
DELIMITER ;

/* AFTER DELETE INTERVALO_SINTOMA */

DELIMITER $$
CREATE TRIGGER trgADRiesgoUsuarioIntervaloSintoma
    AFTER DELETE
    ON INTERVALO_SINTOMA FOR EACH ROW
    BEGIN

		CALL recalcular_riesgo_usuario(OLD.id_usuario);

	END;
	$$
DELIMITER ;

/* ----------------------------------------------------------------------------- */ 
/* ------------------------- RECALCULAR_RIESGO_USUARIO ------------------------- */
/* ----------------------------------------------------------------------------- */

/* PROCEDURE RECALCULAR_RIESGO_USUARIO */

DELIMITER $$
CREATE PROCEDURE recalcular_riesgo_usuario (IN usuario_id BIGINT)
BEGIN
	DECLARE riesgo DECIMAL;
    DECLARE riesgo_sintoma DECIMAL;
	SET @riesgo = 0;
    SET @riesgo_sintoma = 0;
	
	SELECT IFNULL(SUM(IFNULL(porcentaje,0)),0) INTO @riesgo FROM RESPUESTA_HABITO RH
	JOIN RESPUESTA_HABITO_USUARIO RHU
	ON RH.id = RHU.id_respuesta AND RH.id_habito = RHU.id_habito
	WHERE RHU.id_usuario = usuario_id;

    SELECT IFNULL(SUM(IFNULL(porcentaje,0)),0) INTO @riesgo_sintoma FROM sintoma s
    JOIN vw_sintomas_diferentes vw
    ON s.id = vw.id_sintoma
	WHERE vw.id_usuario = usuario_id;
  
	UPDATE USUARIO
		SET riesgo =
		CASE
		WHEN IFNULL(riesgo,0) + @riesgo + @riesgo_sintoma > 100 then 100
		WHEN IFNULL(riesgo,0) + @riesgo + @riesgo_sintoma < 0 then 0
		ELSE IFNULL(riesgo,0) + @riesgo + @riesgo_sintoma
        END
		WHERE USUARIO.id = usuario_id;
  
END $$
DELIMITER ;
