<?php
include_once("libreria/conexion.php");
$link = conexion();
session_start();

$rut_md5_tmp 	= addslashes($_REQUEST['id']);

if($pass)
{
	$pass_usuario 	= addslashes($_POST['password']);
	$pass_usuario2 	= addslashes($_POST['password2']);
	$correo 		= addslashes($_POST['email']);
	// $correo_rst		= addslashes($_REQUEST['rst']);
	//***************VALIDACIONES****************//
	if($rut_md5_tmp == ''){header("location:index.php?error=1");exit;}

	//verifica que exista el rut en la base de datos
	$SQL_verifica_rut = "SELECT * FROM usuarios WHERE usua_rut='$rut_md5_tmp';";
	if(pg_num_rows(@pg_query($link,$SQL_verifica_rut)) == 0)
		{ header("location:index.php?error=2");exit;}

	//verifica que no tenga contraseña
	$SQL_verifica_sin_pass = "SELECT * FROM usuarios 
								WHERE 	usua_rut='$rut_md5_tmp' 
									AND (usua_pass IS NULL OR usua_restablece_pass = true);";
	if(pg_num_rows(@pg_query($link,$SQL_verifica_sin_pass)) == 0)
		{header("location:login.php?error=3");exit;}

	 //contraseña contiene espacios
	if(ctype_space($pass_usuario))
		{header("location:pass.php?id=$rut_md5_tmp&error=7");exit;}

	//contraseña es menor de 6 caracteres
	if(isset($_POST['password']) AND strlen($pass_usuario) < 6)
	{
		// if($correo_rst != MD5("$correo"))
			// {
			header("location:pass.php?id=$rut_md5_tmp&error=8");
			exit;
			// }//usuario nuevo
		// else
			// {header("location:pass.php?id=$rut_md5_tmp&rst=$correo_rst&error=8");exit;}//restableciendo pass
		
	}


	//seteando contraseña
	// if($pass_usuario != '' AND $correo_rst == MD5("$correo"))
	// {
	// 	//contraseñas diferentes
	// 	if($pass_usuario != $pass_usuario2)
	// 		{header("location:pass.php?id=$rut_md5_tmp&rst=$correo_rst&error=11");exit;} //contraseñas diferentes

	// 	if ($_POST["ResultadoCaptcha"] == $_SESSION["ResultadoCaptcha"]) 
	// 	{
	//         $SQL_ingresa_pass = "UPDATE usuarios SET usua_pass='$pass_usuario', usua_restablece_pass = false
	// 							WHERE usua_rut='$rut_md5_tmp' AND usua_correo='$correo'";
	// 		if(pg_affected_rows(@pg_query($link,$SQL_ingresa_pass))>0)
	// 		{
	// 			header("location:login.php?error=13");//contraseña ingresada correctamente
	// 			exit;
	// 		}
	//     }else 
	//     	{header("location:pass.php?id=$rut_md5_tmp&rst=$correo_rst&error=12");exit;}//captcha erroneo
	// }
	

	//usuario nuevo estableciendo su contraseña
	if($pass_usuario != '')//usuario nuevo estableciendo su contraseña
	{
		if($pass_usuario != $pass_usuario2)
			{header("location:pass.php?id=$rut_md5_tmp&error=11");exit;} //contraseñas diferentes

		if ($_POST["ResultadoCaptcha"] == $_SESSION["ResultadoCaptcha"]) 
		{
			$SQL_ingresa_pass = "UPDATE usuarios SET usua_pass='$pass_usuario',usua_restablece_pass = false
								WHERE usua_rut='$rut_md5_tmp' AND usua_correo='$correo'";
			if(pg_affected_rows(@pg_query($link,$SQL_ingresa_pass))>0)
			{
				$_SESSION['rut_md5'] 	= $rut_md5_tmp;
				$_SESSION['correo'] 	= $correo;

				header("location:encuesta.php?id=".$_SESSION['rut_md5']);
				exit;
			}else
				{header("location:pass.php?id=$rut_md5_tmp&error=4");exit;}//usuario no ingresado, fallan datos
		}else
			{header("location:pass.php?id=$rut_md5_tmp&error=12");exit;}//captcha erroneo
	}

	$SQL_valida_avance 	= "	SELECT A.aenc_codigo,A.usua_ultima_encuesta,A.usua_correo,A.usua_pass,A.usua_restablece_pass
						FROM usuarios AS A
						WHERE A.usua_rut = '$rut_md5_tmp';";
	$RES_valida_avance 	= pg_query($link,$SQL_valida_avance); 
	if(pg_num_rows($RES_valida_avance)>0)
	{
		$ROW_valida_avance 	= pg_fetch_array($RES_valida_avance);
		$avance_encuesta 	= $ROW_valida_avance['aenc_codigo'];//segun tabla 1:INICIAL  2:EN PROCESO  3:FINALIZADA
		$ultima_encuesta 	= $ROW_valida_avance['usua_ultima_encuesta'];
		$correo 			= $ROW_valida_avance['usua_correo'];
	}
}
	
