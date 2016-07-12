<?php
// Biblioteca de conexiones
//-----------------------------------------------------------------------
function conexion()
{ 
	// CONEXION DE DESARROLLO
    $usuario	= "postgres";
    $clave		= "Leonardo";
    $base		= "encuesta";
	$db_host	= "localhost"; // DESA.UCT.CL	


	
	if( ($link=@pg_Connect("dbname=$base user=$usuario password=$clave port=5432 host=$db_host")) )
    {   
  //       if ( (@mssql_select_db($base, $link)) )
		// {   
		// 	// Establece el formato de la fecha y ajustes para vistas remotas
  //           @mssql_query("SET DATEFORMAT DMY;", $link);
		// 	@mssql_query("SET ANSI_NULLS ON; SET ANSI_WARNINGS ON", $link);
			return $link;	
		// }
		// else
  //       {   
		// 	$mensaje =  "<h4>No se pudo seleccionar la base de datos</h4>";
		// 	$mensaje .= "<p><b>MOTIVO: </b>".mssql_get_last_message()."<p>";
		// 	echo err_header($mensaje);
		// 	die();
  //       }
    }
    else
    {   
		$mensaje 	 = "<h4>Error de conexión a la base de datos</h4>";
		$mensaje 	.="<h5>Ocurrió un error al intentar conectarse a la base de datos, puede probar recargando esta página.</h5>";
		$mensaje 	.="<p>Si el problema persiste contactarse con el administrador del sistema.</p>";
		// $mensaje	.= "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n";
		// $mensaje	.= "<!-- $SERVER -->\n";
		// $mensaje	.= "<!-- $db_host -->\n";
		echo err_header($mensaje);
		die();
    }
}

?>