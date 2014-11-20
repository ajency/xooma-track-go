<?php
/*
		Template Name: Xooma Xframe
*/
?>
<?php get_header('xframe');?>


		<div class="main-area">
					<div id="holder">
						<div id="spinner"  style="display:none;">
						  	<div class="spinner"></div>
						</div>
						<div id="photofy">
							<div class="grid-logo">
								<img src="<?php echo get_template_directory_uri(); ?>/images/grid-logo.png" title="Xooma Worldwide" alt="Xooma Worldwide" />
							</div>
							<div class="grid-like">
								<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fxoomaworldwide&amp;send=false&amp;layout=box_count&amp;width=55&amp;show_faces=false&amp;font=arial&amp;colorscheme=light&amp;action=like&amp;height=90&amp;appId=101968866648981" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:55px; height:90px;margin-top: 15px;
margin-left: 28px;" allowTransparency="true"></iframe>
							</div>
							<div class="grid-write">
								<a href="#myModal" data-toggle="modal" role="button" id="write-testimonial">
									<img src="<?php echo get_template_directory_uri(); ?>/images/grid-write.jpg" alt="Write" />
								</a>
							</div>
							<div style="clear:both"></div>
						</div>
						<div id="load_more_testimonial" class="btn btn-primary">Load More...</div>
					</div>	
		</div>

	
<?php get_footer('xframe');?>