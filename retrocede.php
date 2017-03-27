<?php
if(!session_start())
	die();


include_once("libreria/conexion.php");
include_once("libreria/funciones.php");
$link = conexion();
 
$rut = $_SESSION['rut_md5'];

$SQL_posicion_actual = "SELECT B.preg_codigo,B.preg_posicion,B.preg_padre
						FROM usuarios AS A
							INNER JOIN pregunta AS B ON(A.usua_ultima_encuesta=B.preg_codigo)
						WHERE usua_rut='$rut';";
$ROW_posicion_actual= pg_fetch_array(@pg_query($link,$SQL_posicion_actual));
$posicion_actual 	= (string)$ROW_posicion_actual['preg_posicion']; //actual
$codigo_actual 		= (int)$ROW_posicion_actual['preg_codigo'];//actual
$codigo_padre 		= (int)$ROW_posicion_actual['preg_padre'];//actual

//$SQL_elimina_respuesta = "DELETE FROM respuestas WHERE preg_codigo=$codigo_actual AND usua_rut='$rut'";
//@pg_query($link,$SQL_elimina_respuesta);

$pregunta_anterior = busca_pregunta_anterior($rut,$codigo_actual,$codigo_padre,$link);

$SQL_actualiza_ultima_pregunta = "UPDATE usuarios 
								SET usua_ultima_encuesta='$pregunta_anterior'
								WHERE usua_rut='$rut'";
if(@pg_query($link,$SQL_actualiza_ultima_pregunta))
	echo '{"success":true}';
else
	echo '{"success":false}';

?>