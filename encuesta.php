<?php $encuesta=true; include_once('header.php'); include_once('body.php'); include_once("libreria/funciones.php");

$primera_pregunta 	= true;
$ultima_pregunta 	= true;
$SQL_avance_usuario = "SELECT B.preg_codigo,B.tpre_codigo, B.preg_nombre,B.preg_posicion,A.usua_acepta_condiciones,
								A.usua_ultima_encuesta,A.usua_visita_encuesta,B.preg_padre
						FROM usuarios AS A
							INNER JOIN pregunta AS B ON(A.usua_ultima_encuesta=B.preg_codigo)
						WHERE A.usua_rut='$rut'; ";
$RES_avance_usuario = @pg_query($link,$SQL_avance_usuario);
$ROW_avance_usuario = pg_fetch_array($RES_avance_usuario);

$pregunta_codigo 	= (int) $ROW_avance_usuario['preg_codigo'];//pregunta codigo actual
$pregunta_detalle 	= (string) $ROW_avance_usuario['preg_nombre'];
$pregunta_tipo 		= (int) $ROW_avance_usuario['tpre_codigo'];
$pregunta_posicion	= (int) $ROW_avance_usuario['preg_posicion'];//posicion actual del encuestado
$pregunta_padre		= (int) $ROW_avance_usuario['preg_padre'];//pregunta padre
$ultima_vista 		= (int) $ROW_avance_usuario['usua_visita_encuesta'];
$acepta_condiciones	= (string) (trim($ROW_avance_usuario['usua_acepta_condiciones']) == 'S')? true:false;

$SQL_primera_pregunta 	="SELECT preg_codigo 
						FROM pregunta AS A
						WHERE 	preg_codigo IN(
													SELECT preg_codigo FROM opciones_lista 
													UNION ALL 
													SELECT preg_codigo FROM opciones_tabla 
												)
							AND preg_padre=0 --preguntas padres			
						ORDER BY preg_posicion ASC
						LIMIT 1 OFFSET 0;";
$SQL_ultima_pregunta 	="SELECT preg_codigo 
						FROM pregunta AS A
						WHERE 	preg_codigo IN(
													SELECT preg_codigo FROM opciones_lista 
													UNION ALL 
													SELECT preg_codigo FROM opciones_tabla 
												)	
							AND preg_padre=0 --preguntas padres			
						ORDER BY preg_posicion DESC
						LIMIT 1 OFFSET 0;";
$ROW_primera_pregunta 	=pg_fetch_array(@pg_query($link,$SQL_primera_pregunta));
$ROW_ultima_pregunta 	=pg_fetch_array(@pg_query($link,$SQL_ultima_pregunta));

if(trim($pregunta_codigo) !== trim($ROW_primera_pregunta['preg_codigo']))
	$primera_pregunta = false;

if(trim($pregunta_codigo) !== trim($ROW_ultima_pregunta['preg_codigo']))
	$ultima_pregunta = false;

$SQL_verifica_finalizado = "SELECT aenc_codigo FROM usuarios WHERE usua_rut='$rut';";
$ROW_verifica_finalizado = pg_fetch_array(@pg_query($link,$SQL_verifica_finalizado));
if($ROW_verifica_finalizado['aenc_codigo'] == 3)
	header("location:encuesta_finalizada.php");
