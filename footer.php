<?php

$SQL_pestanas1 = "SELECT pesta_codigo,pesta_titulo,pesta_habilitado FROM pestanas;";
$RES_pestanas1 = @pg_query($link,$SQL_pestanas1);

$pestana_proyecto1	=false;
$pestana_contacto1	=false;
$pestana_resultados1	=false;
$titulo_proyecto1 	='';
$titulo_contacto1 	='';
$titulo_resultados1 	='';

if(pg_num_rows($RES_pestanas1)>0)
{
	while ($ROW_pestanas1 = pg_fetch_array($RES_pestanas1)){
		if($ROW_pestanas1['pesta_codigo']==1)
		{
			$pestana_resultados1 = (trim($ROW_pestanas1['pesta_habilitado']) == 'S')? true:false;
			$titulo_resultados1 	= $ROW_pestanas1['pesta_titulo'];
		}
		if($ROW_pestanas1['pesta_codigo']==2)
		{
			$pestana_contacto1 = (trim($ROW_pestanas1['pesta_habilitado']) == 'S')? true:false;
			$titulo_contacto1 	= $ROW_pestanas1['pesta_titulo'];
		}
		if($ROW_pestanas1['pesta_codigo']==3)
		{
			$pestana_proyecto1 = (trim($ROW_pestanas1['pesta_habilitado']) == 'S')? true:false;
			$titulo_proyecto1 	= $ROW_pestanas1['pesta_titulo'];
		}
	}
}

?>

<!-- footer -->
<div class="footer">
	<div class="container">
		<div class="footer-grids">
			<div class="col-md-3 footer-nav wow" style="width: 20%;" data-wow-delay=".5s">
				<!-- <h4>Mapa Web</h4> -->
				<ul>
					<li><a href="index.php" <?php if($encuesta){?>target="_blank" <?php } ?>>INICIO</a></li>
<?php if($pestana_resultados1){?><li><a href="resultados.php" <?php if($encuesta){?>target="_blank" <?php } ?>><?php echo strtoupper($titulo_resultados1); ?></a></li><?php } ?>
<?php if($pestana_proyecto1){?><li><a href="proyecto.php" <?php if($encuesta){?>target="_blank" <?php } ?>><?php echo strtoupper($titulo_proyecto1); ?></a></li><?php } ?>
<?php if($_SESSION['rut_md5'] != ''){ ?> <li><a href="encuesta.php?id=<?php echo $rut; ?>" <?php if($encuesta){?> class="active"<?php } ?>>ENCUESTA</a></li><?php } ?>
<li><a <?php if($_SESSION['rut_md5'] != ''){ ?>href="logout.php">SALIR<?php }else{ ?>href="login.php">REALIZAR ENCUESTA<?php } ?></a></li>
<?php if($pestana_contacto1){?><li><a href="contacto.php" <?php if($encuesta){?>target="_blank" <?php } ?>><?php echo strtoupper($titulo_contacto1); ?></a></li><?php } ?>
				</ul>
			</div>
			<div class="col-md-5 footer-nav wow" style="width: 60%;text-align: justify;" data-wow-delay=".5s">
				<h5>Proyecto Encuestas</h5>
				<p>Es claramente perceptible en el discurso jurídico-político la «correlación» entre la patente y la innovación, al ofrecer al inventor un monopolio temporal y artificial que garantice la explotación económica de la invención. De esta manera, el fortalecer la protección de la invención a través de patentes ayudaría, según se afirma, a incrementar la productividad, permitiendo a su vez la mejor forma de generación y uso del conocimiento, puesto que el inventor estaría dispuesto a revelar el conocimiento necesario para reproducir su invención a cambio del monopolio temporal de explotación de la misma.</p>

				<!-- <h5>Contáctanos</h5> -->
				<!-- <p>Nunc non feugiat quam, vitae placerat ipsum. Cras at felis congue, volutpat neque eget</p>
				<form>
					<input type="email" id="mc4wp_email" name="EMAIL" placeholder="Ingresa tu correo" required="">
					<textarea class="form-control" aria-label="..." placeholder="Ingresa tu comentario" required=""></textarea>
					<br/>
					<input type="submit" value="Enviar">
				</form> -->
			</div>
			<div class="col-md-4 footer-nav wow" style="width: 20%; padding-left: 30px;" data-wow-delay=".5s">
				<!-- <h4>Links de Interes</h4> -->
				<!-- <div class="news-grids"> -->
				<ul>
					<!-- <div class="news-grid"> -->

						<li><a href="index.php">Dirección 1</a></li>
						<li><a href="index.php">Dirección 2</a></li>
						<li><a href="index.php">Dirección 3</a></li>
						<li><a href="index.php">Dirección 4</a></li>
						<li><a href="index.php">Dirección 5</a></li>
					<!-- </div> -->
				</ul>
				<!-- </div> -->
			</div>
			<div class="clearfix"> </div>
		</div>
		<div class="copyright wow" data-wow-delay=".5s">
			<p>© 2016 UCT. Todos los derechos reservados. Diseñado por Leonardo Ulloa.</p>
		</div>
	</div>
</div>
<!-- //footer -->
</body>
</html>
<?php pg_close($link); ?>