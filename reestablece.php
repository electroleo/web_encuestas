<?php
include_once("libreria/conexion.php");
include_once("libreria/funciones.php");
$link = conexion();

$correo = addslashes($_POST['mail']);

$SQL_consulta_rut = "SELECT usua_rut FROM usuarios WHERE usua_correo='$correo'";
$RES_consulta_rut = @pg_query($link,$SQL_consulta_rut);
if(pg_num_rows($RES_consulta_rut) == 0)
	die('{"success":false,"error":"El correo ingresado no esta en nuestros registros"}');

$SQL_consulta_fin = "SELECT * FROM usuarios WHERE usua_correo='$correo' AND aenc_codigo=3";
$RES_consulta_fin = @pg_query($link,$SQL_consulta_fin);
if(pg_num_rows($RES_consulta_fin) > 0)
	die('{"success":false,"error":"El usuario ya finalizó la encuesta"}');

$SQL_datos_correo = "SELECT corre_remitente_nombre,corre_remitente_correo,corre_dominio,corre_asunto,corre_correo
					FROM correo WHERE corre_codigo=2";//correo de reestablecimiento
$RES_datos_correo = @pg_query($link,$SQL_datos_correo);
if(pg_num_rows($RES_datos_correo) == 0)
	die('{"success":false,"error":"Ocurrió un problema, favor solicite reestablecimiento de contraseña usando el menu de CONTACTO"}');

$destinatario = $correo; 

$ROW_consulta_rut = pg_fetch_array($RES_consulta_rut);
$ROW_datos_correo = pg_fetch_array($RES_datos_correo);
$usuario_rut			=$ROW_consulta_rut['usua_rut'];
$corre_remitente_nombre =$ROW_datos_correo['corre_remitente_nombre'];
$corre_remitente_correo =$ROW_datos_correo['corre_remitente_correo'];
$corre_dominio 			=$ROW_datos_correo['corre_dominio'];
$corre_asunto 			=$ROW_datos_correo['corre_asunto'];
$corre_correo 			=$ROW_datos_correo['corre_correo'];

$direccion = $corre_dominio.'/pass.php?id='.$usuario_rut;
$direccion_html = "<a href=\"$direccion\"><h3>IR A ENCUESTA</h3></a>";
$cuerpo = str_replace('{DIRECCION}',$direccion_html,$corre_correo);

$asunto = $corre_asunto; 

//para el envío en formato HTML 
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
$headers .= "X-Priority: 3\r\n";
$headers .= "X-MSMail-Priority: Normal\r\n";
$headers .= "X-Mailer: php\r\n";

//dirección del remitente 
$headers .= "From: ".$corre_remitente_nombre." <".$corre_remitente_correo.">\r\n"; 

//dirección de respuesta, si queremos que sea distinta que la del remitente 
$headers .= "Reply-To: ".$corre_remitente_correo."\r\n"; 

//ruta del mensaje desde origen a destino 
$headers .= "Return-path: ".$corre_remitente_correo."\r\n"; 

if(mail($destinatario,$asunto,$cuerpo,$headers)){	
	$SQL_reestablece = "UPDATE usuarios 
						SET usua_correo_enviado='S',
							usua_restablece_pass = true 
						WHERE usua_rut='$usuario_rut'";
	@pg_query($link,$SQL_reestablece);
	echo  '{"success":true}';
}else{
	echo  '{"success":false,"error":"No se ha podido enviar el correo. Si esto persiste contáctese usando el menu de CONTACTO"}';
}
pg_close($link);
?>