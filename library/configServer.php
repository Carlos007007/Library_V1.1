<?php
/*Solo modifica lo que se encuentra en medio de las segundas
 comillas de los parentesis. Ejemplo: define("USER", "valor que ingresaras" ); 
 */

//Nombre de usuario de mysql
define("USER", "root");

//Servidor de mysql
define("SERVER", "localhost");

//Nombre de la base de datos (No modificar)
define("BD", "biblioteca");

//Contraseña de myqsl
define("PASS", "");

//Carpeta donde se almacenaran las copias de seguridad (No modificar)
define("BACKUP_PATH", "../backup/");

/*Configuración de zona horaria de tu país para más información visita
	http://php.net/manual/es/function.date-default-timezone-set.php
	http://php.net/manual/es/timezones.php
*/
date_default_timezone_set('America/El_Salvador');