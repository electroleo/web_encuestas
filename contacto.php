<?php $contacto=true; include_once('header.php'); include_once('body.php'); 
include_once("libreria/conexion.php");
$link = conexion();

$SQL_contacto = "SELECT pesta_habilitado,pesta_contenido,pesta_subtitulo,pesta_imagen1,pesta_titulo_interno 
				FROM pestanas WHERE pesta_codigo=2"; //contacto
$RES_contacto = @pg_query($link,$SQL_contacto);
$ROW_contacto = pg_fetch_array($RES_contacto);

//****************VALIDACIONES*******************//
if(trim($ROW_contacto['pesta_habilitado']) != 'S')
	echo "<script type=\"text/javascript\"> window.location=\"index.php\"; </script>"; //REDIRECCION SI NO ESTA HABILITADA LA PESTANA
//***********************************************//

?>
	
	<!-- contact -->
	<div class="fondo-proyecto contact">
		<div class="container">
			<div class="contact-heading">
					<h2 class="wow fadeInDown animated" data-wow-delay=".5s"><?php echo $ROW_contacto['pesta_titulo_interno']; ?></h2>
					<p class="wow fadeInUp animated" data-wow-delay=".5s"><?php echo $ROW_contacto['pesta_subtitulo']; ?></p>
				</div>
			
			<!-- <div class="address">
				<div class="col-md-4 address-grids wow fadeInLeft animated" data-wow-delay=".5s">
					<h4>Address :</h4>
					<ul>
						<li><p>Eiusmod Tempor inc<br>
								St Dolore Place,<br>
								Kingsport 56777</p>
						</li>
					</ul>
				</div>
				<div class="col-md-4 address-grids wow fadeInUp animated" data-wow-delay=".5s">
					<h4>Phone :</h4>
					<p>+2 123 456 789</p>
					<p>+2 987 654 321</p>
				</div>
				<div class="col-md-4 address-grids wow fadeInRight animated" data-wow-delay=".5s">
					<h4>Email :</h4>
					<p><a href="mailto:example@email.com">mail@example.com</a></p>
				</div>
				<div class="clearfix"> </div>
			</div> -->
			<div class="contact-infom wow fadeInUp animated" data-wow-delay=".5s">
				<!-- <h4>Miscellaneous Information:</h4> -->
				<p><?php echo $ROW_contacto['pesta_contenido']; ?></p>
			</div>	
			<div class="contact-form wow fadeInUp animated" data-wow-delay=".5s">
				<h4>Formulario de contacto</h4>
				<form>
					<input type="text" placeholder="Nombre" required="">
					<input type="email" placeholder="Correo" required="">
					<input type="text" placeholder="Teléfono" required="">
					<textarea placeholder="Mensaje" required=""></textarea>
					<button class="btn1 btn-1 btn-1b">Enviar</button>
				</form>
			</div>	
		</div>
	</div>
	<!-- //contact -->
	
<? include_once('footer.php'); ?>