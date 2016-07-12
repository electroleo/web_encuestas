<?php 
include_once("libreria/conexion.php");
$link = conexion();
session_start(); 

$rut = $_SESSION['rut_md5'];

$SQL_posicion_actual = "SELECT B.preg_codigo,B.preg_posicion
						FROM usuarios AS A
							INNER JOIN pregunta AS B ON(A.usua_ultima_encuesta=B.preg_posicion)
						WHERE usua_rut='$rut';";
$ROW_posicion_actual= pg_fetch_array(@pg_query($link,$SQL_posicion_actual));
$posicion_actual 	= (string)$ROW_posicion_actual['preg_posicion'];
$codigo_actual 		= (int)$ROW_posicion_actual['preg_codigo'];

$SQL_elimina_respuesta = "DELETE FROM respuestas WHERE preg_codigo=$codigo_actual AND usua_rut='$rut'";
@pg_query($link,$SQL_elimina_respuesta);

$SQL_pregunta_anterior = "SELECT A.preg_codigo,C.preg_posicion
						FROM opciones_lista AS A
							INNER JOIN respuestas AS B ON(A.preg_codigo=B.preg_codigo AND A.olis_correlativo=B.resp_correlativo)
							INNER JOIN pregunta AS C ON(A.preg_codigo=C.preg_codigo)
						WHERE 	A.olis_saltar_a_pregunta='$posicion_actual'
							AND B.usua_rut='$rut'";
$RES_pregunta_anterior = @pg_query($link,$SQL_pregunta_anterior);

if(pg_num_rows($RES_pregunta_anterior)>0)
{
	$ROW_pregunta_anterior 		= pg_fetch_array($RES_pregunta_anterior);
	$pregunta_anterior_codigo 	= (int)$ROW_pregunta_anterior['preg_codigo'];
	$pregunta_anterior_posicion	= (string)$ROW_pregunta_anterior['preg_posicion'];

}else{
	$SQL_preg_anterior = "SELECT preg_posicion FROM pregunta 
						WHERE preg_posicion < (SELECT preg_posicion FROM pregunta WHERE preg_codigo=$codigo_actual) 
						ORDER BY preg_posicion DESC
						limit 1 offset 0 ;";

	$ROW_preg_anterior 			= pg_fetch_array(@pg_query($link,$SQL_preg_anterior));
	$pregunta_anterior_posicion	= (string)$ROW_preg_anterior['preg_posicion'];
}

$SQL_actualiza_ultima_pregunta = "UPDATE usuarios 
								SET usua_ultima_encuesta='$pregunta_anterior_posicion'
								WHERE usua_rut='$rut'";
if(@pg_query($link,$SQL_actualiza_ultima_pregunta))
	echo '{"success":true}';
else
	echo '{"success":false}';

?>