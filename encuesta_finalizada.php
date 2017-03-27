<?php 
session_start(); //to ensure you are using same session
session_destroy(); //destroy the session
include_once('header.php'); include_once('body.php'); 
	
	// exit();
?>
<div class="codes">
	<div class="container">
		<h1>ENCUESTA FINALIZADA</h1>
		<br />
		<h3>Gracias por su participación</h3>
		<br />
	</div>
</div>
<?php include_once('footer.php'); ?>