<?php include_once('header.php'); include_once('body.php'); ?>
	<!-- banner -->
	<div class="banner">
			<div class="slider">
				<h2 class="wow shake animated" data-wow-delay=".5s">Trip</h2>
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
								<h3 class="wow fadeInRight animated" data-wow-delay=".5s">Lorem ipsum dolor sit amet</h3>
								<p class="wow fadeInLeft animated" data-wow-delay=".5s">Curabitur eget metus eget erat vehicula semper vitae sed leo</p>
								<div class="more-button wow fadeInRight animated" data-wow-delay=".5s">
									<a href="single.php">Click Here	</a>
								</div>
							</div>
						</li>
						<li>
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
						</li>
					</ul>
				</div>
			</div>
	</div>
	<!-- //banner -->
	<!-- banner-bottom -->
	<div class="banner-bottom">
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
	</div>
	<!-- //banner-bottom -->
	<!-- information -->
	<div class="information">
		<div class="container">
			<div class="information-heading">
				<h3 class="wow fadeInDown animated" data-wow-delay=".5s">Why Book With Us</h3>
				<p class="wow fadeInUp animated" data-wow-delay=".5s">Vivamus efficitur scelerisque nulla nec lobortis. Nullam ornare metus vel dolor feugiat maximus.Aenean nec nunc et metus volutpat dapibus ac vitae ipsum. Pellentesque sed rhoncus nibh</p>
			</div>
			
			<div class="information-grids">
				<div class="col-md-4 information-grid wow fadeInLeft animated" data-wow-delay=".5s">
					<div class="information-info">
						<div class="information-grid-img">
							<img src="images/8.jpg" alt="" />
						</div>
						<div class="information-grid-info">
							<h4>Sollicitudin sit amet </h4>
							<p>Duis dapibus lacinia libero at aliquam. Sed pulvinar, magna vitae consectetur ultricies, augue massa condimentum eros non luctus ipsum lacus interdum odio.</p>
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
	
	<!-- popular -->
	<div class="popular">
		<div class="container">
			<div class="popular-heading information-heading">
				<h3 class="wow fadeInDown animated" data-wow-delay=".5s">Popular Places</h3>
				<p class="wow fadeInUp animated" data-wow-delay=".5s">Vivamus efficitur scelerisque nulla nec lobortis. Nullam ornare metus vel dolor feugiat maximus.Aenean nec nunc et metus volutpat dapibus ac vitae ipsum. Pellentesque sed rhoncus nibh</p>
			</div>
			<div class="popular-slide">
				<script>
						// You can also use "$(window).load(function() {"
						$(function () {
						// Slideshow 4
							$("#slider1").responsiveSlides({
								auto: true,
								pager: true,
								nav: false,
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
					<ul class="rslides" id="slider1">
						<li>
							<div class="popular-slide-info wow bounceIn animated" data-wow-delay=".5s">
								<h4>Australia</h4>
								<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas volutpat lacus at enim aliquet, quis iaculis nisi bibendum. Nullam cursus arcu lobortis, pharetra augue et, dignissim nunc. Morbi vestibulum tempus orci at faucibus. Sed ultricies dignissim magna tristique interdum</p>
							</div>
						</li>
						<li>
							<div class="popular-slide-info popular-slide1">
								<h4>Philippines</h4>
								<p>Habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas volutpat lacus at enim aliquet, quis iaculis nisi bibendum. Nullam cursus arcu lobortis, pharetra augue et, dignissim nunc. Morbi vestibulum tempus orci at faucibus. Sed ultricies dignissim magna tristique interdum Pellentesque</p>
							</div>
						</li>
						<li>
							<div class="popular-slide-info popular-slide2">
								<h4>Maldives</h4>
								<p>Tristique senectus pellentesque habitant morbi et netus et malesuada fames ac turpis egestas. Maecenas volutpat lacus at enim aliquet, quis iaculis nisi bibendum. Nullam cursus arcu lobortis, pharetra augue et, dignissim nunc. Morbi vestibulum tempus orci at faucibus. dignissim magna tristique interdum Sed ultricies</p>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="popular-grids">
				<div class="col-md-4 popular-grid wow fadeInLeft animated" data-wow-delay=".5s">
					<h5>Nullam convallis sagittis</h5>
					<p>Donec malesuada ultricies metus ac vehicula. Nullam convallis sagittis tellus ut dictum. Proin risus lacus, sollicitudin sit amet ante ac, dapibus convallis ipsum.</p>
				</div>
				<div class="col-md-4 popular-grid wow fadeInUp animated" data-wow-delay=".5s">
					<h5>Proin risus lacus</h5>
					<p>Donec malesuada ultricies metus ac vehicula. Nullam convallis sagittis tellus ut dictum. Proin risus lacus, sollicitudin sit amet ante ac, dapibus convallis ipsum.</p>
				</div>
				<div class="col-md-4 popular-grid wow fadeInRight animated" data-wow-delay=".5s">
					<h5>Sollicitudin sit amet ante</h5>
					<p>Donec malesuada ultricies metus ac vehicula. Nullam convallis sagittis tellus ut dictum. Proin risus lacus, sollicitudin sit amet ante ac, dapibus convallis ipsum.</p>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!-- //popular -->
	
<? include_once('footer.php'); ?>