<?php
include_once("libreria/conexion.php");
$link = conexion();
session_start();

$rut_md5_tmp 	= addslashes($_REQUEST['id']);

if($pass)
{
	$pass_usuario 	= addslashes($_POST['password']);

	//***************VALIDACIONES****************//
	if($rut_md5_tmp == '')
		header("location:index.php?error=1");

	$SQL_verifica_rut = "SELECT * FROM usuarios WHERE usua_rut='$rut_md5_tmp';";
	if(trim(pg_num_rows(@pg_query($link,$SQL_verifica_rut))) == 0) //verifica que exista el rut en la base de datos
		header("location:index.php?error=2");

	$SQL_verifica_sin_pass = "SELECT * FROM usuarios WHERE usua_rut='$rut_md5_tmp' AND usua_pass IS NULL;";
	if(trim(pg_num_rows(@pg_query($link,$SQL_verifica_sin_pass))) == 0) //verifica que no tenga contraseña
		header("location:index.php?error=3");

	if(ctype_space($pass_usuario)) //contraseña contiene espacios
		header("location:pass.php?id=$rut_md5_tmp&error=1");

	if(strlen($pass_usuario) >= 6) //contraseña es menor de 6 caracteres
		header("location:pass.php?id=$rut_md5_tmp&error=2");


	if($pass_usuario != '')//usuario nuevo estableciendo su contraseña
	{
		$SQL_ingresa_pass = "UPDATE usuarios SET usua_pass='$pass_usuario' WHERE usua_rut='$rut_md5_tmp'";
		if(@pg_query($link,$SQL_ingresa_pass))
			header("location:login.php");
		else
			header("location:pass.php?id=$rut_md5_tmp&error=4");
	}

	$SQL_valida_avance 	= "	SELECT A.aenc_codigo,A.usua_ultima_encuesta,A.usua_correo,A.usua_pass 
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
		header("location:encuesta.php?id=".$_SESSION['rut_md5']."&error=5");

	if($_POST['email'] != '' AND $_POST['password'] != '')
	{
		$email 		= $_POST['email'];
		$password 	= $_POST['password'];

		$SQL_valida_ingreso = "SELECT usua_rut,aenc_codigo FROM usuarios WHERE usua_correo='$email' AND usua_pass='$password'";
		$RES_valida_ingreso = @pg_query($link,$SQL_valida_ingreso);
		if(pg_num_rows($RES_valida_ingreso) > 0)
		{
			$ROW_valida_ingreso 	= pg_fetch_array($RES_valida_ingreso);
			if($ROW_valida_ingreso['aenc_codigo'] == 3)
				header("location:encuesta_finalizada.php");

			$_SESSION['rut_md5'] 	= $ROW_valida_ingreso['usua_rut'];
			$_SESSION['correo'] 	= $email;

			header("location:encuesta.php?id=".$_SESSION['rut_md5']);
		}
	}
}

if($encuesta)
{
	if($_SESSION['correo'] == '' OR $_SESSION['rut_md5'] == '') //usuario no logeado
		header("location:index.php?error=6");

	if($rut_md5_tmp != $_SESSION['rut_md5']) //usuario logeado usa otro id para ver la encuesta
		header("location:encuesta.php?id=".$_SESSION['rut_md5']);

	$rut = $_SESSION['rut_md5'];

	$SQL_valida_ingreso = "SELECT aenc_codigo FROM usuarios WHERE usua_rut='$rut';";
	$RES_valida_ingreso = @pg_query($link,$SQL_valida_ingreso);
	if(pg_num_rows($RES_valida_ingreso) > 0)
	{
		$ROW_valida_ingreso 	= pg_fetch_array($RES_valida_ingreso);
		if($ROW_valida_ingreso['aenc_codigo'] == 3)
			header("location:encuesta_finalizada.php");
	}
}

// if($_POST['password'] != '' AND strlen($_POST['password']) > 6 )


//$_SESSION['rut_md5'] = addslashes($_REQUEST['id']);



// $rut=$_SESSION['rut_md5'];
// $rut = $rut_md5_tmp;

// if($_SESSION['pass_md5'] == '')
// 	header("Location:login.php");





// if($avance_encuesta != 3)
	//header("Location:encuesta_finalizada.php");

?>
<!DOCTYPE html>
<html>
<head>
<title>Encuesta Equipos de Investigación</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!--// bootstrap-css -->
<!-- css -->
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<!--// css -->
<!-- font-awesome icons -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
<!-- font -->
<link href='css/fuente.css' rel='stylesheet' type='text/css'>
<!-- //font -->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});

		$("#next").click(function(e){
			e.preventDefault();
	        var parametros = {};

	        <?php  
	        	// if($ver_anterior) 
						// echo "parametros['back'] = 'true'";
	        ?>

	        $('#miform :input').each(function(i,val){
	        	var tipo = val.attributes.type1.value;
	        	if( tipo == 1 || tipo == 2)
	        	{	
		        	if(val.checked)
						parametros[val.id] = 'on';
	        	}else if(tipo == 3)
	        	{
		        	parametros[val.attributes.idspan.value] = val.value;
	        	}else if(tipo == 4)
	        	{
	        		if(val.checked)
						parametros[val.id] = 'on';
	        	}
	        });

	        $.ajax({
	            url: 'ingreso.php',
	            type: 'post',
	            dataType: 'json',
	            data: parametros,
	            success: function(data) {
	                location.reload();
	            }
	        });
		});

		$("#back").click(function(e){
			e.preventDefault();
			<?php
			// $.ajax({
	  //           url: 'ingreso.php',
	  //           type: 'post',
	  //           dataType: 'json',
	  //           data: {'back':'S',},
	  //           success: function(data) {
	  //               location.reload();
	  //           }
	  //       });
			?>
		});

		$("#acepta_encuesta").click(function(e){
			e.preventDefault();

			$.ajax({
	            url: 'ingreso.php',
	            type: 'post',
	            dataType: 'json',
	            data: {'acepta':'S','extra':$('#dpersonal')[0].value},
	            success: function(data) {
	                location.reload();
	            }
	        });
		});

	});

		

	// function login(form){
	// 	$.ajax({
 //            url: 'ingreso.php',
 //            type: 'post',
 //            dataType: 'json',
 //            data: form.serialize(),
 //            success: function(data) {
                
 //            }
 //        });
	// }
</script>	
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->

<!-- <script src="js/jquery.min.js"></script> -->
<!-- <script src="js/jquery.dropotron.min.js"></script> -->
<!-- <script src="js/jquery.scrollgress.min.js"></script> -->
<!-- <script src="js/jquery.scrolly.min.js"></script> -->
<!-- <script src="js/jquery.slidertron.min.js"></script> -->
<!-- <script src="js/skel.min.js"></script> -->
<!-- <script src="js/skel-layers.min.js"></script> -->
<!-- <script src="js/init.js"></script> -->
<!-- <link rel="stylesheet" href="css/skel.css" /> -->
</head>