?>
<!--Shortcodes-page -->
<div class="fondo-encuesta codes">
	<div class="centrado-encuesta container">
	<?php if($acepta_condiciones){ 

		$SQL_existe_respuesta = "SELECT * FROM respuestas WHERE preg_codigo = '$pregunta_codigo' AND usua_rut='$rut'";
		$RES_existe_pregunta = @pg_query($link,$SQL_existe_respuesta);
		if(pg_num_rows($RES_existe_pregunta)>0)
			$existe='existe';
		else
			$existe='nueva'
		
		?>

		<div class="caja1"><p>
			<form id="miform" onkeypress="return disableEnterKey(event)">
				<input type="hidden" value="<?php echo $existe; ?>" type1="6">
				<!-- <div class="codes-heading">
					<h2 class="wow fadeInDown animated" data-wow-delay=".5s">Tipos de Encuestas</h2>
					<p class="wow fadeInUp animated" data-wow-delay=".5s">Vivamus efficitur scelerisque nulla nec lobortis. Nullam ornare metus vel dolor feugiat maximus.Aenean nec nunc et metus volutpat dapibus ac vitae ipsum. Pellentesque sed rhoncus nibh</p>
				</div> -->
				<!-- <div> -->
					<div class="wow fadeInUp animated" style="float: left; width: 70%;" data-wow-delay=".5s">
						<?php // str_replace("\"","\"<b>",$pregunta_detalle);
								echo nl2br($pregunta_detalle); 
						?></div>
					<div style="float: right; width: 30%;text-align: right;">
					<?php

						//VERIFICA QUE EL CHECK NO CONTESTAR ESTE ACTIVADO
						$SQL_no_contesta_checked = "SELECT * FROM respuestas "
		  										."WHERE 	usua_rut='$rut' "
		  										."AND preg_codigo ='$pregunta_codigo' "
							  					."AND resp_correlativo = 0";
						$RES_no_contesta_checked = @pg_query($link,$SQL_no_contesta_checked);
						$no_contesta_checked = false;
						if(pg_num_rows($RES_no_contesta_checked) > 0)
						{	
							$no_contesta_checked=true;
						}
					?>
						<input  onchange="reset_respuesta(this.checked);"
								inicial="<?php if($no_contesta_checked) echo "true"; else echo "false"; ?>" 
								name="no_contesta" 
								type1="10" 
								type="checkbox" 
								aria-label="..." 
								id="no_contesta" 
								<?php if($no_contesta_checked) echo "checked"; ?>>
						<label for="no_contesta">No Contestar</label>
					</div>
				<!-- </div> -->
				<?php 

					if(trim($pregunta_tipo) == 1){ 
						$SQL_avance = "SELECT olis_correlativo,olis_detalle,olis_orden,olis_ingresa_texto 
										FROM opciones_lista WHERE preg_codigo='$pregunta_codigo' ORDER BY olis_orden";
						$RES_avance = @pg_query($link,$SQL_avance);

				?>
				
					<div class="wow fadeInUp animated" style="float: left;padding-top: 30px; width: 100%;" data-wow-delay=".5s">
					<?php 	if(pg_num_rows($RES_avance)> 0){   ?>
						<ul>
						<?php 	while($ROW_avance = pg_fetch_array($RES_avance)){ 
									$corre   = (int)$ROW_avance['olis_correlativo'];//correlativo
									$detalle = (string)$ROW_avance['olis_detalle'];//detalle
									$ing_text= (boolean)($ROW_avance['olis_ingresa_texto']=='t')?true:false;
									$SQL_respuesta_guardada = "SELECT resp_respuesta_texto FROM respuestas "
					  										."WHERE 	usua_rut='$rut' "
					  										."AND preg_codigo ='$pregunta_codigo' "
										  					."AND resp_correlativo = ".$ROW_avance['olis_correlativo'];
									$RES_respuesta_guardada = @pg_query($link,$SQL_respuesta_guardada);
									$checked = false;
									$respuesta_texto = "";
									if(pg_num_rows($RES_respuesta_guardada) > 0)
									{	
										$checked=true;
										$ROW_respuesta_guardada = pg_fetch_array($RES_respuesta_guardada);
										$respuesta_texto = $ROW_respuesta_guardada['resp_respuesta_texto'];
									}
						?>
									
									<li>
										<div class="input-group">
											<input onchange="<?php if($ing_text){?>activaCampo(this.checked,'explica<?php echo $corre; ?>');<?php } ?>" 
													inicial="<?php if($checked) echo "true"; else echo "false"; ?>" 
													name="encu<?php echo $pregunta_codigo;?>" 
													type1="1" 
													type="radio" 
													aria-label="..." 
													id="opcion<?php echo $corre;?>" 
													<?php if($checked) echo " checked "; ?>
													<?php if($no_contesta_checked) echo " disabled "; ?>>
											<label for="opcion<?php echo $corre;?>"><?php echo $detalle;?></label>
										</div>
										<?php 
											if($ing_text)//la opcion tiene ingreso de texto
											{
												?>
												<div class="input-group input-group-lg wow fadeInUp animated" style="padding-left: 39px;">
													<input style="cursor: default; font-size: 16px;"
															inicial="<?php if($checked) echo "true"; else echo "false"; ?>" 
															id="explica<?php echo $corre; ?>" 
															size="100" 
															value="<?php echo $respuesta_texto; ?>" 
															type1="1" 
															type="text" 
															class="form-control" 
															placeholder=""
															<?php if($checked) echo "required"; else echo "disabled"; ?>>
												</div>
												<?php
											}
										?>
									</li>
						<?php	} ?>
						</ul>
						<?php } ?>
					</div><!-- /.row -->
				<?php
					}elseif(trim($pregunta_tipo) == 2){
						$SQL_avance = "SELECT olis_correlativo,olis_detalle,olis_orden,olis_ingresa_texto
										FROM opciones_lista WHERE preg_codigo='$pregunta_codigo' ORDER BY olis_orden";
						$RES_avance = @pg_query($link,$SQL_avance);
				?>
				
					<div class="wow fadeInUp animated" style="float: left;padding-top: 30px; width: 100%;" data-wow-delay=".5s">
					<?php 	if(pg_num_rows($RES_avance)> 0){   ?>
						<ul>
						<?php 	while($ROW_avance = pg_fetch_array($RES_avance)){ 
									$corre   = (int)$ROW_avance['olis_correlativo'];//correlativo
									$detalle = (string)$ROW_avance['olis_detalle'];//detalle
									$ing_text= (boolean)($ROW_avance['olis_ingresa_texto']=='t')?true:false;
									$SQL_respuesta_guardada = "SELECT resp_respuesta_texto FROM respuestas "
					  										."WHERE 	usua_rut='$rut' "
					  										."AND preg_codigo ='$pregunta_codigo' "
										  					."AND resp_correlativo = $corre";
									$RES_respuesta_guardada = @pg_query($link,$SQL_respuesta_guardada);
									$checked = false;
									$respuesta_texto = "";
									if(pg_num_rows($RES_respuesta_guardada) > 0)
									{	
										$checked=true;
										$ROW_respuesta_guardada = pg_fetch_array($RES_respuesta_guardada);
										$respuesta_texto = $ROW_respuesta_guardada['resp_respuesta_texto'];
									}
						?>
									<li>
										<div class="input-group">
											<input onchange="<?php if($ing_text){?>activaCampo(this.checked,'explica<?php echo $corre; ?>');<?php } ?>" 
													inicial="<?php if($checked) echo "true"; else echo "false"; ?>" 
													name="check<?php echo $pregunta_codigo;?>" 
													type1="2" 
													type="checkbox" 
													aria-label="..." 
													id="checkopc<?php echo $corre;?>" 
													<?php if($checked) echo " checked "; ?>
													<?php if($no_contesta_checked) echo " disabled "; ?>>
											<label for="checkopc<?php echo $corre;?>"><?php echo $detalle;?></label>
										</div>
										<?php 
											if($ing_text)//la opcion tiene ingreso de texto
											{
												?>
												<div class="input-group input-group-lg wow fadeInUp animated" style="padding-left: 39px;">
													<input style="cursor: default; font-size: 16px;"
															inicial="<?php if($checked) echo "true"; else echo "false"; ?>" 
															id="explica<?php echo $corre; ?>" 
															size="100" 
															value="<?php echo $respuesta_texto; ?>" 
															type1="2" 
															type="text" 
															class="form-control" 
															placeholder=""
															<?php if($checked) echo "required"; else echo "disabled"; ?>>
												</div>
												<?php
											}
										?>
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
				
					<div class="wow fadeInUp animated" style="float: left;padding-top: 30px; width: 100%;" data-wow-delay=".5s">
					<?php 	if(pg_num_rows($RES_avance)> 0){   
								while($ROW_avance = pg_fetch_array($RES_avance)){
									$SQL_respuesta_guardada = "SELECT resp_respuesta_texto FROM respuestas "
					  										."WHERE 	usua_rut='$rut' "
					  										."AND preg_codigo ='$pregunta_codigo' "
										  					."AND resp_correlativo = ".$ROW_avance['olis_correlativo'];
									$RES_respuesta_guardada = @pg_query($link,$SQL_respuesta_guardada);
									$ROW_respuesta_guardada = pg_fetch_array($RES_respuesta_guardada);

					?>
						<div style="font-weight: bold;"><?php echo $ROW_avance['olis_detalle'];?></div>
							<div class="input-group input-group-lg wow fadeInUp animated">
								<span class="input-group-addon" id="text<?php echo $ROW_avance['olis_correlativo'];?>"><?php echo $ROW_avance['olis_orden'];?></span>
								<input value="<?php echo $ROW_respuesta_guardada['resp_respuesta_texto']; ?>" type1="3" type="text" class="form-control" placeholder="Ingrese su respuesta" idspan="text<?php echo $ROW_avance['olis_correlativo'];?>" required>
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
				
					<div class="bs-docs-example wow fadeInUp animated" style="float: left;padding-top: 30px; width: 100%;" data-wow-delay=".5s">
					<?php 	if(pg_num_rows($RES_avance1)> 0){ ?>
						<table class="table">
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

				<div class="wow fadeInUp animated" style="float: left; width: 100%;" data-wow-delay=".5s">
					<h1>
						<br />
						<table width="100%">
							<tr>
							<?php	
								if(!$primera_pregunta)
								{ ?>
									<td class="back"><a href="#" id="back" >Atrás</a></td>

								<?php
								}
								if(!$ultima_pregunta)
								{ ?>
									<td class="next"><a href="#" id="next" ><span class="label label-next">Siguiente</span></a></td>
									<!-- <td class="next"><a href="#" id="next" ><span class="label label-next">
									<input type="submit" value="Siguiente" />
									</span></a></td> -->
								<?php
								}else{?>
									<td class="next"><a href="#" id="next" ><span class="label label-next">Finalizar</span></a></td>
								<?php	} ?>
							</tr>
						</table>
					</h1>
				</div>
			</form>
		</p></div>
		<div class="progress">    
		<?php 
			$porcentaje = 0;
			$SQL_total = "SELECT COUNT(*) AS total_preguntas
								FROM pregunta;";
			$RES_total = @pg_query($link,$SQL_total);
			if(pg_num_rows($RES_total)>0)
			{
				$ROW_total = pg_fetch_array($RES_total);
				$total 	= $ROW_total['total_preguntas'];
				$preguntas_faltantes = lista_preguntas_faltantes($pregunta_codigo,$pregunta_padre,$link);
				$porcentaje = (($total-count($preguntas_faltantes))*100)/$total;
			}
		?>

			<div class="progress-bar progress-bar-info" style="width: <?php echo $porcentaje; ?>%"></div>
		</div>

	<?php }else{ 
		?>
		<script type="text/javascript">
		swal("Bienvenido!", "Antes de comenzar debes aceptar los Términos y Condiciones con respecto a la información que ingresarás.", "success")
		</script>


		<div class="caja2"><p>
			<form id="miform2">
			<h1 class="hdg wow fadeInDown animated titulo-condiciones" data-wow-delay=".5s">Términos y Condiciones</h1>
			<?php
			$SQL_condiciones = "SELECT cond_orden,cond_descripcion,cond_ingreso_texto,cond_texto_propuesto
								FROM condiciones
								ORDER BY cond_orden ASC;";
			$RES_condiciones = @pg_query($link,$SQL_condiciones);
			$contador = 1;
			while ($ROW_condiciones = pg_fetch_array($RES_condiciones)) {
				if($ROW_condiciones['cond_ingreso_texto'] != 'S')
				{
					?>
						<p><?php echo $ROW_condiciones['cond_orden']; ?>. <?php echo $ROW_condiciones['cond_descripcion']; ?></p>
						<?php
						/*
						// <div class="input-group">
						// 	<input name='condicion<?php echo $ROW_condiciones['cond_orden']; ?>' type="checkbox" aria-label="..." id="respuesta<?php echo $contador; ?>">
						// 	<label for="respuesta<?php echo $contador; $contador++; ?>">Acepto</label>
						</div>*/
						?>

					<?php
				}else{
					?>
						<p style="color: #3d3d3d;"><?php echo $ROW_condiciones['cond_orden']; ?>. <?php echo $ROW_condiciones['cond_descripcion']; ?></p>
						<div class="contact-form wow fadeInUp animated campo-texto" data-wow-delay=".5s">
							<input id="name" type="text" placeholder="Nombre Completo" required /> <br />
							<input id="rut" type="text" oninput="checkRut(this)" placeholder="Rut" required />
						</div>

					<?php
				}
			}

			?>
				<h1 class="acepta-condiciones">
					<a href="#" id="acepta_encuesta" >
						<span class="label label-primary">Aceptar y Comenzar</span>
					</a>
				</h1>
			</form>
		</p></div>
	<?php } ?>
	</div>
	<br />
</div>
<!--//short-codes-->
<?php include_once('footer.php'); ?>