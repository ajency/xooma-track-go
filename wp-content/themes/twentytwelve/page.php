<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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
		<div id="content" role="main">
<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
					
	</div>	
				</div>
				<div class="sidebar span4">
					<div id="logo">
						<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" title="Xooma Worldwide" alt="Xooma Worldwide" />
					</div>
					<div id="search">
						<form class="form-search">
							<div class="input-append">
								<input type="text" class="search-query" placeholder="Search...">
								<button type="submit" class="btn"><i class="icon-search"></i></button>
							</div>
						</form>
					</div>
					<?php /**
					<div class="share_btn">
					<button class="btn btn-info" type="button" href="#myModal" data-toggle="modal" style=" margin-left: 15px; " > <i class="icon-pencil icon-white"></i> &nbsp;Share Your Story</button>
					</div>
					*/ ?>
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
							<a href="#" class="filter-toggle" data-toggle="collapse" data-target="#<?php echo $category->slug; ?>">
								<?php echo $category->cat_name; ?>
							</a>
							<div id="<?php echo $category->slug; ?>" class="collapse">
								<ul>
								<?php $sub_categories = get_categories('parent='.$category->term_id); ?>
								<?php foreach($sub_categories as $sub_cat): ?> 
									<li><a id="xm_cat_<?php echo $sub_cat->term_id; ?>" href="<?php echo site_url('xooma?cat=' . $sub_cat->term_id . '&cat_name='. $sub_cat->cat_name); ?>"><?php echo $sub_cat->cat_name; ?></a></li>
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
					</div>
				</div>
			</div> <!-- /row-fluid -->
	</div><!-- #primary -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>