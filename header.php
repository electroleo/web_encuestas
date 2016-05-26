<?php
include_once("libreria/conexion.php");
$link = conexion();

$_SESSION['rut_md5'] = $_REQUEST['id'];

$rut=$_SESSION['rut_md5'];

// if($_SESSION['pass_md5'] == '')
// 	header("Location:login.php");

$SQL_valida_avance 	= "	SELECT A.aenc_codigo,B.aenc_nombre,A.usua_ultima_encuesta 
						FROM usuarios AS A
							INNER JOIN avance_encuesta AS B ON(A.aenc_codigo=B.aenc_codigo)
						WHERE A.usua_rut = '$rut'";
$RES_valida_avance 	= pg_exec($link,$SQL_valida_avance); 
$ROW_valida_avance 	= pg_fetch_array($RES_valida_avance);
$avance_encuesta 	= $ROW_valida_avance['aenc_codigo'];//segun tabla 1:INICIAL  2:EN PROCESO  3:FINALIZADA
$ultima_encuesta 	= $ROW_valida_avance['usua_ultima_encuesta'];

if($avance_encuesta != 3)
	header("Location:encuesta_finalizada.php");

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
	});
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