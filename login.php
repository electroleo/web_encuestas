<?php include_once('header.php'); include_once('body.php'); ?>
<!-- login -->
<div class="login">
	<div class="container">
		<div class="login-body">
			<div class="login-heading">
				<h1>Login</h1>
			</div>
			<div class="login-info">
				<form action='javascript:login();'>
					<input type="password" name="password" class="lock" placeholder="Contraseña">
					<input type="hidden" name="id" value="<?php echo MD5($rut); ?>" >
					<div class="forgot-top-grids">
						<div class="forgot">
							<a href="#">Pedir Reestablecer Contraseña</a>
						</div>
						<div class="clearfix"> </div>
					</div>
					<input type="submit" name="Ingresar" value="Ingresar">
				</form>
			</div>
		</div>
	</div>
</div>
<!-- //login -->

<!--//short-codes-->
<? include_once('footer.php'); ?>