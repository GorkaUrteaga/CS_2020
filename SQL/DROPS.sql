/*
	DROPS DE LES TAULES PEL CREDIT DE SINTESI 2020
*/

DROP TABLE IF EXISTS RESPUESTA_HABITO_USUARIO;
DROP TABLE IF EXISTS RESPUESTA_HABITO;
DROP TABLE IF EXISTS INTERVALO_SINTOMA;
DROP TABLE IF EXISTS SINTOMA;
DROP TABLE IF EXISTS HABITO;
DROP TABLE IF EXISTS USUARIO;

/* VIEWS */

DROP VIEW IF EXISTS VW_HABITO_RESPUESTAS;
DROP VIEW IF EXISTS VW_SINTOMAS_DIFERENTES;

/* TRIGGERS */
DROP TRIGGER IF EXISTS trgAIRiesgoUsuarioRespuestaHabitoUsuario;
DROP TRIGGER IF EXISTS trgAURiesgoUsuarioRespuestaHabitoUsuario;
DROP TRIGGER IF EXISTS trgADRiesgoUsuarioRespuestaHabitoUsuario;

DROP TRIGGER IF EXISTS trgAIRiesgoUsuarioRespuestaHabito;
DROP TRIGGER IF EXISTS trgAURiesgoUsuarioRespuestaHabito;
DROP TRIGGER IF EXISTS trgADRiesgoUsuarioRespuestaHabito;

DROP TRIGGER IF EXISTS trgAIRiesgoUsuarioSintoma;
DROP TRIGGER IF EXISTS trgAURiesgoUsuarioSintoma;
DROP TRIGGER IF EXISTS trgADRiesgoUsuarioSintoma;

DROP TRIGGER IF EXISTS trgAIRiesgoUsuarioIntervaloSintoma;
DROP TRIGGER IF EXISTS trgAURiesgoUsuarioIntervaloSintoma;
DROP TRIGGER IF EXISTS trgADRiesgoUsuarioIntervaloSintoma;

/* PROCEDURES */

DROP PROCEDURE IF EXISTS RECALCULAR_RIESGO_USUARIO;