<?php 
if(!session_start())
	die();


include_once("libreria/conexion.php");
include_once("libreria/funciones.php");
$link = conexion();

$rut = $_SESSION['rut_md5'];

$SQL_avance_usuario = "SELECT 	B.preg_codigo,B.tpre_codigo, B.preg_nombre,B.preg_posicion,B.preg_padre,
								A.usua_acepta_condiciones,A.usua_ultima_encuesta,
								A.usua_visita_encuesta
						FROM usuarios AS A
							INNER JOIN pregunta AS B ON(A.usua_ultima_encuesta=B.preg_codigo)
						WHERE A.usua_rut='".$rut."'; ";
$RES_avance_usuario = @pg_query($link,$SQL_avance_usuario);
$ROW_avance_usuario = pg_fetch_object($RES_avance_usuario);
$pregunta_codigo 	= (int) $ROW_avance_usuario->preg_codigo; //codigo de la pregunta actual
$pregunta_tipo 		= (int) $ROW_avance_usuario->tpre_codigo; //tipo de la pregunta actual
$pregunta_posicion	= (int) $ROW_avance_usuario->preg_posicion;//posicion actual del encuestado
$pregunta_padre		= (int) $ROW_avance_usuario->preg_padre;//posicion actual del encuestado
$ultima_pregunta 	= (int) $ROW_avance_usuario->usua_ultima_encuesta; //debe coincidir con la posicion actual
// $ultima_vista 		= (int) $ROW_avance_usuario->usua_visita_encuesta; //opcion no usada
$acepta_condiciones	= ($ROW_avance_usuario->usua_acepta_condiciones == 'S')?true:false;

$saltar_posiciones 	= array();
$ingreso_respuesta 	= false;
$SQL_insert 		= '';
$prefijo_tipo1 		= 'opcion';
$prefijo_tipo2 		= 'checkopc';
$prefijo_tipo2_texto= 'explica';
$prefijo_tipo3 		= 'text';
$prefijo_tipo4 		= 'encu';


