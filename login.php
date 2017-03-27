<?php $login=true; include_once('header.php');  include_once('body.php'); ?>
<!-- login -->
<div class="fondo-encuesta login">
	<div class="container fadeInDown animated" data-wow-delay=".5s">
		<div class="login-body">
			<div class="login-heading">
				<h1>INICIAR SESIÓN</h1>
			</div>
			<div class="login-info">
				<form  method="post">
					<div class="form-group">
						<h4 style="color: #787878;">Email</h4>
						<!-- <label for="exampleInputFirst">Email</label> -->
						<input type="email" value="<?php echo $_SESSION['correo_login']; ?>" id="exampleInputFirst" name="email" class="form-control input-lg" autocomplete="off" />
					</div>
					<div class="form-group">
						<h4 style="color: #787878;">Contraseña</h4>
						<input type="password" name="password" class="form-control input-lg" required/>
					</div>
					<div class="form-group">
						<h4 style="color: #787878;">Validador</h4>
						<img src='img_captcha.php' style="padding-top: 1px" /> 
					    <input type='text' style="width: 15%;padding-top: 1px;" name='ResultadoCaptcha' id='ResultadoCaptcha' value='' title='Introduce el resultado de la suma' autocomplete="off" required/>
					</div>
					<input type="submit" name="Ingresar" value="Ingresar" />
					<div class="forgot-top-grids">
						<div class="forgot">
							<a href="#" id="restablecerPass">Restablecer Contraseña</a>
						</div>
						<div class="clearfix"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- //login -->

<!--//short-codes-->
<?php include_once('footer.php'); ?>