/*
	INSERTS DE LES TAULES PEL CREDIT DE SINTESI 2020
*/

/* INSERT ADMINISTRADORS Marc i Gorka */
INSERT INTO USUARIO (email, password, es_admin, activado) VALUES ('$2y$10$HLOVbQFwKfjuUk58obER6.b0jBNV90qdNr2miWIW9tFuqzmfTfana','$2y$10$59vKqn565aocUETGk/zEue/ktUo2gC9gFZhw9SIdem.dSYfB1Zy8u', true, true);
INSERT INTO USUARIO (email, password, es_admin, activado) VALUES ('$2y$10$YHjwkpJ1pga6ziYnxQhONu7TUhDOmJuJ6Z6rMEh7IxHKHS//h4ozO','$2y$10$OWhKHcg536Fs35T3qAa7OeonoMlOF4oqf4IO1vPpAwBnAnTP4qho2', true, true);

/* Sempre han de donar 100% */ 
INSERT INTO SINTOMA (nombre, porcentaje) VALUES ('Fiebre',40);
INSERT INTO SINTOMA (nombre, porcentaje) VALUES ('Tos seca',50);
INSERT INTO SINTOMA (nombre, porcentaje) VALUES ('Dolor de cabeza',10);