<?php  
//! DATOS DE CONECCION LOCAL

// define("BASE_URL","http://localhost/TiendaVirtual/");
const BASE_URL = "http://localhost/TiendaVirtual";

// Zona horaria
date_default_timezone_set("America/Monterrey");


// Datos de conexion a base de datos
CONST DB_HOST = "localhost";
CONST DB_NAME = "db_tiendavirtual";
CONST DB_USER = "root";
CONST DB_PASSWORD = "";
CONST DB_CHARSET = "charset=utf8";

//! DATOS DE CONECCION SERVIDOR
// const BASE_URL = "https://fdmc04.com/TiendaVirtual";

// Datos de conexion a base de datos
// CONST DB_HOST = "localhost";
// CONST DB_NAME = "fdmccom_db_tiendavirtual";
// CONST DB_USER = "fdmccom_franciscomeza";
// CONST DB_PASSWORD = "Misterslayer04";
// CONST DB_CHARSET = "charset=utf8";
// !
// Delimitadores decimal y millar Ej. 24,128.00
CONST SPD = ".";
CONST SPM = ",";

// Simbolo de moneda
CONST SMONEY = "$";
CONST CURRENCY = "MXN";

//Esta es la version de Prueba
// ! SANDBOX PAYPAL
const URLPAYPAL = "https://api-m.sandbox.paypal.com";
const IDCLIENTE = "AQokLV_aIfw_GV35aE0oDFuS4A30C5bLw3fzoMCV3TVAKHS14aAqhCxluAtGHZpV_a9fSGnjc1sUk4x0";
const SECRET = "EOozkJz6hmTCP3AAY4CSZ6B5HzC7hz8kEaqtGemCO9MtrlRn9kAsJP9JeZRE5Jcn_xEBRxD0ParLnloS";

// ! LIVE PAYPAL
// const URLPAYPAL = "https://api-m.paypal.com";
// const IDCLIENTE = "AU6RG15i_FsQ_B6u-QTSkhWkccDuZMNZbAsEt7GVExHedUWVObibkJnTSSIePx-wFI_YDxvHrlgKWShd";
// const SECRET = "EDCj8-Th0GMMiuY9UwbBDL-n_rUCZtyW4ZKaqXv3oBjWCreZqjf-8aggwxMv1sBS2QR7qqQUb8a8HHAo";

// Esta es la version en linea
// const IDCLIENTE = "AU6RG15i_FsQ_B6u-QTSkhWkccDuZMNZbAsEt7GVExHedUWVObibkJnTSSIePx-wFI_YDxvHrlgKWShd";

// Datos para el envio de correo
CONST NOMBRE_REMITENTE = "Refacciones y Multiservicios";
// ! CORREO NORMAL
CONST EMAIL_REMITENTE = "franciscodanielmzca@gmail.com"; 
// ! CORREO DEL SERVIDOR
// CONST EMAIL_REMITENTE = "francisco@fdmc04.com"; 

CONST NOMBRE_EMPRESA = "Refacciones y Multiservicios";
CONST WEB_EMPRESA = "www.refaccionesymultiservicios.com";

// Datos Empresa
const DIRECCION = "Olmo #810, Col. Provileon, Linares, Nuevo Leon";
const TELEMPRESA = "+(52) 81-2356-5487";
// ! CORREO NORMAL
const EMAIL_EMPRESA = "franciscodanielmzca@gmail.com";
// const EMAIL_EMPRESA = "refaccionesymultiservicios01@gmail.com";
// ! CORREO WEB
// CONST EMAIL_EMPRESA = "francisco@fdmc04.com";

// ! CORREO NORMAL
const EMAIL_PEDIDOS = "franciscodanielmzca@gmail.com";
// ! CORREO WEB
// const EMAIL_PEDIDOS = "francisco@fdmc04.com";

CONST CAT_SLIDER = "1,2,3";
CONST CAT_BANNER = "4,5,6";

//Datos para Encriptar / Desencriptar
const KEY = 'fdmc';
const METHODENCRIPT = "AES-128-ECB";
// Envío
const COSTOENVIO = 150;

// Modulos
const MCLIENTES = 3;
const MPEDIDOS = 5;

// Roles
const RADMINISTRADOR = 1;
const RCLIENTES = 8;

const STATUS = array('Completo','Aprobado','Cancelado','Reembolso','Pendiente','Entregado');
?>