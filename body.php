<body class="landing">
<?php

// $SQL_pregunta = "SELECT encu_codigo,tenc_codigo,preg FROM encuesta WHERE preg_codigo='".$ultima_encuesta."'";
// $RES_pregunta = pg_exec($link,$SQL_pregunta); 
// $ROW_pregunta 	= pg_fetch_array($RES_valida_avance);
// $SQL_encuesta = "SELECT ";
// if($encuesta == undefined)
	// $encuesta = false;
 //valida que body sea llamdado de la encuesta, por lo que 
														 //al abrir desde la encuesta, abre una pestaña
// $valida_sesion = session_status() === PHP_SESSION_ACTIVE ? true : false;

?>
	<!-- header -->
	<div class="header">
		<div class="top-header">
			<div class="container">
				<div class="top-header-info">
					<div class="top-header-left wow animated" data-wow-delay=".5s">
						<p>Recolección de Encuestas</p>
					</div>
					<!-- <div class="top-header-right wow fadeInRight animated" data-wow-delay=".5s">
						<div class="top-header-right-info">
							<ul>
								<li><a href="login.php">Login</a></li>
								<li><a href="signup.php">Sign up</a></li>
							</ul>
						</div>
						<div class="social-icons">
							<ul>
								<li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a class="twitter facebook" href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a class="twitter google" href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
						<div class="clearfix"> </div>
					</div> -->
					<div class="clearfix"> </div>
				</div>
			</div>
		</div>
		<div class="bottom-header">
			<div class="container">
				<div class="logo wow animated" data-wow-delay=".5s">
					<h1><a href="index.php"><img src="images/logo.jpg" alt="" /></a></h1>
				</div>
				<div class="top-nav wow animated" data-wow-delay=".5s">
					<nav class="navbar navbar-default">
						<div class="container">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">Menu						
							</button>
						</div>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li><a href="index.php" <?php if($encuesta){?>target="_blank" <?php } ?>>Inicio</a></li>
								<li><a href="proyecto.php" <?php if($encuesta){?>target="_blank" <?php } ?>>Proyecto</a></li>
<?php if($_SESSION['rut_md5'] != ''){ ?> <li><a href="encuesta.php?id=<?php echo $rut; ?>" <?php if($encuesta){?> class="active"<?php } ?>>Encuesta</a></li><?php } ?>
								<!-- <li><a href="#" class="dropdown-toggle hvr-bounce-to-bottom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gallery<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a class="hvr-bounce-to-bottom" href="gallery1.php">Gallery1</a></li>
										<li><a class="hvr-bounce-to-bottom" href="gallery2.php">Gallery2</a></li>          
									</ul>
								</li>	 -->
								<li><a href="staff.php" <?php if($encuesta){ ?>target="_blank" <?php } ?>>Staff</a></li>
								<li><a href="contacto.php" <?php if($encuesta){ ?>target="_blank" <?php } ?>>Contacto</a></li>
								<li><a <?php if($_SESSION['rut_md5'] != ''){ ?>href="logout.php">Logout<?php }else{ ?>href="login.php">Login<?php } ?></a></li>
							</ul>	
							<div class="clearfix"> </div>
						</div>	
					</nav>		
				</div>
			</div>
		</div>
	</div>
	<!-- //header -->

	