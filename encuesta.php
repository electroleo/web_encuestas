<?php $encuesta=true; include_once('header.php'); include_once('body.php'); 

$primera_pregunta 	= true;
$ultima_pregunta 	= true;
$SQL_avance_usuario = "SELECT B.preg_codigo,B.tpre_codigo, B.preg_nombre,B.preg_posicion,A.usua_acepta_condiciones,
								A.usua_ultima_encuesta,A.usua_visita_encuesta
						FROM usuarios AS A
							INNER JOIN pregunta AS B ON(A.usua_ultima_encuesta=B.preg_posicion)
						WHERE A.usua_rut='$rut'; ";
$RES_avance_usuario = @pg_query($link,$SQL_avance_usuario);
$ROW_avance_usuario = pg_fetch_array($RES_avance_usuario);

$pregunta_codigo 	= $ROW_avance_usuario['preg_codigo'];
$pregunta_detalle 	= $ROW_avance_usuario['preg_nombre'];
$pregunta_tipo 		= $ROW_avance_usuario['tpre_codigo'];
$pregunta_posicion	= $ROW_avance_usuario['preg_posicion'];//posicion actual del encuestado
// $ultima_pregunta 	= $ROW_avance_usuario['usua_ultima_encuesta'];
$ultima_vista 		= $ROW_avance_usuario['usua_visita_encuesta'];
$acepta_condiciones	= (trim($ROW_avance_usuario['usua_acepta_condiciones']) == 'S')? true:false;

$SQL_primera_pregunta 	="SELECT preg_posicion 
						FROM pregunta AS A
						WHERE 	preg_codigo IN(
													SELECT preg_codigo FROM opciones_lista 
													UNION ALL 
													SELECT preg_codigo FROM opciones_tabla 
												)			
						ORDER BY preg_posicion ASC
						LIMIT 1 OFFSET 0;";
$SQL_ultima_pregunta 	="SELECT preg_posicion 
						FROM pregunta AS A
						WHERE 	preg_codigo IN(
													SELECT preg_codigo FROM opciones_lista 
													UNION ALL 
													SELECT preg_codigo FROM opciones_tabla 
												)			
						ORDER BY preg_posicion DESC
						LIMIT 1 OFFSET 0;";
$ROW_primera_pregunta 	=pg_fetch_array(@pg_query($link,$SQL_primera_pregunta));
$ROW_ultima_pregunta 	=pg_fetch_array(@pg_query($link,$SQL_ultima_pregunta));

if(trim($pregunta_posicion) !== trim($ROW_primera_pregunta['preg_posicion']))
	$primera_pregunta = false;

if(trim($pregunta_posicion) !== trim($ROW_ultima_pregunta['preg_posicion']))
	$ultima_pregunta = false;

$SQL_verifica_finalizado = "SELECT aenc_codigo FROM usuarios WHERE usua_rut='$rut';";
$ROW_verifica_finalizado = pg_fetch_array(@pg_query($link,$SQL_verifica_finalizado));
if($ROW_verifica_finalizado['aenc_codigo'] == 3)
	header("location:encuesta_finalizada.php");
