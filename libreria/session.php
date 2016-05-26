<?
session_start();

function err_sesion( $msje )
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >

	<head>	
		<!--  Hoja de estilos principal -->
		<link rel="stylesheet" type="text/css" href="css/main_portal.css" media="all" />
<style>	
* 		{ font-family: "Segoe UI", "Trebuchet MS", Geneva, Arial, Helvetica, SunSans-Regular, sans-serif; background-color: #fdfdfd; text-align:center; }
body	{ background-color:#fdfdfd; }
h4 		{ font-size: 20pt; font-weight:bold; color:#3366AF; }
h5 		{ font-size: 11pt; font-weight:bold; color:#3A3A3A; margin:0px }
p 		{ font-size: 10pt; #525C66; }
td		{ font-size: 10pt; }
</style>
	<head>
	<body>
		<div id="banner"></div>
		<?=$msje;?>
	</body>
</html>
<?	
}


// Si se hizo un bypass desde el portal
if( isset( $_POST['btn_intro'] ) && isset( $_POST['hdd_user'] ) && isset( $_POST['hdd_psw'] ) )
{
	$_SESSION['_MASTER_RUT']= base64_decode( $_POST['hdd_user'] );	// USUARIO MAESTRO INICIAL, NO CAMBIAR
	$_SESSION['user_actual']= base64_decode( $_POST['hdd_user'] );	// USUARIO ACTUAL VIGENTE, PUEDE CAMBIAR
	
	$_SESSION['user']		= base64_decode( $_POST['hdd_user'] );	// VARIABLE DEL ESCRITORIO DEL PORTAL, NO CAMBIAR
	
	$_SESSION['psw']		= base64_decode( $_POST['hdd_psw'] );
	$_SESSION['log']		= base64_decode( $_POST['hdd_log'] );
	$_SESSION['sistema']	= base64_decode( $_POST['hdd_log'] );	

}


$_SESSION['user']='16633688-0';
$_SESSION['sistema']='ACAD-CURR';

//--------------------------------------------------------------------------------------------------------------
//$_RUT 		= '12708007-0';	// RUT DE USUARIO DE PRUEBAS
//--------------------------------------------------------------------------------------------------------------

if (isset($_SESSION['user']) ) 
{	
	$_RUT 		= $_SESSION['user'];		// VARIABLE CON EL RUT ACTUAL	
	$_SISTEMA 	= $_SESSION['sistema'];
}
else
{	
	if($_SESSION['user']=="" || $_SESSION['user']==null)
	{
		$mensaje = "<h4>Error de sesión</h4>";
		$mensaje .="<h5>Ocurrió un error al validar su sesión en el sistema</h5>";
		$mensaje .="<p>Es probable que su sesión haya expirado, por favor vuelva a ingresar o autenticarse en el sistema.</p>";
	}
	else
	{
		$mensaje = "<h4>Error de sesión</h4>";
		$mensaje .="<h5>Ocurrió un error al validar su sesión en el sistema</h5>";
		$mensaje .="<p>Probablemente ha intentado ingresar a una página no autorizada para este perfil</p>";
	}
	err_sesion( $mensaje );
	die();
}
header("Expires: 0");
header("Pragma: no-cache");

// RUT de la session, este deberia pasarse desde el escritorio del portal


// Sistema Academico curricular, no modificar
// El sistema ahora es pasado por session desde el escritorio
 $_SISTEMA 	= 'ACAD-CURR';

// Inicia las variables del usuario
$_PERFIL 	= "";		// Perfil predeterminado
$_EMAIL 	= "";		// Correo registrado en la base de seguridad
$_UNOMBRE	= "";		// Nombre completo del usuario

// Establece las variables de usuario y sistema
$_SESSION["_RUT"] 		= $_RUT;
$_SESSION["_RUTNRO"]	= substr(trim($_RUT), 0, -2);
$_SESSION["_SISTEMA"] 	= $_SISTEMA;

// Obtener los datos principales del usuario en el sistema ACAD-CURR
$link = conexion();	
$SQL_config = "EXEC SEGURIDAD.dbo.acad_datos_usuario '$_RUT', '$_SISTEMA'";
$RES_config = mssql_query( $SQL_config, $link );

if( $ROW_config = mssql_fetch_object( $RES_config ) )
{
	// Inicializa las variables segun la base de seguridad
	$_PERFIL 	= $ROW_config->codigo_perfil;
	$_EMAIL 	= $ROW_config->mail;
	$_UNOMBRE	= $ROW_config->nombre;
}

// Inicia las variables de sesion
// if( !isset($_SESSION["_PERFIL"]))	{ $_SESSION["_PERFIL"] 	= $_PERFIL; }
if( !isset($_SESSION["_EMAIL"]))	{ $_SESSION["_EMAIL"]	= $_EMAIL;		}
if( !isset($_SESSION["_UNOMBRE"]))	{ $_SESSION["_UNOMBRE"]	= $_UNOMBRE;	}

if( isset($_REQUEST["cbo_usrperfil"]) )
{
	echo "<!-- ENCONTRO EL PERFIL DEL COMBOBOX : -->";
	$_PERFIL 				= $_REQUEST["cbo_usrperfil"];
	$_SESSION["_PERFIL"]	= $_REQUEST["cbo_usrperfil"];
}

	// Si estos por algun motivo estan nulos, buscara el primer perfil y los asignara a la sesion
	if( $_SESSION["_PERFIL"]=="" || $_SESSION["_PERFIL"]==null  )
	{
		$_PERFIL 			= $ROW_config->codigo_perfil;
		$_SESSION["_PERFIL"]= $ROW_config->codigo_perfil;
	}
?>