if($login)
{
	if($_SESSION['correo'] != '') //usuario logeado
		{header("location:encuesta.php?id=".$_SESSION['rut_md5']."&error=5");exit;}

	if($_POST['email'] != '' AND $_POST['password'] != '')
	{
		$email 		= $_POST['email'];
		$password 	= $_POST['password'];

		$SQL_valida_ingreso = "SELECT usua_rut,aenc_codigo FROM usuarios WHERE usua_correo='$email' AND usua_pass='$password'";
		$RES_valida_ingreso = @pg_query($link,$SQL_valida_ingreso);
		if(pg_num_rows($RES_valida_ingreso) > 0)
		{
			if ($_POST["ResultadoCaptcha"] == $_SESSION["ResultadoCaptcha"]) 
			{
				$_SESSION['correo_login'] = "";
				$ROW_valida_ingreso 	= pg_fetch_array($RES_valida_ingreso);
				if($ROW_valida_ingreso['aenc_codigo'] == 3)
					header("location:encuesta_finalizada.php");

				$_SESSION['rut_md5'] 	= $ROW_valida_ingreso['usua_rut'];
				$_SESSION['correo'] 	= $email;

				header("location:encuesta.php?id=".$_SESSION['rut_md5']);
				exit;
			}else
				{header("location:login.php?error=12");exit;}//captcha erroneo
		}else
		{
			$_SESSION['correo_login'] = $email;
			$SQL_valida_correo = "SELECT * FROM usuarios WHERE usua_correo='$email';";
			if(pg_num_rows(@pg_query($link,$SQL_valida_correo))>0)
				{header("location:login.php?error=14");exit;}//Contraseña inválida
			else
				{header("location:login.php?error=15");exit;}//Usuario no existe
		}
	}
}

if($encuesta)
{
	if($_SESSION['correo'] == '' OR $_SESSION['rut_md5'] == '') //usuario no logeado
		{header("location:index.php?error=1");exit;}

	if($rut_md5_tmp != $_SESSION['rut_md5']) //usuario logeado usa otro id para ver la encuesta
		{header("location:encuesta.php?id=".$_SESSION['rut_md5']);exit;}

	$rut = $_SESSION['rut_md5'];

	$SQL_valida_ingreso = "SELECT aenc_codigo FROM usuarios WHERE usua_rut='$rut';";
	$RES_valida_ingreso = @pg_query($link,$SQL_valida_ingreso);
	if(pg_num_rows($RES_valida_ingreso) > 0)
	{
		$ROW_valida_ingreso 	= pg_fetch_array($RES_valida_ingreso);
		if($ROW_valida_ingreso['aenc_codigo'] == 3)
			{header("location:encuesta_finalizada.php");exit;}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Encuesta Equipos de Investigación</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Encuesta investigacion" />
<link rel="shortcut icon" type="image/ico" href="favicon.ico" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<?php if($encuesta) echo '<link rel="stylesheet" href="css/style1.css" type="text/css" media="all" />'; ?>
<link href="css/font-awesome.css" rel="stylesheet"> 
<link href='css/fuente.css' rel='stylesheet' type='text/css'>
<link href='css/sweetalert.css' rel='stylesheet' type='text/css'>
<?php
	if($noticias)
	{
		echo "";
	}
?>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<script type="text/javascript" src="js/sweetalert.min.js"></script>
<script type="text/javascript" src="js/jquery.blockUI.js"></script>
<script type="text/javascript" src="js/js.php"></script>
<!-- <script type="application/x-javascript"> 
	addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
	function hideURLbar(){ window.scrollTo(0,1); } 
</script> -->
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
</head>