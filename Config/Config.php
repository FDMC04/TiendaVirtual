<?php  

// define("BASE_URL","http://localhost/TiendaVirtual/");
const BASE_URL = "http://localhost/TiendaVirtual";
// const BASE_URL = "https://abelosh.com/TiendaVirtual/";

// Zona horaria
date_default_timezone_set("America/Monterrey");

// Datos de conexion a base de datos
CONST DB_HOST = "localhost";
CONST DB_NAME = "db_tiendavirtual";
CONST DB_USER = "root";
CONST DB_PASSWORD = "";
CONST DB_CHARSET = "charset=utf8";

// Delimitadores decimal y millar Ej. 24,128.00
CONST SPD = ".";
CONST SPM = ",";

// Simbolo de moneda
CONST SMONEY = "$";

// Datos para el envio de correo
CONST NOMBRE_REMITENTE = "Refacciones y Multiservicios";
CONST EMAIL_REMITENTE = "franciscodanielmzca@gmail.com"; 

CONST NOMBRE_EMPRESA = "Refacciones y Multiservicios";
CONST WEB_EMPRESA = "www.refaccionesymultiservicios.com";

CONST CAT_SLIDER = "1,2,3";
CONST CAT_BANNER = "4,5,6";

//Datos para Encriptar / Desencriptar
const KEY = 'fdmc';
const METHODENCRIPT = "AES-128-ECB";
?>