?>
<!--Shortcodes-page -->
<div class="codes">
	<div class="container">
	<?php if($acepta_condiciones){ ?>


		<form id="miform">
			<!-- <div class="codes-heading">
				<h2 class="wow fadeInDown animated" data-wow-delay=".5s">Tipos de Encuestas</h2>
				<p class="wow fadeInUp animated" data-wow-delay=".5s">Vivamus efficitur scelerisque nulla nec lobortis. Nullam ornare metus vel dolor feugiat maximus.Aenean nec nunc et metus volutpat dapibus ac vitae ipsum. Pellentesque sed rhoncus nibh</p>
			</div> -->

			<?php 

				if(trim($pregunta_tipo) == 1){ 
					$SQL_avance = "SELECT olis_correlativo,olis_detalle,olis_orden FROM opciones_lista WHERE preg_codigo='$pregunta_codigo' ORDER BY olis_orden";
					$RES_avance = @pg_query($link,$SQL_avance);

			?>
			<h3 class="hdg wow fadeInUp animated" data-wow-delay=".5s"><?php echo $pregunta_detalle; ?></h3>
				<div class="row wow fadeInUp animated" data-wow-delay=".5s">
				<?php 	if(pg_num_rows($RES_avance)> 0){   ?>
					<ul>
					<?php 	while($ROW_avance = pg_fetch_array($RES_avance)){ 
								$SQL_respuesta_guardada = "SELECT * FROM respuestas "
				  										."WHERE 	usua_rut='$rut' "
				  										."AND preg_codigo ='$pregunta_codigo' "
									  					."AND resp_correlativo = ".$ROW_avance['olis_correlativo'];
								$RES_respuesta_guardada = @pg_query($link,$SQL_respuesta_guardada);
								$checked = false;
								if(pg_num_rows($RES_respuesta_guardada) > 0)
									$checked=true;

					?>
								<li>
									<div class="input-group">
										<input <?php if($checked) echo "checked"; ?> name='encu<?php echo $pregunta_codigo;?>' type1="1" type="radio" aria-label="..." id="opcion<?php echo $ROW_avance['olis_correlativo'];?>">
										<label for="opcion<?php echo $ROW_avance['olis_correlativo'];?>"><?php echo $ROW_avance['olis_detalle'];?></label>
									</div><!-- /input-group -->
								</li>
					<?php	} ?>
					</ul>
					<?php } ?>
				</div><!-- /.row -->
			<?php
				}elseif(trim($pregunta_tipo) == 2){
					$SQL_avance = "SELECT olis_correlativo,olis_detalle,olis_orden FROM opciones_lista WHERE preg_codigo='$pregunta_codigo' ORDER BY olis_orden";
					$RES_avance = @pg_query($link,$SQL_avance);
			?>
			<h3 class="hdg wow fadeInUp animated" data-wow-delay=".5s"><?php echo $pregunta_detalle; ?></h3>
				<div class="row wow fadeInUp animated" data-wow-delay=".5s">
				<?php 	if(pg_num_rows($RES_avance)> 0){   ?>
					<ul>
					<?php 	while($ROW_avance = pg_fetch_array($RES_avance)){ 
								$SQL_respuesta_guardada = "SELECT * FROM respuestas "
				  										."WHERE 	usua_rut='$rut' "
				  										."AND preg_codigo ='$pregunta_codigo' "
									  					."AND resp_correlativo = ".$ROW_avance['olis_correlativo'];
								$RES_respuesta_guardada = @pg_query($link,$SQL_respuesta_guardada);
								$checked = false;
								if(pg_num_rows($RES_respuesta_guardada) > 0)
									$checked=true;
					?>
								<li>
									<div class="input-group">
										<input <?php if($checked) echo "checked"; ?> name="check<?php echo $pregunta_codigo;?>" type1="2" type="checkbox" aria-label="..." id="checkopc<?php echo $ROW_avance['olis_correlativo'];?>">
										<label for="checkopc<?php echo $ROW_avance['olis_correlativo'];?>"><?php echo $ROW_avance['olis_detalle'];?></label>
									</div>
								</li>
					<?php	} ?>
					</ul>
					<?php } ?>
				</div><!-- /.row -->
			<?php
				}elseif(trim($pregunta_tipo) == 3){
					$SQL_avance = "SELECT olis_correlativo,olis_detalle,olis_orden FROM opciones_lista WHERE preg_codigo='$pregunta_codigo' ORDER BY olis_orden";
					$RES_avance = @pg_query($link,$SQL_avance);
			?>
			<h3 class="hdg wow fadeInUp animated" data-wow-delay=".5s"><?php echo $pregunta_detalle; ?></h3>
				<div class="row wow fadeInUp animated" data-wow-delay=".5s">
				<?php 	if(pg_num_rows($RES_avance)> 0){   
							while($ROW_avance = pg_fetch_array($RES_avance)){
								$SQL_respuesta_guardada = "SELECT resp_respuesta_texto FROM respuestas "
				  										."WHERE 	usua_rut='$rut' "
				  										."AND preg_codigo ='$pregunta_codigo' "
									  					."AND resp_correlativo = ".$ROW_avance['olis_correlativo'];
								$RES_respuesta_guardada = @pg_query($link,$SQL_respuesta_guardada);
								$ROW_respuesta_guardada = pg_fetch_array($RES_respuesta_guardada);

				?>
					<h4><?php echo $ROW_avance['olis_detalle'];?></h4>
						<div class="input-group input-group-lg wow fadeInUp animated">
							<span class="input-group-addon" id="text<?php echo $ROW_avance['olis_correlativo'];?>"><?php echo $ROW_avance['olis_orden'];?></span>
							<input value="<?php echo $ROW_respuesta_guardada['resp_respuesta_texto']; ?>" type1="3" type="text" class="form-control" placeholder="Ingrese su respuesta" idspan="text<?php echo $ROW_avance['olis_correlativo'];?>">
						</div>
				<?php		} 
						}
				?>
				</div>
			<?php
				}elseif(trim($pregunta_tipo) == 4){
					$SQL_avance1 = "SELECT otab_correlativo,otab_detalle,otab_orden FROM opciones_tabla WHERE preg_codigo='$pregunta_codigo' AND topt_codigo=1 ORDER BY otab_orden";
					$RES_avance1 = @pg_query($link,$SQL_avance1);
			?>
			<h3 class="hdg wow fadeInUp animated" data-wow-delay=".5s"><?php echo $pregunta_detalle; ?></h3>
				<div class="bs-docs-example wow fadeInUp animated" data-wow-delay=".5s">
				<?php 	if(pg_num_rows($RES_avance1)> 0){ ?>
					<table class="table table-hover">
						<thead>
							<tr>
							<th></th>
					<?php	while($ROW_avance1 = pg_fetch_array($RES_avance1)){ ?>
							  <th><?php echo $ROW_avance1['otab_detalle'];?></th>
					<?php	} ?>
							</tr>
						</thead>
						
					<?php 	$SQL_avance2 = "SELECT otab_correlativo,otab_detalle,otab_orden FROM opciones_tabla WHERE preg_codigo='$pregunta_codigo' AND topt_codigo=2 ORDER BY otab_orden";
							$RES_avance2 = @pg_query($link,$SQL_avance2);
							if(pg_num_rows($RES_avance2)> 0){
					?>			
						<tbody>
							
							<?php	while($ROW_avance2 = pg_fetch_array($RES_avance2)){ ?>	
							  <tr><td><?php echo $ROW_avance2['otab_detalle'];?></td>
							  	<?php	$RES_avance1 = @pg_query($link,$SQL_avance1);
							  			while($ROW_avance1 = pg_fetch_array($RES_avance1)){ 
							  				$SQL_respuesta_guardada = "SELECT * FROM respuestas "
							  										."WHERE 	usua_rut='$rut' "
							  										."AND preg_codigo ='$pregunta_codigo' "
												  					."AND resp_respuesta_tabla_fila=".$ROW_avance2['otab_correlativo']
												  					."AND resp_respuesta_tabla_columna=".$ROW_avance1['otab_correlativo'];
											$RES_respuesta_guardada = @pg_query($link,$SQL_respuesta_guardada);
											$checked = false;
											if(pg_num_rows($RES_respuesta_guardada) > 0)
												$checked=true;

							  	?>
							 	<td>
									<input <?php if($checked) echo "checked"; ?> name='encu<?php echo $ROW_avance2['otab_correlativo'];?>' type1="4" type="radio" aria-label="..." id="encu<?php echo $ROW_avance2['otab_correlativo']; echo $ROW_avance1['otab_correlativo'];?>">
									<label for="encu<?php echo $ROW_avance2['otab_correlativo']; echo $ROW_avance1['otab_correlativo'];?>">&nbsp;</label>
								</td>
						  		<?php	} ?></tr>
						  	<?php	} ?>
						</tbody>
					<?php	} ?>
					</table>
				<?php 	} ?>	
				</div>
			<?php 
				}
			?>

			<div class="row wow fadeInUp animated" data-wow-delay=".5s">
				<h1>
					<table width="100%">
						<tr>
						<?php	
							if(!$primera_pregunta)
							{ ?>
								<td align="left"><a href="#" id="back" ><span class="label label-default">Atrás</span></a></td>
							<?php
							}
							if(!$ultima_pregunta)
							{ ?>
								<td align="right"><a href="#" id="next" ><span class="label label-success">Siguiente</span></a></td>
							<?php
							}else{?>
								<td align="right"><a href="#" id="next" ><span class="label label-success">Finalizar</span></a></td>
							<?php	} ?>
						</tr>
					</table>
				</h1>
			</div>
		</form>
	<?php }else{ ?>

			<p>1. Declaro que estoy de acuerdo en participar en este estudio y declaro que he sido informado/a y entiendo los objetivos, alcances y resultados del proyecto, así como sobre la modalidad de mi participación en el estudio.</p>
			<div class="input-group">
				<input name='condicion1' type="radio" aria-label="..." id="respuesta1">
				<label for="respuesta1">Si</label>
			</div>
			<div class="input-group">
				<input name='condicion1' type="radio" aria-label="..." id="respuesta2">
				<label for="respuesta2">No</label>
			</div>

			<p>2. Declaro que he sido informado/a, que entiendo y que estoy de acuerdo en que mi participación en este estudio es libre y voluntaria. Además entiendo que tengo derecho a dirigir preguntas sobre el proyecto en cualquier momento a la Dra. Sulan Wong Ramírez a través del correo electrónico swong@uct.cl,  y que puedo retirarme del estudio cuando así lo decida sin tener que dar explicaciones ni sufrir sanción o consecuencia alguna por mi decisión.</p>
			<div class="input-group">
				<input name='condicion2' type="radio" aria-label="..." id="respuesta3">
				<label for="respuesta3">Si</label>
			</div>
			<div class="input-group">
				<input name='condicion2' type="radio" aria-label="..." id="respuesta4">
				<label for="respuesta4">No</label>
			</div>

			<p>3. Declaro que he sido informado/a y que estoy de acuerdo en que mi participación en el estudio no implica riesgo alguno para mi estado de salud físico o mental, asimismo entiendo que no recibiré ningún tipo de beneficio o incentivo económico por mi participación en este estudio.</p>
			<div class="input-group">
				<input name='condicion3' type="radio" aria-label="..." id="respuesta5">
				<label for="respuesta5">Si</label>
			</div>
			<div class="input-group">
				<input name='condicion3' type="radio" aria-label="..." id="respuesta6">
				<label for="respuesta6">No</label>
			</div>

			<p>4. Declaro que se me ha informado y que estoy de acuerdo en que la información que provea será tratada con carácter confidencial y será anonimizada. Además, que ésta no será usada para ningún otro propósito que no haya sido de los declarados en este documento.</p>
			<div class="input-group">
				<input name='condicion4' type="radio" aria-label="..." id="respuesta7">
				<label for="respuesta7">Si</label>
			</div>
			<div class="input-group">
				<input name='condicion4' type="radio" aria-label="..." id="respuesta8">
				<label for="respuesta8">No</label>
			</div>

			<p>5. Declaro que he sido informado/a y que estoy de acuerdo en que la información colectada estará a disposición únicamente de la investigadora responsable y de su equipo de investigación, para el desarrollo de informes y publicaciones en revistas científicas y/o cualquier tipo de producción académica generada por la investigadora y su equipo, así como en presentaciones públicas de los resultados de la investigación. Asimismo, entiendo que todo el equipo  de investigación está igualmente obligado a preservar la confidencialidad de la data e información obtenida.</p>
			<div class="input-group">
				<input name='condicion5' type="radio" aria-label="..." id="respuesta9">
				<label for="respuesta9">Si</label>
			</div>
			<div class="input-group">
				<input name='condicion5' type="radio" aria-label="..." id="respuesta10">
				<label for="respuesta10">No</label>
			</div>

			<p>6.  Declaro que he sido informado/a que en caso de dudas relacionadas con el estudio puedo comunicarme con la investigadora responsable de este proyecto, Dra. Sulan Wong Ramírez, llamando al número telefónico  +56 45 2 205 429  o escribiendo a su correo electrónico a swong@uct.cl, o con la Presidenta del Comité de Ética de la Universidad Católica de Temuco, Mg. Jeanett Pérez, llamando al número telefónico +56 25 2 20 54 87 o enviando un correo electrónico a  jeperez@uct.cl, para obtener más información sobre mi participación en este estudio.</p>
			<div class="input-group">
				<input name='condicion6' type="radio" aria-label="..." id="respuesta11">
				<label for="respuesta11">Si</label>
			</div>
			<div class="input-group">
				<input name='condicion6' type="radio" aria-label="..." id="respuesta12">
				<label for="respuesta12">No</label>
			</div>

			<p>7. Declaro y entiendo que puedo solicitar una copia de este documento en el que se hace constar mi consentimiento y que puedo pedir información sobre los resultados de estudio, cuando éste haya terminado enviando un correo electrónico a swong@uct.cl o llamando al número telefónico +56 45 2 205 429 .</p>
			<div class="input-group">
				<input name='condicion7' type="radio" aria-label="..." id="respuesta13">
				<label for="respuesta13">Si</label>
			</div>
			<div class="input-group">
				<input name='condicion7' type="radio" aria-label="..." id="respuesta14">
				<label for="respuesta14">No</label>
			</div>

			<p>8. Por favor le pedimos que escriba su nombre y su Rut en el recuadro que está aquí abajo para indicarnos que está de acuerdo en participar en este estudio.</p>
			<div class="contact-form wow fadeInUp animated" data-wow-delay=".5s">
				<textarea id="dpersonal" placeholder="Ingrese su Nombre y Rut" required=""></textarea>
			</div>

			<h1><a href="#" id="acepta_encuesta" ><span class="label label-success">Ir a la Encuesta</span></a></h1>
	<?php } ?>
	</div>
</div>
<!--//short-codes-->
<?php include_once('footer.php'); ?>