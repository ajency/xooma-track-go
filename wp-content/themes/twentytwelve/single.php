<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div class="container">
					<div class="row-fluid">
				<div class="main-area span8">
					<div class="page-header">
						<h1>JOIN OUR FAMILY OF ENTHUSIASTIC MEMBERS</h1>
						<p>
							The fact that you're here tells us you're one of the millions of people in the world today looking for better health, more financial security, or a combination of both.
							</br>
							Below, you will discover REAL people from around the world and their stories of REAL results.
						</p>
					</div>
					<div id="category-filters">
						
					</div>
					<div style="clear:both"></div>
		<div id="holder">
			<nav class="nav-single" style=" width: 500px; ">
				<!--	<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>-->
					<span style="border-right: 1px dotted #7E7E7E;margin-right: 5px;"><a href="<?php echo site_url(); ?>"><i class="icon-home" style=" margin-right: 4px;"></i></a></span>
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title' ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>' ); ?></span>
				</nav><!-- .nav-single -->
					<div id="content" role="main">

					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
					
	</div>	
				</div>
				<div class="sidebar span4">
					<div id="logo">
						<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" title="Xooma Worldwide" alt="Xooma Worldwide" />
					</div>
					<div id="search">
						<form class="form-search" action="<?php echo get_bloginfo('url');?>" method="post">
							<div class="input-append">
								<input type="text" class="search-query"  id="search-query" name="search-query" placeholder="Search..." value="">
								<button type="submit" class="btn"><i class="icon-search"></i></button>
							</div>
						</form>
					</div>
					<div class="share_btn">
					<button class="btn btn-info" type="button" href="#myModal" data-toggle="modal" style=" margin-left: 15px; " > <i class="icon-pencil icon-white"></i> &nbsp;Share Your Story</button>
					</div>
					
					<div id="filters">
						<h3>Categories</h3>

						<?php 
						//get all categories
						$categories = get_categories('parent=0&hide_empty=0');
						
						
						foreach($categories as $category):
						
						if($category->cat_name == 'Uncategorized')
							continue;
						?>
						<div class="single-filter">
							<div href="#" class="filter-toggle" data-toggle="collapse" data-target="#<?php echo $category->slug; ?>">
								<?php echo $category->cat_name; ?>
							</div>
							<div id="<?php echo $category->slug; ?>" class="collapse">
								<ul>
								<?php $sub_categories = get_categories('parent='.$category->term_id); ?>
								<?php foreach($sub_categories as $sub_cat): ?> 
									<li><a id="xm_cat_<?php echo $sub_cat->term_id; ?>" href="<?php echo site_url('app?cat=' . $sub_cat->term_id . '&cat_name='. $sub_cat->cat_name); ?>"><?php echo $sub_cat->cat_name; ?></a></li>
								<?php endforeach; ?>	
									
								</ul>
							</div>
						</div>
						<?php 
						
						endforeach;
						
						?>
					</div >
					<div class="xooma_imgs">
					<img src="<?php echo get_template_directory_uri(); ?>/images/XoomaBottleHighRes.jpg" title="Xooma Bottle" alt="Xooma Bottle" />
					</br>
					</div></br><img src="<?php echo get_template_directory_uri(); ?>/images/xooma_text.jpg" title="Xooma tag" alt="Xooma tag" />
				</div>
			</div> <!-- /row-fluid -->
	</div><!-- #primary -->
	</div>
	<?php /**
		<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h1 id="myModalLabel">Submit your testimonial</h3>
			</div>
			<div class="alert alert-info"> 
				<span> Login  </span>
				<img src="<?php echo get_template_directory_uri(); ?>/images/connect-facebook.png" title="Connect via facebook" alt="Facebook" id="connect-facebook"/>
				<span> to auto fill the below details</span>
			</div>
			<form action="" method="POST" id="submit-testimonial" enctype="multipart/form-data">	
				<div class="modal-body">
					<div class="row">
						<div class="span2 model-photo">
							<div class="fileupload fileupload-new" data-provides="fileupload">
							  <div class="fileupload-new thumbnail" style="width: 160px; height: 160px;">
									<img id="photo-preview" src="<?php echo get_template_directory_uri(); ?>/images/no-image.gif" />
							  </div>
							  <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 160px; max-height: 160px; line-height: 20px;"></div>
							  <div>
								<span class="btn btn-file btn-primary" style=" margin-left: 26px; ">
									<span class="fileupload-new  ">Select image</span>
									<span class="fileupload-exists">Change</span>
									<input type="file" name="profile_pic"/>
								</span>
								
							    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
								
							  </div>
							</div>
						</div>
						<div class="span4 model-box">						
							<div class="control-group">
								<label class="control-label" for="inputID">Xooma ID</label>
								<div class="controls">
								  <input type="text" id="inputID" placeholder="" name="xm_id"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputName">Name</label>
								<div class="controls">
								  <input type="text" id="inputName" placeholder="" name="xmname"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputEmail">Email</label>
								<div class="controls">
								  <input type="text" id="inputEmail" placeholder="" name="email"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputName">Country</label>
								<div class="controls">
								 	<select name="country" class="input-medium countries" style=" margin-left: -9px; "></select>
								</div>
							</div>
								<div class="control-group modal-control">
								<label class="control-label" for="inputName">Testimony</label>
								<div class="controls">
								 	<select name="ailment" class="input-medium Ailment"  style=" margin-left: -9px; ">
										<option value="">Choose...</option>
								 		<?php $sub_categories = get_categories('parent=142&hide_empty=0'); ?>
										<?php foreach($sub_categories as $sub_cat): ?> 
											<option value="<?php echo $sub_cat->term_id; ?>"><?php echo $sub_cat->cat_name; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="clear"></div>
							<div class="control-group">
								<label class="control-label" for="inputName">Product</label>
								<div class="controls">
								 	<select name="product" class="input-medium Product"  style=" margin-left: -9px; ">
										<option value="">Choose...</option>
								 		<?php $sub_categories = get_categories('parent=133&hide_empty=0'); ?>
										<?php foreach($sub_categories as $sub_cat): ?> 
											<option value="<?php echo $sub_cat->term_id; ?>"><?php echo $sub_cat->cat_name; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>	
					</div>
					
					<div class="row" style=" margin-top: 00px; ">
						<div class="span5">
							<div  class=" model-box">
						
							<div class="clear"></div>
							</div>
							<div class="control-group">
								<div class="controls">
								  <input type="checkbox" value="" id="vid_testimonial" /> Video testimonial?
								</div>
							</div>
							<div class="control-group" id="text-testimonial">
								<label class="control-label" for="inputEmail">Testimonial</label>
								<div class="controls">
								  <textarea rows="3" name="testimonial"></textarea>
								</div>
							</div>
							<div class="control-group" style="display:none" id="vid-testimonial">
								<label class="control-label" for="inputtestimonial">Video Testimonial</label>
								<div class="controls">
									<input type="url" name="video_testimonial" id="inputtestimonial" class="" placeholder="Enter youtube video URL"  style=" width: 106%; ">
								</div>
							</div>
						</div>
					</div>	
				</div>
				<input type="hidden" name="user_fb_id" value="" />
				<div class="modal-footer">
					<button class="btn btn-primary" type="submit">Submit</button>
					<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				</div>
			</form>		
		</div> */?>
<?php include_once('modal.php'); ?>
<?php get_footer(); ?>