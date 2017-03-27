<?php $proyecto=true; include_once('header.php'); include_once('body.php'); 
include_once("libreria/conexion.php");
$link = conexion();

$SQL_proyecto = "SELECT pesta_habilitado,pesta_contenido,pesta_subtitulo,pesta_imagen1,pesta_titulo_interno 
				FROM pestanas WHERE pesta_codigo=3"; //proyecto
$RES_proyecto = @pg_query($link,$SQL_proyecto);
$ROW_proyecto = pg_fetch_array($RES_proyecto);

//****************VALIDACIONES*******************//
if(trim($ROW_proyecto['pesta_habilitado']) != 'S')
	echo "<script type=\"text/javascript\"> window.location=\"index.php\"; </script>"; //REDIRECCION SI NO ESTA HABILITADA LA PESTANA
//***********************************************//


?>
	<!-- about -->
	<div class="fondo-proyecto about">
		<div class="about-heading">
			<div class="container">
				<h2 class="wow fadeInDown animated" data-wow-delay=".5s"><?php echo $ROW_proyecto['pesta_titulo_interno']; ?></h2>
				<p class="wow fadeInUp animated" data-wow-delay=".5s"><?php echo $ROW_proyecto['pesta_subtitulo']; ?></p>
			</div>
		</div>
		<div class="about-top">
			<div class="container">
				<div class="about-bottom">
					<img class="wow fadeInUp animated" data-wow-delay=".5s" src="images/<?php echo $ROW_proyecto['pesta_imagen1']; ?>" alt="<?php echo $ROW_proyecto['pesta_titulo_interno']; ?>" />
					<p class="wow fadeInUp animated" data-wow-delay=".5s"><?php echo $ROW_proyecto['pesta_contenido']; ?></p>
				</div>
			</div>
		</div>
	</div>
	<!-- //about -->
	
	
<?php include_once('footer.php'); ?>