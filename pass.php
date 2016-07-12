<?php $pass=true; include_once('header.php');  include_once('body.php'); ?>
<!-- login -->
<div class="login">
	<div class="container">
		<div class="login-body">
			<div class="login-heading">
				<h1>Registro de Contraseña</h1>
			</div>
			<div class="login-info">
				<form  method="post">
					<input type="text" name="email" value="<?php echo $correo; ?>" disabled />
					<input type="password" name="password" class="lock" placeholder="Contraseña sobre 6 caracteres" pattern="^[^s]+$" required />
					<input type="hidden" name="id" value="<?php echo $rut_md5_tmp; ?>" />
					<input type="submit" name="Ingresar" value="Ingresar" />
				</form>
			</div>
		</div>
	</div>
</div>
<!-- //login -->

<!--//short-codes-->
<?php include_once('footer.php'); ?>