<?php $index=true; include_once('header.php'); include_once('body.php'); ?>
	<!-- banner -->
	<div class="banner">
			<div class="slider">
				<h2 class="wow fadeInUp animated" data-wow-delay=".5s">Proyecto Fondecyt Iniciación No 11150162</h2>
				<div class="border"></div>
				<script src="js/responsiveslides.min.js"></script>
				<script>
						// You can also use "$(window).load(function() {"
						$(function () {
						// Slideshow 4
							$("#slider3").responsiveSlides({
								auto: true,
								pager: true,
								nav: true,
								speed: 500,
								namespace: "callbacks",
								before: function () {
									$('.events').append("<li>before event fired.</li>");
								},
								after: function () {
									$('.events').append("<li>after event fired.</li>");
								}
							 });				
						});
				</script>
				<div  id="top" class="callbacks_container-wrap">
					<ul class="rslides" id="slider3">
						<li>
							<div class="slider-info">
								<h3 class="wow fadeInRight animated" data-wow-delay=".5s">Patentes e investigación científica</h3>
								<p class="wow fadeInLeft animated slider-info" data-wow-delay=".5s">Un estudio empírico sobre el ejercicio del derecho de libertad de investigación en las universidades chilenas que desarrollan I+D Un estudio empírico sobre el ejercicio del derecho de libertad de investigación en las universidades chilenas que desarrollan I+D Un estudio empírico sobre el ejercicio del derecho de libertad de investigación en las universidades chilenas que desarrollan I+D</p>
								<div class="more-button wow fadeInRight animated" data-wow-delay=".5s">
									<a href="proyecto.php">Mas información</a>
								</div>
							</div>
						</li>
<!-- 						<li>
							<div class="slider-info">
								<h3>Consectetur adipiscing elit</h3>
								<p>Quisque nisl risus, egestas in convallis vitae, fringilla cursus magna</p>
								<div class="more-button">
									<a href="single.php">Read More	</a>
								</div>
							</div>
						</li>
						<li>
							<div class="slider-info">
								<h3>Proin eget consequat ante	</h3>
								<p> Suspendisse bibendum dictum metus, at finibus elit dignissim nec	</p>
								<div class="more-button">
									<a href="single.php">Click Here	</a>
								</div>
							</div>
						</li> -->
					</ul>
				</div>
			</div>
	</div>
	<!-- //banner -->
	<!-- banner-bottom -->
