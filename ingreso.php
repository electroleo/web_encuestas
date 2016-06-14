<?php 
include_once("libreria/conexion.php");
$link = conexion();
session_start(); 

$rut = $_SESSION['rut_md5'];
// $ver_anterior = ($_POST['back']=='S')?true:false;

$SQL_avance_usuario = "SELECT B.preg_codigo,B.tpre_codigo, B.preg_nombre,B.preg_posicion,A.usua_acepta_condiciones,
								A.usua_ultima_encuesta,A.usua_visita_encuesta
						FROM usuarios AS A
							INNER JOIN pregunta AS B ON(A.usua_ultima_encuesta=B.preg_posicion)
						WHERE A.usua_rut='".$rut."'; ";
$RES_avance_usuario = @pg_query($link,$SQL_avance_usuario);
$ROW_avance_usuario = pg_fetch_object($RES_avance_usuario);
$pregunta_codigo 	= (int) $ROW_avance_usuario->preg_codigo;
$pregunta_tipo 		= (int) $ROW_avance_usuario->tpre_codigo;
$pregunta_posicion	= (int) $ROW_avance_usuario->preg_posicion;//posicion actual del encuestado
$ultima_pregunta 	= (int) $ROW_avance_usuario->usua_ultima_encuesta;
$ultima_vista 		= (int) $ROW_avance_usuario->usua_visita_encuesta;
$acepta_condiciones	= ($ROW_avance_usuario->usua_acepta_condiciones == 'S')?true:false;

$saltar_posiciones 	= array();
$ingreso_respuesta 	= false;
$SQL_insert 		= '';
$prefijo_tipo1 		= 'opcion';
$prefijo_tipo2 		= 'checkopc';
$prefijo_tipo3 		= 'text';
$prefijo_tipo4 		= 'encu';

// if($ver_anterior)
// {

// }


if($acepta_condiciones){
	if($pregunta_tipo === 1)
	{
		$SQL_opciones_lista = "SELECT olis_correlativo
								FROM opciones_lista WHERE preg_codigo=$pregunta_codigo ";
		$RES_opciones_lista = @pg_query($link,$SQL_opciones_lista);
		if(pg_num_rows($RES_opciones_lista) == 0)
			die('{"success":false}');

		while($ROW_opciones_lista = pg_fetch_array($RES_opciones_lista))
		{
			$pregunta_correlativo = (int)$ROW_opciones_lista['olis_correlativo'];
			$encuesta = $prefijo_tipo1.$pregunta_correlativo;
			if($_POST[$encuesta] == 'on')
			{
				$SQL_insert = "INSERT INTO respuestas (usua_rut,preg_codigo,tpre_codigo,resp_correlativo)
								VALUES('$rut',$pregunta_codigo,$pregunta_tipo,$pregunta_correlativo);";
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
			if($_POST[$encuesta] == 'on')
			{
				$SQL_insert .= " INSERT INTO respuestas (usua_rut,preg_codigo,tpre_codigo,resp_correlativo)
								VALUES('$rut',$pregunta_codigo,$pregunta_tipo,$pregunta_correlativo); ";
			}
		}
	}elseif($pregunta_tipo == 3){
		$SQL_opciones_lista = "SELECT olis_correlativo,olis_salta_pregunta_orden 
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

	$SQL_elimina_respuesta = "DELETE FROM respuestas WHERE usua_rut='$rut' AND preg_codigo=$pregunta_codigo;";
	@pg_query($link,$SQL_elimina_respuesta);

	
	
	if(@pg_query($link,$SQL_insert))
	{
		$nueva_posicion = $pregunta_posicion + 1;
		$SQL_saltar_preguntas = "SELECT A.olis_salta_pregunta_orden
								FROM opciones_lista AS A
								INNER JOIN respuestas AS B ON(A.preg_codigo=B.preg_codigo AND A.olis_correlativo=B.resp_correlativo)
								WHERE A.olis_salta_pregunta_orden <> '' AND B.usua_rut='$rut'";
		$RES_saltar_preguntas = @pg_query($SQL_saltar_preguntas);
		if(pg_num_rows($RES_saltar_preguntas) > 0)
		{
			$lista_preguntas_a_saltar = '';
			while ($ROW_saltar_preguntas = pg_fetch_array($RES_saltar_preguntas))
			{
				$lista_preguntas_a_saltar .= ','.$ROW_saltar_preguntas['olis_salta_pregunta_orden'];
			}
			foreach (explode(",",substr($lista_preguntas_a_saltar,1)) as $key => $value) {
				array_push($saltar_posiciones,$value);
			}
		}
		// print_r($saltar_posiciones);
		if(!empty($saltar_posiciones))
		{
			sort($saltar_posiciones); //ordena de menor a mayor
			foreach ($saltar_posiciones as $key => $value) {
				if($nueva_posicion == $value)
					$nueva_posicion = $nueva_posicion + 1;
			}
		}

		//VERIFICA ULTIMA PREGUNTA
		$SQL_ultima_pregunta = "SELECT MAX(A.preg_posicion) AS ultimo FROM pregunta AS A 
								WHERE A.preg_codigo IN(
												SELECT preg_codigo FROM opciones_lista
												UNION ALL
												SELECT preg_codigo FROM opciones_tabla
														);";
		$ROW_ultima_pregunta = pg_fetch_array(@pg_query($link,$SQL_ultima_pregunta));
		if($ROW_ultima_pregunta['ultimo'] <= $pregunta_posicion OR $ROW_ultima_pregunta['ultimo'] <= $nueva_posicion)
		{
			$SQL_actualiza = "UPDATE usuarios SET 	aenc_codigo=3	--avance final
								WHERE usua_rut ='$rut' ";
		}else{
			$SQL_actualiza = "UPDATE usuarios SET 	usua_ultima_encuesta='$nueva_posicion',
													aenc_codigo=2	--avance parcial
								WHERE usua_rut ='$rut' ";
			
		}
		@pg_query($link,$SQL_actualiza);

		echo '{"success":true}';
	}
	else
		echo '{"success":false}';
}else{
	if($_POST['acepta'] == 'S'){
		$datos_extras = $_POST['extra'];
		$SQL_acepta = "UPDATE usuarios SET usua_acepta_condiciones='S',usua_datos_extras='$datos_extras' WHERE usua_rut ='$rut' ";
		@pg_query($link,$SQL_acepta);
		echo '{"success":true}';
	}else{
		echo '{"success":false}';
	}
}
?>