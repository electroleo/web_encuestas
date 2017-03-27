<?php

$SQL_pestanas = "SELECT pesta_codigo,pesta_titulo,pesta_habilitado FROM pestanas;";
$RES_pestanas = @pg_query($link,$SQL_pestanas);

$pestana_proyecto		=false;
$pestana_contacto		=false;
$pestana_resultados		=false;
$pestana_noticias		=false;
$pestana_publicaciones	=false;
$titulo_proyecto 		='';
$titulo_contacto 		='';
$titulo_resultados 		='';
$titulo_noticias 		='';
$titulo_publicaciones 	='';

if(pg_num_rows($RES_pestanas)>0)
{
	while ($ROW_pestanas = pg_fetch_array($RES_pestanas)){
		if($ROW_pestanas['pesta_codigo']==1)
		{
			$pestana_resultados = (trim($ROW_pestanas['pesta_habilitado']) == 'S')? true:false;
			$titulo_resultados 	= $ROW_pestanas['pesta_titulo'];
		}
		if($ROW_pestanas['pesta_codigo']==2)
		{
			$pestana_contacto 	= (trim($ROW_pestanas['pesta_habilitado']) == 'S')? true:false;
			$titulo_contacto 	= $ROW_pestanas['pesta_titulo'];
		}
		if($ROW_pestanas['pesta_codigo']==3)
		{
			$pestana_proyecto 	= (trim($ROW_pestanas['pesta_habilitado']) == 'S')? true:false;
			$titulo_proyecto 	= $ROW_pestanas['pesta_titulo'];
		}
		if($ROW_pestanas['pesta_codigo']==4)
		{
			$pestana_noticias 	= (trim($ROW_pestanas['pesta_habilitado']) == 'S')? true:false;
			$titulo_noticias 	= $ROW_pestanas['pesta_titulo'];
		}
		if($ROW_pestanas['pesta_codigo']==5)
		{
			$pestana_publicaciones 	= (trim($ROW_pestanas['pesta_habilitado']) == 'S')? true:false;
			$titulo_publicaciones 	= $ROW_pestanas['pesta_titulo'];
		}
	}
}

?>
<body class="landing">
	<!-- header -->
	<div class="header">
		<div class="top-header">
			<div class="container">
				<div class="top-header-info">
					<div class="top-header-left wow animated" data-wow-delay=".5s">
						<p>Proyecto Fondecyt</p>
					</div>
					<div class="top-header-right wow animated" data-wow-delay=".5s">
						<div class="top-header-right-info">
							<ul>
								<li><p style="color: white;"><?php if($_SESSION['rut_md5'] != ''){ echo "Usuario: ".$_SESSION['correo'];} ?></p></li>
								<li><a <?php if($_SESSION['rut_md5'] != ''){ ?>href="logout.php">SALIR<?php }else{ ?>href="login.php" <?php if($login){?> class="active"<?php } ?>>Iniciar Sesión<?php } ?></a></li>
								<!-- <li><a href="signup.php">Sign up</a></li> -->
							</ul>
						</div>
						<!-- <div class="social-icons">
							<ul> -->
								<!-- <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li> -->
								<!-- <li><a class="twitter facebook" href="#"><i class="fa fa-facebook"></i></a></li> -->
								<!-- <li><a class="twitter google" href="#"><i class="fa fa-google-plus"></i></a></li> -->
						<!-- 	</ul>
						</div> -->
						<div class="clearfix"> </div>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="bottom-header">
			<div class="header-menu container">
				<div class="logo wow animated" data-wow-delay=".5s">
					<h1><a href="index.php"><img src="images/logo.png" alt="Patentes y Libertad de Investigación" /></a></h1>
				</div>
				<div class="top-nav wow animated top-nav-para-fixed" data-wow-delay=".5s">
					<nav class="navbar navbar-default">
						<div class="container">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">Menu						
							</button>
						</div>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li><a href="index.php" <?php if($encuesta){?>target="_blank" <?php } if($index){?> class="active"<?php } ?>>INICIO</a></li>
								<?php if($pestana_resultados){?><li><a href="resultados.php" <?php if($encuesta){?>target="_blank" <?php } if($resultados){?> class="active"<?php } ?>><?php echo strtoupper($titulo_resultados); ?></a></li><?php } ?>
								<?php if($pestana_noticias){?><li><a href="noticias.php" <?php if($encuesta){?>target="_blank" <?php } if($noticias){?> class="active"<?php } ?>><?php echo strtoupper($titulo_noticias); ?></a></li><?php } ?>
								<?php if($pestana_proyecto){?><li><a href="proyecto.php" <?php if($encuesta){?>target="_blank" <?php } if($proyecto){?> class="active"<?php } ?>><?php echo strtoupper($titulo_proyecto); ?></a></li><?php } ?>
								<?php if($pestana_publicaciones){?><li><a href="publicaciones.php" <?php if($encuesta){?>target="_blank" <?php } if($publicaciones){?> class="active"<?php } ?>><?php echo strtoupper($titulo_publicaciones); ?></a></li><?php } ?>
								<?php if($_SESSION['rut_md5'] != ''){ ?> <li><a href="encuesta.php?id=<?php echo $rut; ?>" <?php if($encuesta){?> class="active"<?php } ?>>ENCUESTA</a></li><?php } ?>
								<li><a <?php if($_SESSION['rut_md5'] != ''){ ?>href="logout.php">SALIR<?php }else{ ?>href="login.php" <?php if($login){?> class="active"<?php } ?>>REALIZAR ENCUESTA<?php } ?></a></li>
								<?php if($pestana_contacto){?><li><a href="contacto.php" <?php if($encuesta){?>target="_blank" <?php } if($contacto){?> class="active"<?php } ?>><?php echo strtoupper($titulo_contacto); ?></a></li><?php } ?>
								

							</ul>	
							<div class="clearfix"> </div>
						</div>	
					</nav>		
				</div>
			</div>
			</div>
		</div>
	</div>
	<!-- //header -->

	