<!-- 	<div class="banner-bottom">
		<div class="container">
			<div class="banner-bottom-grids">
				<div class="col-md-6 banner-bottom-left wow fadeInLeft animated" data-wow-delay=".5s">
					<div class="left-border">
						<div class="left-border-info">
							<p>Duis dapibus lacinia libero at aliquam</p>
						</div>
					</div>
				</div>
				<div class="col-md-6 banner-bottom-left banner-bottom-right wow fadeInRight animated" data-wow-delay=".5s">
					<div class="left-border">
						<div class="left-border-info right-border-info">
							<p>Duis dapibus lacinia libero at aliquam</p>
						</div>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div> -->
	<!-- //banner-bottom -->
	<!-- team -->
	<div class="team">
		<div class="container">
			<div class="popular-heading team-heading">
				<h3 class="wow fadeInUp animated" data-wow-delay=".5s">Grupo de Trabajo</h3>
				<p class="wow fadeInUp animated" data-wow-delay=".5s">Vivamus efficitur scelerisque nulla nec lobortis. Nullam ornare metus vel dolor feugiat maximus.Aenean nec nunc et metus volutpat dapibus ac vitae ipsum. Pellentesque sed rhoncus nibh</p>
			</div>
			<div class="team-grids">
				<div class="col-md-4 team-grid wow fadeInUp animated" data-wow-delay=".5s">
					<div class="circular_shadow" style="background-image: url(images/leonardo.jpg);"></div>
					<h4>Leonardo Ulloa</h4>
					<p>Estudiante de la carrera de Ingeniería Civil en Informática, Universidad Católica de Temuco, Chile</p>
				</div>
				<div class="col-md-4 team-grid wow fadeInLeft animated" data-wow-delay=".5s">
					<div class="circular_shadow" style="background-image: url(images/sulan.jpg)";></div>
					<h4>Prof. Dra. Sulan Wong</h4>
					<p>Abogada egresada de la Universidad de los Andes, Venezuela, Doctora por la Universidad de La Coruña, España. Estancias de investigación en el Instituto Nacional de Investigación y Automatización de Francia, INRIA y la Universidad de Barcelona, España. Profesora Asistente de la Universidad Católica de Temuco, Chile</p>
				</div>
				<div class="col-md-4 team-grid wow fadeInUp animated" data-wow-delay=".5s">
					<div class="circular_shadow" style="background-image: url(images/leonardo.jpg)";></div>
					<h4>Leonardo Ulloa</h4>
					<p>Estudiante de la carrera de Ingeniería Civil en Informática, Universidad Católica de Temuco, Chile</p>
				</div>
				<div class="col-md-4 team-grid wow fadeInLeft animated" data-wow-delay=".5s">
					<div class="circular_shadow" style="background-image: url(images/sulan.jpg)";></div>
					<h4>Prof. Dra. Sulan Wong</h4>
					<p>Abogada egresada de la Universidad de los Andes,Venezuela, Doctora por la Universidad de La Coruña, España. Estancias de investigación en el Instituto Nacional de Investigación y Automatización de Francia, INRIA y la Universidad de Barcelona, España. Profesora Asistente dela Universidad Católica de Temuco, Chile</p>
				</div>
				<div class="col-md-4 team-grid wow fadeInUp animated" data-wow-delay=".5s">
					<div class="circular_shadow" style="background-image: url(images/leonardo.jpg)";></div>
					<h4>Leonardo Ulloa</h4>
					<p>Estudiante de la carrera de Ingeniería Civil en Informática, Universidad Católica de Temuco, Chile</p>
				</div>
				<div class="col-md-4 team-grid wow fadeInLeft animated" data-wow-delay=".5s">
					<div class="circular_shadow" style="background-image: url(images/sulan.jpg)";></div>
					<h4>Prof. Dra. Sulan Wong</h4>
					<p>Abogada egresada de la Universidad de los Andes,Venezuela, Doctora por la Universidad de La Coruña, España. Estancias deinvestigación en el Instituto Nacional de Investigación y Automatización deFrancia, INRIA y la Universidad de Barcelona, España. Profesora Asistente dela Universidad Católica de Temuco, Chile</p>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!-- //team -->
		<!-- information -->
	<div class="banner2 information">
		<div class="container">
			<div class="information-heading">
				<h3 class="wow fadeInDown animated" data-wow-delay=".5s">Ultimas Noticias</h3>
				<p class="wow fadeInUp animated" data-wow-delay=".5s">Vivamus efficitur scelerisque nulla nec lobortis. Nullam ornare metus vel dolor feugiat maximus.Aenean nec nunc et metus volutpat dapibus ac vitae ipsum. Pellentesque sed rhoncus nibh</p>
			</div>
			
			<div class="information-grids">
				<div class="col-md-4 information-grid wow fadeInLeft animated" data-wow-delay=".5s">
					<div class="information-info">
						<div class="information-grid-img">
							<img src="images/conferencia.jpg" alt="conferencia" />
						</div>
						<div class="information-grid-info">
							<h4>Conferencia Magistral</h4>
							<p>Investigar para Patentar: la importancia estratégica de los derechos de propiedad intelectual en el mundo de la globalización neoliberal</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 information-grid wow fadeInUp animated" data-wow-delay=".5s">
					<div class="information-info">
						<div class="information-grid-info">
							<h4>Consectetur ultricies</h4>
							<p>Duis dapibus lacinia libero at aliquam. Sed pulvinar, magna vitae consectetur ultricies, augue massa condimentum eros non luctus ipsum lacus interdum odio.</p>
						</div>
						<div class="information-grid-img">
							<img src="images/3.jpg" alt="" />
						</div>
					</div>
				</div>
				<div class="col-md-4 information-grid wow fadeInRight animated" data-wow-delay=".5s">
					<div class="information-info">
						<div class="information-grid-img">
							<img src="images/7.jpg" alt="" />
						</div>
						<div class="information-grid-info">
							<h4>Nullam ornare metus</h4>
							<p>Duis dapibus lacinia libero at aliquam. Sed pulvinar, magna vitae consectetur ultricies, augue massa condimentum eros non luctus ipsum lacus interdum odio.</p>
						</div>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!-- //information -->
<?php include_once('footer.php'); ?>