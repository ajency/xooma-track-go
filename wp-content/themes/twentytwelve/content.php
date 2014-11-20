<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header ">
				<h1 class="entry-title category_header"><?php the_title(); ?></h1>
			<?php 
				$img = array();
				if(has_post_thumbnail(get_the_ID()))
				{
					$img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()));
				}	
				else
				{
					$user_db_id = get_user_meta(get_the_author_ID(),'fb_id',true);
					$img[0] = "https://graph.facebook.com/$user_db_id/picture?width=150&height=150";
				}
			?>
			<img src="<?php echo $img[0]; ?>" width="150" height="150" style=" float: left; margin-right: 8px; "/>
			
			<?php $cats = get_the_category($testimonial->ID);
			
			$product = $testimony = $country;
			foreach($cats as $cat)
			{
				$link = site_url('app?cat=' . $cat->term_id . '&cat_name='. $cat->cat_name); 
			
				if($cat->parent == 25)
				{
					$testimony .= '<a href="'.$link.'">'. $cat->name .'</a></span>, ';
				}
				if($cat->parent == 2)
				{
					$product .= '<a href="'.$link.'">'. $cat->name .'</a></span>, ';
				}
				if($cat->parent == 48)
				{
					$country = '<a href="'.$link.'">'. $cat->name .'</a></span>';
				}	
			}
			
			//show categories
			?>
			<span class="user_desc">Country: <?php echo $country; ?>
			<br /><span class="user_desc">Product: <?php echo rtrim($product,', '); ?>
			<br /><span class="user_desc">Testimony: <?php echo rtrim($testimony,', '); ?>
			<div class="share_btn" style=" width: 65%; float: left; padding: 5px; "><div class="fb-like" data-href="<?php echo get_permalink() ?>" data-send="false" data-layout="standard" data-width="50" data-show-faces="false" data-colorscheme="light" data-action="like"></div>
			<a href="http://www.facebook.com/share.php?u=<?php echo get_permalink() ?>&app_id=101968866648981" onClick="return fbs_click(500, 200);" target="_blank" title="Share This on Facebook"><img src="<?php echo get_template_directory_uri() ?>/images/facebook3.png" alt="facebook share" width="64" height="24"></a></div>
			<?php if ( is_single() ) : ?>
		
			<?php else : ?>
			<!--<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>-->
			<?php endif; // is_single() ?>
		</header><!-- .entry-header -->
		<div class="entry_desc" style=" clear: both; margin-top:64px;color:#999;">
			<?php echo the_content(); ?><br />
			
		</div>
		<footer class="entry-meta">
			<?php if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries. ?>
				<div class="author-info">
					<div class="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentytwelve_author_bio_avatar_size', 68 ) ); ?>
					</div><!-- .author-avatar -->
					<div class="author-description">
						<h2><?php printf( __( 'About %s', 'twentytwelve' ), get_the_author() ); ?></h2>
						<p><?php the_author_meta( 'description' ); ?></p>
						<div class="author-link">
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
								<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentytwelve' ), get_the_author() ); ?>
							</a>
						</div><!-- .author-link	-->
					</div><!-- .author-description -->
				</div><!-- .author-info -->
			<?php endif; ?>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
