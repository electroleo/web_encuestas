<?php include_once('header.php'); include_once('body.php'); 
include_once("libreria/conexion.php");
$link = conexion();

$SQL_staff = "SELECT pesta_codigo,pesta_titulo,pesta_habilitado,pesta_contenido
				FROM pestanas 
				WHERE pesta_codigo=3";//pestaña de STAFF

$RES_staff = @pg_query($link,$SQL_staff);
$ROW_staff = pg_fetch_array($RES_staff);

$habilitado = ($ROW_staff['pesta_habilitado']=='S')? true:false;
?>
		
	<!-- blog -->
	<div class="blog">
		<!-- container -->
		<div class="container">
		

		<?php 
		if($habilitado)
		{
			$clase_div 	= '<div class="blog-left-left wow fadeInUp animated" data-wow-delay=".5s" ';
			$clase_p 	= '<p class="wow fadeInUp animated" data-wow-delay=".5s" ';
			$clase_h1 	= '<h1 class="wow fadeInDown animated" data-wow-delay=".5s" ';
			$clase_h2 	= '<h2 class="wow fadeInDown animated" data-wow-delay=".5s" ';
			$clase_h3 	= '<h3 class="wow fadeInDown animated" data-wow-delay=".5s" ';
			$clase_h4 	= '<h4 class="wow fadeInDown animated" data-wow-delay=".5s" ';
			$clase_h5 	= '<h5 class="wow fadeInDown animated" data-wow-delay=".5s" ';
			$clase_h6 	= '<h6 class="wow fadeInDown animated" data-wow-delay=".5s" ';

			$clase_blog_ini = '<div class="blog-heading"><h';
			$clase_blog_fin1= '</h1></div>';
			$clase_blog_fin2= '</h2></div>';
			$clase_blog_fin3= '</h1></div>';
			$clase_blog_fin4= '</h1></div>';
			$clase_blog_fin5= '</h1></div>';
			$clase_blog_fin6= '</h1></div>';

			$contenido 	= str_replace('<div',$clase_div,$ROW_staff['pesta_contenido']);
			$contenido 	= str_replace('<h1',$clase_h1,$contenido);
			$contenido 	= str_replace('<p',$clase_p,$contenido);

			//echo $ROW_staff['pesta_titulo'];
			echo $contenido;
		}
		 /*

				<div class="">
					<h2 class="blog-heading wow fadeInDown animated" data-wow-delay=".5s">Blog</h2>
					<p class="blog-heading wow fadeInUp animated" data-wow-delay=".5s">Vivamus efficitur scelerisque nulla nec lobortis. Nullam ornare metus vel dolor feugiat maximus.Aenean nec nunc et metus volutpat dapibus ac vitae ipsum. Pellentesque sed rhoncus nibh</p>
				</div>
				<div class="blog-top-grids">
					<div class="col-md-8 blog-top-left-grid">
						<div class="left-blog">
							<div class="blog-left">
								<div class="blog-left-left wow fadeInUp animated" data-wow-delay=".5s">
									<p>Posted By <a href="#">Admin</a> &nbsp;&nbsp; on June 2, 2016 &nbsp;&nbsp; <a href="#">Comments (10)</a></p>
									<a href="single.php"><img src="images/8.jpg" alt="" /></a>
								</div>
								<div class="blog-left-right wow fadeInUp animated" data-wow-delay=".5s">
									<a href="single.php">Phasellus ultrices tellus eget ipsum ornare molestie </a>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.Sed blandit massa vel mauris sollicitudin 
									dignissim. Phasellus ultrices tellus eget ipsum ornare molestie scelerisque eros dignissim. Phasellus 
									fringilla hendrerit lectus nec vehicula. ultrices tellus eget ipsum ornare consectetur adipiscing elit.Sed blandit .
									estibulum aliquam neque nibh, sed accumsan nulla ornare sit amet. 
								</p>
								</div>
								<div class="clearfix"> </div>
							</div>
							<div class="blog-left">
								<div class="blog-left-left wow fadeInUp animated" data-wow-delay=".5s">
									<p>Posted By <a href="#">Admin</a> &nbsp;&nbsp; on June 2, 2016 &nbsp;&nbsp; <a href="#">Comments (10)</a></p>
									<a href="single.php"><img src="images/g3.jpg" alt="" /></a>
								</div>
								<div class="blog-left-right wow fadeInUp animated" data-wow-delay=".5s">
									<a href="single.php">Phasellus ultrices tellus eget ipsum ornare molestie</a>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.Sed blandit massa vel mauris sollicitudin 
									dignissim. Phasellus ultrices tellus eget ipsum ornare molestie scelerisque eros dignissim. Phasellus 
									fringilla hendrerit lectus nec vehicula. ultrices tellus eget ipsum ornare consectetur adipiscing elit.Sed blandit .
									estibulum aliquam neque nibh, sed accumsan nulla ornare sit amet.
									</p>
								</div>
								<div class="clearfix"> </div>
							</div>
							
							<div class="blog-left">
								<div class="blog-left-left wow fadeInUp animated" data-wow-delay=".5s">
									<p>Posted By <a href="#">Admin</a> &nbsp;&nbsp; on June 2, 2016 &nbsp;&nbsp; <a href="#">Comments (10)</a></p>
									<a href="single.php"><img src="images/g2.jpg" alt="" /></a>
								</div>
								<div class="blog-left-right wow fadeInUp animated" data-wow-delay=".5s">
									<a href="single.php">Phasellus ultrices tellus eget ipsum ornare molestie</a>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.Sed blandit massa vel mauris sollicitudin 
									dignissim. Phasellus ultrices tellus eget ipsum ornare molestie scelerisque eros dignissim. Phasellus 
									fringilla hendrerit lectus nec vehicula. ultrices tellus eget ipsum ornare consectetur adipiscing elit.Sed blandit .
									estibulum aliquam neque nibh, sed accumsan nulla ornare sit amet. 
									</p>
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
						<nav>
							<ul class="pagination wow fadeInUp animated" data-wow-delay=".5s">
								<li>
									<a href="#" aria-label="Previous">
										<span aria-hidden="true">«</span>
									</a>
								</li>
								<li><a href="#">1</a></li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li><a href="#">4</a></li>
								<li><a href="#">5</a></li>
								<li>
									<a href="#" aria-label="Next">
										<span aria-hidden="true">»</span>
									</a>
								</li>
							</ul>
						</nav>
					</div>
					<div class="col-md-4 blog-top-right-grid">
						<div class="Categories wow fadeInUp animated" data-wow-delay=".5s">
							<h3>Categories</h3>
							<ul>
								<li><a href="#">Phasellus sem leo, interdum quis risus</a></li>
								<li><a href="#">Nullam egestas nisi id malesuada aliquet </a></li>
								<li><a href="#"> Donec condimentum purus urna venenatis</a></li>
								<li><a href="#">Ut congue, nisl id tincidunt lobor mollis</a></li>
								<li><a href="#">Cum sociis natoque penatibus et magnis</a></li>
								<li><a href="#">Suspendisse nec magna id ex pretium</a></li>
							</ul>
						</div>
						<div class="Categories wow fadeInUp animated" data-wow-delay=".5s">
							<h3>Archive</h3>
							<ul class="marked-list offs1">
								<li><a href="#">May 2016 (7)</a></li>
								<li><a href="#">April 2016 (11)</a></li>
								<li><a href="#">March 2016 (12)</a></li>
								<li><a href="#">February 2016 (14)</a> </li>
								<li><a href="#">January 2016 (10)</a></li>    
								<li><a href="#">December 2016 (12)</a></li>
								<li><a href="#">November 2016 (8)</a></li>
								<li><a href="#">October 2016 (7)</a> </li>
								<li><a href="#">September 2016 (8)</a></li>
								<li><a href="#">August 2016 (6)</a></li>                          
							</ul>
						</div>
						<div class="comments">
							<h3 class="wow fadeInUp animated" data-wow-delay=".5s">Recent Comments</h3>
							<div class="comments-text wow fadeInUp animated" data-wow-delay=".5s">
								<div class="col-md-3 comments-left">
									<img src="images/t1.jpg" alt="" />
								</div>
								<div class="col-md-9 comments-right">
									<h5>Admin</h5>
									<a href="#">Phasellus sem leointerdum risus</a> 
									<p>March 16,2016 6:09:pm</p>
								</div>
								<div class="clearfix"> </div>
							</div>
							<div class="comments-text wow fadeInUp animated" data-wow-delay=".5s">
								<div class="col-md-3 comments-left">
									<img src="images/t2.jpg" alt="" />
								</div>
								<div class="col-md-9 comments-right">
									<h5>Admin</h5>
									<a href="#">Phasellus sem leointerdum risus</a> 
									<p>March 16,2016 6:09:pm</p>
								</div>
								<div class="clearfix"> </div>
							</div>
							<div class="comments-text wow fadeInUp animated" data-wow-delay=".5s">
								<div class="col-md-3 comments-left">
									<img src="images/t3.jpg" alt="" />
								</div>
								<div class="col-md-9 comments-right">
									<h5>Admin</h5>
									<a href="#">Phasellus sem leointerdum risus</a> 
									<p>March 16,2016 6:09:pm</p>
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
					</div>
					<div class="clearfix"> </div>
				</div>
*/

?>
			
		</div>
		<!-- //container -->
	</div>
	<!-- //blog -->
	
<? include_once('footer.php'); ?>