if($acepta_condiciones){
	if($_POST['no_contesta'] == 'on')
	{
		$SQL_insert = "INSERT INTO respuestas (usua_rut,preg_codigo,tpre_codigo,resp_correlativo,resp_no_contesta)
						VALUES('$rut',$pregunta_codigo,$pregunta_tipo,0,true);";
	}else{
		if($pregunta_tipo === 1){
			$SQL_opciones_lista = "SELECT olis_correlativo
									FROM opciones_lista WHERE preg_codigo=$pregunta_codigo ";
			$RES_opciones_lista = @pg_query($link,$SQL_opciones_lista);
			if(pg_num_rows($RES_opciones_lista) == 0)
				die('{"success":false}');

			while($ROW_opciones_lista = pg_fetch_array($RES_opciones_lista))
			{
				$pregunta_correlativo = (int)$ROW_opciones_lista['olis_correlativo'];
				$encuesta = $prefijo_tipo1.$pregunta_correlativo;
				$encuesta_explica = $prefijo_tipo2_texto.$pregunta_correlativo;
				if($_POST[$encuesta] == 'on')
				{
					if($_POST[$encuesta_explica] != '')
					{
						$respuesta_texto = htmlspecialchars($_POST[$encuesta_explica],ENT_QUOTES);
						$SQL_insert = "INSERT INTO respuestas (usua_rut,preg_codigo,tpre_codigo,resp_correlativo,resp_respuesta_texto)
										VALUES('$rut',$pregunta_codigo,$pregunta_tipo,$pregunta_correlativo,'$respuesta_texto');";
					}else{
						$SQL_insert = "INSERT INTO respuestas (usua_rut,preg_codigo,tpre_codigo,resp_correlativo)
										VALUES('$rut',$pregunta_codigo,$pregunta_tipo,$pregunta_correlativo);";
					}
				}
			}
		}elseif($pregunta_tipo == 2){
			$SQL_opciones_lista = "SELECT olis_correlativo 
									FROM opciones_lista WHERE preg_codigo=$pregunta_codigo ";
			$RES_opciones_lista = @pg_query($link,$SQL_opciones_lista);
			if(pg_num_rows($RES_opciones_lista) == 0)
				die('{"success":false}');

			while($ROW_opciones_lista = pg_fetch_array($RES_opciones_lista))
			{
				$pregunta_correlativo = (int)$ROW_opciones_lista['olis_correlativo'];
				$encuesta = $prefijo_tipo2.$pregunta_correlativo;
				$encuesta_explica = $prefijo_tipo2_texto.$pregunta_correlativo;
				if($_POST[$encuesta] == 'on')
				{
					if($_POST[$encuesta_explica] != '')
					{
						$respuesta_texto = htmlspecialchars($_POST[$encuesta_explica],ENT_QUOTES);
						$SQL_insert .= " INSERT INTO respuestas (usua_rut,preg_codigo,tpre_codigo,resp_correlativo,resp_respuesta_texto)
										VALUES('$rut',$pregunta_codigo,$pregunta_tipo,$pregunta_correlativo,'$respuesta_texto'); ";
					}else
						$SQL_insert .= " INSERT INTO respuestas (usua_rut,preg_codigo,tpre_codigo,resp_correlativo)
										VALUES('$rut',$pregunta_codigo,$pregunta_tipo,$pregunta_correlativo); ";
				}
			}
		}elseif($pregunta_tipo == 3){
			$SQL_opciones_lista = "SELECT olis_correlativo,olis_saltar_a_pregunta 
									FROM opciones_lista WHERE preg_codigo=$pregunta_codigo ";
			$RES_opciones_lista = @pg_query($link,$SQL_opciones_lista);
			if(pg_num_rows($RES_opciones_lista) == 0)
				die('{"success":false}');

			while($ROW_opciones_lista = pg_fetch_array($RES_opciones_lista))
			{
				$pregunta_correlativo = (int)$ROW_opciones_lista['olis_correlativo'];
				$encuesta = $prefijo_tipo3.$pregunta_correlativo;
				$respuesta_texto = $_POST[$encuesta];

				$SQL_insert .= " INSERT INTO respuestas (usua_rut,preg_codigo,tpre_codigo,resp_correlativo,resp_respuesta_texto)
								VALUES('$rut',$pregunta_codigo,$pregunta_tipo,$pregunta_correlativo,'$respuesta_texto'); ";
			}
		}elseif($pregunta_tipo == 4){
			$SQL_opciones_tabla_col = "SELECT otab_correlativo FROM opciones_tabla WHERE preg_codigo=$pregunta_codigo AND topt_codigo=1";
			$SQL_opciones_tabla_fil = "SELECT otab_correlativo FROM opciones_tabla WHERE preg_codigo=$pregunta_codigo AND topt_codigo=2";
			$RES_opciones_tabla_fil = @pg_query($link,$SQL_opciones_tabla_fil);
			if(pg_num_rows($RES_opciones_tabla_fil) == 0)
				die('{"success":false}');

			while($ROW_opciones_tabla_fil = pg_fetch_array($RES_opciones_tabla_fil))
			{
				$correlativo_fila 		=$ROW_opciones_tabla_fil['otab_correlativo'];
				$RES_opciones_tabla_col = @pg_query($link,$SQL_opciones_tabla_col);
				while($ROW_opciones_tabla_col = pg_fetch_array($RES_opciones_tabla_col))
				{
					$correlativo_columna 	=$ROW_opciones_tabla_col['otab_correlativo'];
					$pregunta_correlativo 	=$correlativo_fila.$correlativo_columna;
					$encuesta = $prefijo_tipo4.$pregunta_correlativo;
					if($_POST[$encuesta] == 'on')
					{
						$SQL_insert .= " INSERT INTO respuestas (usua_rut,preg_codigo,tpre_codigo,resp_correlativo,resp_respuesta_tabla_fila,resp_respuesta_tabla_columna)
										VALUES('$rut',$pregunta_codigo,$pregunta_tipo,$correlativo_fila,$correlativo_fila,$correlativo_columna); ";
					}
				}
			}
		}
	}


	///******* ELIMINA RESPUESTAS PARA ESTE CODIGO ***////////
	$SQL_elimina_respuesta = "DELETE FROM respuestas WHERE usua_rut='$rut' AND preg_codigo=$pregunta_codigo;";
	@pg_query($link,$SQL_elimina_respuesta);
	//***********************************************///////

	///******* ELIMINA RESPUESTAS POSTERIORES A ESTA PREGUNTA SI FUE MODIFICADA ***////////
	if($_POST['confirma'] == 'on')
	{
		$lista_preguntas = lista_preguntas_faltantes($pregunta_codigo,$pregunta_padre,$link);
		$SQL_elimina_respuestas = "DELETE FROM respuestas 
									WHERE 	usua_rut='$rut' 
										AND preg_codigo IN(".implode(",",$lista_preguntas).");";
		@pg_query($link,$SQL_elimina_respuestas);
	}
	//***********************************************///////


	//***** SECUENCIA DE INGRESO DE RESPUESTA ***/////////////
	if(@pg_query($link,$SQL_insert))
	{
		$SQL_saltar_a_pregunta = "SELECT A.olis_saltar_a_pregunta
								FROM opciones_lista AS A
								INNER JOIN respuestas AS B ON(
																A.preg_codigo=B.preg_codigo AND 
																A.olis_correlativo=B.resp_correlativo
															)
								WHERE 	B.preg_codigo=$pregunta_codigo 
									AND B.usua_rut='$rut'
									AND A.olis_saltar_a_pregunta <> '0'";
		$RES_saltar_a_pregunta = @pg_query($link,$SQL_saltar_a_pregunta);

		if(pg_num_rows($RES_saltar_a_pregunta) > 0)
		{
			//se ingresan las preguntas a saltar en una lista, pues si se ingresan directo al arreglo
			//este lo toma como numero y elimina el 0 inicial de la posicion
			//es necesario conservar el 0 para que ordene de buena manera las preguntas

			$lista_preguntas_a_saltar = ''; //una lista delimitado por comas, 
			while ($ROW_saltar_preguntas = pg_fetch_array($RES_saltar_a_pregunta)) 
			{
				$salta_a_pregunta = (string)$ROW_saltar_preguntas['olis_saltar_a_pregunta'];
				$lista_preguntas_a_saltar .= ','.$salta_a_pregunta;
			}
			foreach (explode(",",substr($lista_preguntas_a_saltar,1)) as $key => $value) {//el substr para eliminar la primera coma ,
				array_push($saltar_posiciones,$value); //agrego 
			}
		}

		$nueva_posicion = '';
		if(!empty($saltar_posiciones)) //existen preguntas a las que se debe saltar
		{
			sort($saltar_posiciones); //ordena de menor a mayor
			$nueva_posicion = (string)array_pop($saltar_posiciones); //EXTRAE EL ULTIMO VALOR (EL MAS ALTO)
			
			//VERIFICA QUE LA PREGUNTA A LA QUE SALTARA EXISTA, SINO SE BUSCARÁ EL HERMANO DEL PADRE
			$SQL_existe_pregunta = "SELECT * FROM pregunta WHERE preg_codigo=$nueva_posicion";
			if(pg_num_rows(@pg_query($SQL_existe_pregunta))==0)
				$nueva_posicion = busca_hermano_mayor($pregunta_codigo,$pregunta_padre,$link);
		}else{
			if($_POST['no_contesta'] == 'on')
				$nueva_posicion = busca_hermano_mayor($pregunta_codigo,$pregunta_padre,$link); //busca el hermano mayor o el tio
			else
				$nueva_posicion = busca_siguiente_pregunta($pregunta_codigo,$pregunta_padre,$link);//secuencia normal
		}

		if($nueva_posicion==0)
		{
			$SQL_actualiza = "UPDATE usuarios SET 	aenc_codigo=3	--avance final
							WHERE usua_rut ='$rut' ";
		}else{
			$SQL_actualiza = "UPDATE usuarios SET 	usua_ultima_encuesta='$nueva_posicion',
													aenc_codigo=2	--avance parcial
								WHERE usua_rut ='$rut' ";
		}
				
		@pg_query($link,$SQL_actualiza);
		$final = ($nueva_posicion==0)?"true":"false";
		echo '{"success":true,"final":'.$final.'}';
	}
	else
		echo '{"success":false}';
}else{
	if($_POST['acepta'] == 'S'){
		$extra_nombre = addslashes($_POST['extra_nombre']);
		$extra_rut = addslashes($_POST['extra_rut']);
		$SQL_acepta = "UPDATE usuarios 
						SET usua_acepta_condiciones='S',
							usua_datos_extras_nombre='$extra_nombre',
							usua_datos_extras_rut='$extra_rut'
						WHERE usua_rut ='$rut' ";
		if(pg_affected_rows(@pg_query($link,$SQL_acepta))>0)
			echo '{"success":true}';
		else
			echo '{"success":false,"mensaje":"Los datos ingresados no son válidos."}';
	}else{
		echo '{"success":false,"mensaje":"Se debe aceptar los Términos y Condiciones para continuar."}';
	}
}
?>