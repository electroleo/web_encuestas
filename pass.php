<?php $pass=true; include_once('header.php');  include_once('body.php'); ?>
<!-- login -->
<div class="fondo-encuesta login">
	<div class="container">
		<div class="login-body">
			<div class="login-heading">
				<h1>REGISTRO DE CONTRASEÑA</h1>
			</div>
			<div class="login-info">
				<form id="pass"  method="post">
					<div class="form-group">
						<h4 style="color: #787878;">Email</h4>
						<input type="text" name="correo" value="<?php echo $correo; ?>" disabled/>
					</div>
					<div class="form-group">
						<h4 style="color: #787878;">Contraseña</h4>
						<input type="password" oninput="seteaError();" id="password" name="password" style="margin: 0 0 0.5em;" class="lock" placeholder="Contraseña sobre 6 caracteres" pattern="^[^s]+$" required />
						<input type="password" oninput="seteaError();" id="password2" name="password2" style="margin: 0 0 0.5em;" class="lock" placeholder="Repetir Contraseña" pattern="^[^s]+$" required />
						<div style="height: 10px;margin: 0 0 1.5em;"><span style="color: red;" id="error"></span></div>
					</div>
					<input type="hidden" name="email" value="<?php echo $correo; ?>" />
					<input type="hidden" name="id" value="<?php echo $rut_md5_tmp; ?>" />
					<div class="form-group">
						<h4 style="color: #787878;">Validador</h4>
						<img src='img_captcha.php' style="padding-top: 1px" /> 
					    <input type='text' style="width: 15%;padding-top: 1px;" name='ResultadoCaptcha' id='ResultadoCaptcha' value='' title='Introduce el resultado de la suma' autocomplete="off" required/>
					</div>
					<input type="submit" name="Ingresar" value="Ingresar" />
				</form>
			</div>
		</div>
	</div>
</div>
<!-- //login -->

<!--//short-codes-->
<?php include_once('footer.php'); ?>