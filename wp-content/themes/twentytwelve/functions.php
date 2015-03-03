<?php
/**
 * Twenty Twelve functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 625;

/**
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Twelve supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 * 	custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Twelve 1.0
 */

require_once 'xooma-functions.php';

function twentytwelve_setup() {
	/*
	 * Makes Twenty Twelve available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Twelve, use a find and replace
	 * to change 'twentytwelve' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentytwelve', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'twentytwelve' ) );

	/*
	 * This theme supports custom background color and image, and here
	 * we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );

	show_admin_bar(false );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
}
add_action( 'after_setup_theme', 'twentytwelve_setup' );

/**
 * Adds support for a custom header image.
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
*	Adds Custom functions
*/
require( get_template_directory() . '/inc/custom-function.php' );

#load all the classes
require_once (get_template_directory().'/vendor/autoload.php');



require_once (get_template_directory().'/parse-php-sdk/autoload.php');

use Parse\ParseClient;
 
ParseClient::initialize('7yCBpn4nUCUZMV31PSCNETE3bdzTF8kbx7ESGWJ1', 'wiISNnx0aKjpFKXyT2ZxEhWf4aVlBLqSleRWXN8o', 'MzPgucLWJU2mlPWpmCJHmI2c0JoVWPfPRqrbknCB');


use Parse\ParseCloud;

require_once (get_template_directory().'/vendor/vlucas/valitron/src/Valitron/Validator.php');
require_once (get_template_directory().'/classes/product.class.php');
require_once (get_template_directory().'/classes/productList.class.php');
require_once (get_template_directory().'/classes/setting.class.php');
require_once (get_template_directory().'/classes/user.class.php');
require_once (get_template_directory().'/functions/functions.php');
require_once (get_template_directory().'/functions/Carbon.php');

use Carbon\Carbon;

#load all the classes


#load all the apis
require_once (get_template_directory().'/api/class.product.api.php');
require_once (get_template_directory().'/api/class.user.api.php');
#load all the apis
//parse









//$result = ParseCloud::run('sendPushByUserId', ['usersToBeNotified' => $usersToBeNotified] );



//parse

/**
 * Enqueues scripts and styles for front-end.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/*
	 * Adds JavaScript for handling the navigation menu hide-and-show behavior.
	 */
	wp_enqueue_script( 'twentytwelve-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0', true );

	/*
	 * Loads our special font CSS file.
	 *
	 * The use of Open Sans by default is localized. For languages that use
	 * characters not supported by the font, the font can be disabled.
	 *
	 * To disable in a child theme, use wp_dequeue_style()
	 * function mytheme_dequeue_fonts() {
	 *     wp_dequeue_style( 'twentytwelve-fonts' );
	 * }
	 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
	 */

	/* translators: If there are characters in your language that are not supported
	   by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'twentytwelve' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language, translate
		   this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'twentytwelve' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:400italic,700italic,400,700',
			'subset' => $subsets,
		);
		wp_enqueue_style( 'twentytwelve-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'twentytwelve-style', get_stylesheet_uri() );

	/*
	 * Loads the Internet Explorer specific stylesheet.
	 */
	wp_enqueue_style( 'twentytwelve-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentytwelve-style' ), '20121010' );
	$wp_styles->add_data( 'twentytwelve-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'twentytwelve_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Twenty Twelve 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function twentytwelve_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'twentytwelve_wp_title', 10, 2 );

/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentytwelve_page_menu_args' );

/**
 * Registers our main widget area and the front page widget areas.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'twentytwelve' ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'First Front Page Widget Area', 'twentytwelve' ),
		'id' => 'sidebar-2',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Second Front Page Widget Area', 'twentytwelve' ),
		'id' => 'sidebar-3',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'twentytwelve_widgets_init' );

if ( ! function_exists( 'twentytwelve_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
			<div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentytwelve' ) ); ?></div>
			<div class="nav-next alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
endif;

if ( ! function_exists( 'twentytwelve_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentytwelve_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'twentytwelve' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'twentytwelve' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'twentytwelve' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentytwelve' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'twentytwelve' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'twentytwelve' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'twentytwelve_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own twentytwelve_entry_meta() to override in a child theme.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ' ', 'twentytwelve' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'twentytwelve' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'twentytwelve' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( ' <span class="single_country">%1$s </span> and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
	} elseif ( $categories_list ) {
		$utility_text = __( '<span class="single_country">%1$s </span>  ' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;

/**
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 *
 * @since Twenty Twelve 1.0
 *
 * @param array Existing class values.
 * @return array Filtered class values.
 */
function twentytwelve_body_class( $classes ) {
	$background_color = get_background_color();

	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/full-width.php' ) )
		$classes[] = 'full-width';

	if ( is_page_template( 'page-templates/front-page.php' ) ) {
		$classes[] = 'template-front-page';
		if ( has_post_thumbnail() )
			$classes[] = 'has-post-thumbnail';
		if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
			$classes[] = 'two-sidebars';
	}

	if ( empty( $background_color ) )
		$classes[] = 'custom-background-empty';
	elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) )
		$classes[] = 'custom-background-white';

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'twentytwelve-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';

	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	return $classes;
}
add_filter( 'body_class', 'twentytwelve_body_class' );

/**
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_content_width() {
	if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'twentytwelve_content_width' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since Twenty Twelve 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function twentytwelve_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'twentytwelve_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_customize_preview_js() {
	wp_enqueue_script( 'twentytwelve-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20120827', true );
}
add_action( 'customize_preview_init', 'twentytwelve_customize_preview_js' );




function xm_get_testimonials()
{

	$args = array();

	if(isset($_POST['current_ids']) && is_array($_POST['current_ids']))
	{
		$args['post__not_in'] = $_POST['current_ids'];
	}

	if(isset($_POST['cat_ids']) && is_array($_POST['cat_ids']))
	{
		//get teh category ids to filter
		$_cat_ids = $_POST['cat_ids'];

		if(!empty($_cat_ids))
		{
			$args['category__and'] = $_cat_ids;
		}
	}
	if(isset($_POST['search_text']))
	{
		if(!empty($_POST['search_text']))
		{
			//$search_filter = '&s=' . $_POST['search_text'] ;
			$args['s'] = $_POST['search_text'];

			$_args = array(
				'role' => '',
				'search' => 'Enter',
				'fields' => 'ID'
			);

			if ( '' !== $_args['search'] )
				$_args['search'] = '*' . $_args['search'] . '*';

			// Query the user IDs of the Auhtors
			$wp_user_search = new WP_User_Query( $_args );
			$args['author'] = $wp_user_search->get_results();
		}
	}

	$args['post_status'] 	= 'publish';
	$args['orderby'] 		= 'rand';
	$args['posts_per_page'] = 46;
	$args['post_type'] 		= 'post';

	if(isset($_POST['is_business']) && $_POST['is_business'] == 1)
		$args['tag_id'] = 80;
	else
		$args['tag__not_in'] = 80;

	//$testimonials = query_posts('post_status=publish&orderby=rand&posts_per_page=21&post_type=post' .  $cat_filter );
	$testimonials = query_posts($args);

	$data = array();

	$ids = array();

	if(count($testimonials) > 0)
	{
		foreach($testimonials as $testimonial):

			//add current ids
			$ids[] = $testimonial->ID;

			$cats = get_the_category($testimonial->ID);

			$user = get_userdata((int)$testimonial->post_author);

			$ailment = $product = $country = '';

			foreach($cats as $cat)
			{
				$link = site_url('app?cat=' . $cat->term_id . '&cat_name='. $cat->cat_name);

				if($cat->parent == 25)
				{
					$ailment .= "<a href='$link'>{$cat->name}</a>, ";
				}
				if($cat->parent == 2)
				{
					$product .= "<a href='$link'>{$cat->name}</a>, ";
				}
				if($cat->parent == 48)
				{
					$country = "<a href='$link'>{$cat->name}</a>";
				}
			}

			$img = array();
			if(has_post_thumbnail($testimonial->ID))
			{
				$img = wp_get_attachment_image_src(get_post_thumbnail_id($testimonial->ID));
			}
			else
			{
				$user_db_id = get_user_meta($user->ID,'fb_id',true);
				$img[0] = "https://graph.facebook.com/$user_db_id/picture?width=150&height=150";
			}

			$content = $testimonial->post_content;

			$product_ailment = '';
			if(!empty($product) && !empty($ailment))
				$product_ailment = 'Product</br> <span> '. rtrim($product,', ') .' </span>Testimony</br> <span> '. rtrim($ailment,', ') . '</span>';

			$data[] = array('ImageUrl' => $img[0],
							'LinkUrl'  => $img[0],
							'HTML' 	   => '<div class=\'facebook_button\' style=\'   margin-left: -174PX; position: absolute; z-index: 99999; margin-top: 168px;  \'></div><span><a href=\'' . get_permalink($testimonial->ID) .'\'><h4 class=\'testimonialTitle\'>'. $testimonial->post_title .'</h4></a></span>Country</br> <span> '. $country . '</span>'.$product_ailment.'<div class=\'slickscroll\'>'. $content .'<br /><a href=\'' . get_permalink($testimonial->ID) .'\'>Complete View</a></div>',
							'Href' => get_permalink($testimonial->ID)
					);
		endforeach;
	}

	echo json_encode(array('data' => $data,'ids' => $ids));

	die;
}

add_action('wp_ajax_xm_get_testimonials','xm_get_testimonials');
add_action('wp_ajax_nopriv_xm_get_testimonials','xm_get_testimonials');

function xm_register_user()
{
	if ($_REQUEST) {
		echo '<p>signed_request contents:</p>';
		$response = parse_signed_request($_REQUEST['signed_request'], FACEBOOK_SECRET);
		echo '<pre>';
		print_r($_REQUEST);
		echo '</pre>';
	}
	else {
		echo '$_REQUEST is empty';
	}

	die;
}

add_action('wp_ajax_xm_register_user','xm_register_user');
add_action('wp_ajax_nopriv_xm_register_user','xm_register_user');



function xm_submit_testimonial()
{
	$data = array();
	wp_parse_str($_POST['user_info'],$data);

	echo json_encode(array($data['email']));

	die;

	if(!email_exists($data['email']))
	{
		$user_id  = wp_insert_user(array(
					'user_login' 	=> 'xm_user_' . rand(15485,98745),
					'user_email' 	=> $data['email'],
					'user_pass' 	=> md5('xoomauser'),
					'first_name' 	=> $data['name']
			));
	}

	echo json_encode(array($data,$user_id));

	die;
}
add_action('wp_ajax_xm_submit_testimonial','xm_submit_testimonial');
add_action('wp_ajax_nopriv_xm_submit_testimonial','xm_submit_testimonial');



define('FACEBOOK_APP_ID', '	456682467712905');
define('FACEBOOK_SECRET', '72c7697cb0b414c5018abbbe85b64eb7');

function parse_signed_request($signed_request, $secret) {
  list($encoded_sig, $payload) = explode('.', $signed_request, 2);

  // decode the data
  $sig = base64_url_decode($encoded_sig);
  $data = json_decode(base64_url_decode($payload), true);

  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
    error_log('Unknown algorithm. Expected HMAC-SHA256');
    return null;
  }

  // check sig
  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
  if ($sig !== $expected_sig) {
    error_log('Bad Signed JSON signature!');
    return null;
  }

  return $data;
}

function base64_url_decode($input) {
    return base64_decode(strtr($input, '-_', '+/'));
}



function country_code_to_country( $code ){
	$country = '';
	if( $code == 'AF' ) $country = 'Afghanistan';
	if( $code == 'AX' ) $country = 'Aland Islands';
	if( $code == 'AL' ) $country = 'Albania';
	if( $code == 'DZ' ) $country = 'Algeria';
	if( $code == 'AS' ) $country = 'American Samoa';
	if( $code == 'AD' ) $country = 'Andorra';
	if( $code == 'AO' ) $country = 'Angola';
	if( $code == 'AI' ) $country = 'Anguilla';
	if( $code == 'AQ' ) $country = 'Antarctica';
	if( $code == 'AG' ) $country = 'Antigua and Barbuda';
	if( $code == 'AR' ) $country = 'Argentina';
	if( $code == 'AM' ) $country = 'Armenia';
	if( $code == 'AW' ) $country = 'Aruba';
	if( $code == 'AU' ) $country = 'Australia';
	if( $code == 'AT' ) $country = 'Austria';
	if( $code == 'AZ' ) $country = 'Azerbaijan';
	if( $code == 'BS' ) $country = 'Bahamas the';
	if( $code == 'BH' ) $country = 'Bahrain';
	if( $code == 'BD' ) $country = 'Bangladesh';
	if( $code == 'BB' ) $country = 'Barbados';
	if( $code == 'BY' ) $country = 'Belarus';
	if( $code == 'BE' ) $country = 'Belgium';
	if( $code == 'BZ' ) $country = 'Belize';
	if( $code == 'BJ' ) $country = 'Benin';
	if( $code == 'BM' ) $country = 'Bermuda';
	if( $code == 'BT' ) $country = 'Bhutan';
	if( $code == 'BO' ) $country = 'Bolivia';
	if( $code == 'BA' ) $country = 'Bosnia and Herzegovina';
	if( $code == 'BW' ) $country = 'Botswana';
	if( $code == 'BV' ) $country = 'Bouvet Island';
	if( $code == 'BR' ) $country = 'Brazil';
	if( $code == 'IO' ) $country = 'British Indian Ocean Territory';
	if( $code == 'VG' ) $country = 'British Virgin Islands';
	if( $code == 'BN' ) $country = 'Brunei Darussalam';
	if( $code == 'BG' ) $country = 'Bulgaria';
	if( $code == 'BF' ) $country = 'Burkina Faso';
	if( $code == 'BI' ) $country = 'Burundi';
	if( $code == 'KH' ) $country = 'Cambodia';
	if( $code == 'CM' ) $country = 'Cameroon';
	if( $code == 'CA' ) $country = 'Canada';
	if( $code == 'CV' ) $country = 'Cape Verde';
	if( $code == 'KY' ) $country = 'Cayman Islands';
	if( $code == 'CF' ) $country = 'Central African Republic';
	if( $code == 'TD' ) $country = 'Chad';
	if( $code == 'CL' ) $country = 'Chile';
	if( $code == 'CN' ) $country = 'China';
	if( $code == 'CX' ) $country = 'Christmas Island';
	if( $code == 'CC' ) $country = 'Cocos (Keeling) Islands';
	if( $code == 'CO' ) $country = 'Colombia';
	if( $code == 'KM' ) $country = 'Comoros the';
	if( $code == 'CD' ) $country = 'Congo';
	if( $code == 'CG' ) $country = 'Congo the';
	if( $code == 'CK' ) $country = 'Cook Islands';
	if( $code == 'CR' ) $country = 'Costa Rica';
	if( $code == 'CI' ) $country = 'Cote d\'Ivoire';
	if( $code == 'HR' ) $country = 'Croatia';
	if( $code == 'CU' ) $country = 'Cuba';
	if( $code == 'CY' ) $country = 'Cyprus';
	if( $code == 'CZ' ) $country = 'Czech Republic';
	if( $code == 'DK' ) $country = 'Denmark';
	if( $code == 'DJ' ) $country = 'Djibouti';
	if( $code == 'DM' ) $country = 'Dominica';
	if( $code == 'DO' ) $country = 'Dominican Republic';
	if( $code == 'EC' ) $country = 'Ecuador';
	if( $code == 'EG' ) $country = 'Egypt';
	if( $code == 'SV' ) $country = 'El Salvador';
	if( $code == 'GQ' ) $country = 'Equatorial Guinea';
	if( $code == 'ER' ) $country = 'Eritrea';
	if( $code == 'EE' ) $country = 'Estonia';
	if( $code == 'ET' ) $country = 'Ethiopia';
	if( $code == 'FO' ) $country = 'Faroe Islands';
	if( $code == 'FK' ) $country = 'Falkland Islands';
	if( $code == 'FJ' ) $country = 'Fiji the Fiji Islands';
	if( $code == 'FI' ) $country = 'Finland';
	if( $code == 'FR' ) $country = 'France, French Republic';
	if( $code == 'GF' ) $country = 'French Guiana';
	if( $code == 'PF' ) $country = 'French Polynesia';
	if( $code == 'TF' ) $country = 'French Southern Territories';
	if( $code == 'GA' ) $country = 'Gabon';
	if( $code == 'GM' ) $country = 'Gambia the';
	if( $code == 'GE' ) $country = 'Georgia';
	if( $code == 'DE' ) $country = 'Germany';
	if( $code == 'GH' ) $country = 'Ghana';
	if( $code == 'GI' ) $country = 'Gibraltar';
	if( $code == 'GR' ) $country = 'Greece';
	if( $code == 'GL' ) $country = 'Greenland';
	if( $code == 'GD' ) $country = 'Grenada';
	if( $code == 'GP' ) $country = 'Guadeloupe';
	if( $code == 'GU' ) $country = 'Guam';
	if( $code == 'GT' ) $country = 'Guatemala';
	if( $code == 'GG' ) $country = 'Guernsey';
	if( $code == 'GN' ) $country = 'Guinea';
	if( $code == 'GW' ) $country = 'Guinea-Bissau';
	if( $code == 'GY' ) $country = 'Guyana';
	if( $code == 'HT' ) $country = 'Haiti';
	if( $code == 'HM' ) $country = 'Heard Island and McDonald Islands';
	if( $code == 'VA' ) $country = 'Holy See';
	if( $code == 'HN' ) $country = 'Honduras';
	if( $code == 'HK' ) $country = 'Hong Kong';
	if( $code == 'HU' ) $country = 'Hungary';
	if( $code == 'IS' ) $country = 'Iceland';
	if( $code == 'IN' ) $country = 'India';
	if( $code == 'ID' ) $country = 'Indonesia';
	if( $code == 'IR' ) $country = 'Iran';
	if( $code == 'IQ' ) $country = 'Iraq';
	if( $code == 'IE' ) $country = 'Ireland';
	if( $code == 'IM' ) $country = 'Isle of Man';
	if( $code == 'IL' ) $country = 'Israel';
	if( $code == 'IT' ) $country = 'Italy';
	if( $code == 'JM' ) $country = 'Jamaica';
	if( $code == 'JP' ) $country = 'Japan';
	if( $code == 'JE' ) $country = 'Jersey';
	if( $code == 'JO' ) $country = 'Jordan';
	if( $code == 'KZ' ) $country = 'Kazakhstan';
	if( $code == 'KE' ) $country = 'Kenya';
	if( $code == 'KI' ) $country = 'Kiribati';
	if( $code == 'KP' ) $country = 'Korea';
	if( $code == 'KR' ) $country = 'Korea';
	if( $code == 'KW' ) $country = 'Kuwait';
	if( $code == 'KG' ) $country = 'Kyrgyz Republic';
	if( $code == 'LA' ) $country = 'Lao';
	if( $code == 'LV' ) $country = 'Latvia';
	if( $code == 'LB' ) $country = 'Lebanon';
	if( $code == 'LS' ) $country = 'Lesotho';
	if( $code == 'LR' ) $country = 'Liberia';
	if( $code == 'LY' ) $country = 'Libyan Arab Jamahiriya';
	if( $code == 'LI' ) $country = 'Liechtenstein';
	if( $code == 'LT' ) $country = 'Lithuania';
	if( $code == 'LU' ) $country = 'Luxembourg';
	if( $code == 'MO' ) $country = 'Macao';
	if( $code == 'MK' ) $country = 'Macedonia';
	if( $code == 'MG' ) $country = 'Madagascar';
	if( $code == 'MW' ) $country = 'Malawi';
	if( $code == 'MY' ) $country = 'Malaysia';
	if( $code == 'MV' ) $country = 'Maldives';
	if( $code == 'ML' ) $country = 'Mali';
	if( $code == 'MT' ) $country = 'Malta';
	if( $code == 'MH' ) $country = 'Marshall Islands';
	if( $code == 'MQ' ) $country = 'Martinique';
	if( $code == 'MR' ) $country = 'Mauritania';
	if( $code == 'MU' ) $country = 'Mauritius';
	if( $code == 'YT' ) $country = 'Mayotte';
	if( $code == 'MX' ) $country = 'Mexico';
	if( $code == 'FM' ) $country = 'Micronesia';
	if( $code == 'MD' ) $country = 'Moldova';
	if( $code == 'MC' ) $country = 'Monaco';
	if( $code == 'MN' ) $country = 'Mongolia';
	if( $code == 'ME' ) $country = 'Montenegro';
	if( $code == 'MS' ) $country = 'Montserrat';
	if( $code == 'MA' ) $country = 'Morocco';
	if( $code == 'MZ' ) $country = 'Mozambique';
	if( $code == 'MM' ) $country = 'Myanmar';
	if( $code == 'NA' ) $country = 'Namibia';
	if( $code == 'NR' ) $country = 'Nauru';
	if( $code == 'NP' ) $country = 'Nepal';
	if( $code == 'AN' ) $country = 'Netherlands Antilles';
	if( $code == 'NL' ) $country = 'Netherlands the';
	if( $code == 'NC' ) $country = 'New Caledonia';
	if( $code == 'NZ' ) $country = 'New Zealand';
	if( $code == 'NI' ) $country = 'Nicaragua';
	if( $code == 'NE' ) $country = 'Niger';
	if( $code == 'NG' ) $country = 'Nigeria';
	if( $code == 'NU' ) $country = 'Niue';
	if( $code == 'NF' ) $country = 'Norfolk Island';
	if( $code == 'MP' ) $country = 'Northern Mariana Islands';
	if( $code == 'NO' ) $country = 'Norway';
	if( $code == 'OM' ) $country = 'Oman';
	if( $code == 'PK' ) $country = 'Pakistan';
	if( $code == 'PW' ) $country = 'Palau';
	if( $code == 'PS' ) $country = 'Palestinian Territory';
	if( $code == 'PA' ) $country = 'Panama';
	if( $code == 'PG' ) $country = 'Papua New Guinea';
	if( $code == 'PY' ) $country = 'Paraguay';
	if( $code == 'PE' ) $country = 'Peru';
	if( $code == 'PH' ) $country = 'Philippines';
	if( $code == 'PN' ) $country = 'Pitcairn Islands';
	if( $code == 'PL' ) $country = 'Poland';
	if( $code == 'PT' ) $country = 'Portugal, Portuguese Republic';
	if( $code == 'PR' ) $country = 'Puerto Rico';
	if( $code == 'QA' ) $country = 'Qatar';
	if( $code == 'RE' ) $country = 'Reunion';
	if( $code == 'RO' ) $country = 'Romania';
	if( $code == 'RU' ) $country = 'Russian Federation';
	if( $code == 'RW' ) $country = 'Rwanda';
	if( $code == 'BL' ) $country = 'Saint Barthelemy';
	if( $code == 'SH' ) $country = 'Saint Helena';
	if( $code == 'KN' ) $country = 'Saint Kitts and Nevis';
	if( $code == 'LC' ) $country = 'Saint Lucia';
	if( $code == 'MF' ) $country = 'Saint Martin';
	if( $code == 'PM' ) $country = 'Saint Pierre and Miquelon';
	if( $code == 'VC' ) $country = 'Saint Vincent and the Grenadines';
	if( $code == 'WS' ) $country = 'Samoa';
	if( $code == 'SM' ) $country = 'San Marino';
	if( $code == 'ST' ) $country = 'Sao Tome and Principe';
	if( $code == 'SA' ) $country = 'Saudi Arabia';
	if( $code == 'SN' ) $country = 'Senegal';
	if( $code == 'RS' ) $country = 'Serbia';
	if( $code == 'SC' ) $country = 'Seychelles';
	if( $code == 'SL' ) $country = 'Sierra Leone';
	if( $code == 'SG' ) $country = 'Singapore';
	if( $code == 'SK' ) $country = 'Slovakia';
	if( $code == 'SI' ) $country = 'Slovenia';
	if( $code == 'SB' ) $country = 'Solomon Islands';
	if( $code == 'SO' ) $country = 'Somalia, Somali Republic';
	if( $code == 'ZA' ) $country = 'South Africa';
	if( $code == 'GS' ) $country = 'South Georgia and the South Sandwich Islands';
	if( $code == 'ES' ) $country = 'Spain';
	if( $code == 'LK' ) $country = 'Sri Lanka';
	if( $code == 'SD' ) $country = 'Sudan';
	if( $code == 'SR' ) $country = 'Suriname';
	if( $code == 'SJ' ) $country = 'Svalbard & Jan Mayen Islands';
	if( $code == 'SZ' ) $country = 'Swaziland';
	if( $code == 'SE' ) $country = 'Sweden';
	if( $code == 'CH' ) $country = 'Switzerland, Swiss Confederation';
	if( $code == 'SY' ) $country = 'Syrian Arab Republic';
	if( $code == 'TW' ) $country = 'Taiwan';
	if( $code == 'TJ' ) $country = 'Tajikistan';
	if( $code == 'TZ' ) $country = 'Tanzania';
	if( $code == 'TH' ) $country = 'Thailand';
	if( $code == 'TL' ) $country = 'Timor-Leste';
	if( $code == 'TG' ) $country = 'Togo';
	if( $code == 'TK' ) $country = 'Tokelau';
	if( $code == 'TO' ) $country = 'Tonga';
	if( $code == 'TT' ) $country = 'Trinidad and Tobago';
	if( $code == 'TN' ) $country = 'Tunisia';
	if( $code == 'TR' ) $country = 'Turkey';
	if( $code == 'TM' ) $country = 'Turkmenistan';
	if( $code == 'TC' ) $country = 'Turks and Caicos Islands';
	if( $code == 'TV' ) $country = 'Tuvalu';
	if( $code == 'UG' ) $country = 'Uganda';
	if( $code == 'UA' ) $country = 'Ukraine';
	if( $code == 'AE' ) $country = 'United Arab Emirates';
	if( $code == 'GB' ) $country = 'United Kingdom';
	if( $code == 'US' ) $country = 'United States of America';
	if( $code == 'UM' ) $country = 'United States Minor Outlying Islands';
	if( $code == 'VI' ) $country = 'United States Virgin Islands';
	if( $code == 'UY' ) $country = 'Uruguay, Eastern Republic of';
	if( $code == 'UZ' ) $country = 'Uzbekistan';
	if( $code == 'VU' ) $country = 'Vanuatu';
	if( $code == 'VE' ) $country = 'Venezuela';
	if( $code == 'VN' ) $country = 'Vietnam';
	if( $code == 'WF' ) $country = 'Wallis and Futuna';
	if( $code == 'EH' ) $country = 'Western Sahara';
	if( $code == 'YE' ) $country = 'Yemen';
	if( $code == 'ZM' ) $country = 'Zambia';
	if( $code == 'ZW' ) $country = 'Zimbabwe';
	if( $country == '') $country = $code;
	return $country;
}


function upload_gallery_attachment($file_handler,$post_id,$setthumb='false') {

	// check to make sure its a successful upload
	if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK)
		__return_false();

	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');

	$attach_id = media_handle_upload( $file_handler, $post_id );

	if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
	return $attach_id;
}


function parse_yturl($url)
{
    $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
    preg_match($pattern, $url, $matches);
    return (isset($matches[1])) ? $matches[1] : false;
}

function remove_line_breaks($content)
{
	$output = str_replace(array("\r\n", "\r"), "\n", $content);
	$lines = explode("\n", $output);
	$new_lines = array();

	foreach ($lines as $i => $line) {
		if(!empty($line))
		$new_lines[] = trim($line);
	}

return implode($new_lines);
}


function xm_notify_author($post)
{
	$author = get_userdata($post->post_author);

	$name = $author->user_firstname;

	$message = "Dear $name,<br /><p>Thank you again for sharing your Xooma testimonial. Your testimonial has been approved and is now on display to share with others. You can see your testimonial by clicking the link below<br /><a href='". get_permalink($post->ID) ."'>". get_permalink($post->ID) ."</a></p><p>To your success,<br />Xooma Worldwide.<p>";

	add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
	wp_mail($author->user_email,'Testimonial approved on Xooma', $message);
}

add_action('pending_to_publish','xm_notify_author',10,1);


function string_sanitize($s) {
    $result = html_entity_decode($s);
    return $result;
}

/**
 * funtion to return all email addresses for administrators for site
 *
 *  */
function get_all_admin_email_ids()
{
	$emails = array();
	$admins = get_users(array('role' => 'administrator'));
	foreach($admins as $admin)
	{
		$emails[] = $admin->user_email;
	}

	if(count($emails) > 0)
		return $emails;

	return array(get_option('admin_email'));
}



//Lets add Open Graph Meta Info

function add_facebook_open_graph_tags() {

global $post;
if(!isset($post->ID)){
	return;
}
if(has_post_thumbnail($post->ID))
{
	$img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID));
}
else
{
	$user_db_id = get_user_meta($post->post_author,'fb_id',true);
	$img[0] = "https://graph.facebook.com/$user_db_id/picture?width=150&height=150";
}

?>
<meta property="og:title" content="<?php echo $post->post_title; ?>" />
<meta property="og:type" content="article" />
<meta property="og:image" content="<?php echo $img[0] ; ?>" />
<meta property="og:url" content="<?php echo get_permalink($testimonial->ID); ?>" />
<meta property="og:description" content="<?php echo get_the_content($testimonial->post_content); ?>" />
<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>" />

<meta property="fb:admins" content="101968866648981" />
<?php // }
}

add_action('xooma_fb_tags', 'add_facebook_open_graph_tags',99);

//code added by Surekha
#load all the custom scripts

function load_scripts(){
        wp_enqueue_script( "jquery",
                        get_template_directory_uri() . "/js/jquery.js",
                        array(),
                        get_current_version(),
                        TRUE );
        wp_enqueue_script( "validate",
                        get_template_directory_uri() . "/js/jquery.validate.js",
                        array(),
                        get_current_version(),
                        TRUE );
        wp_enqueue_script( "plupload_script",
                        get_template_directory_uri() . "/js/plupload.full.js",
                        array(),
                        get_current_version(),
                        TRUE );
       wp_enqueue_script( "product_script",
                        get_template_directory_uri() . "/js/product.js",
                        array(),
                        get_current_version(),
                        TRUE );



}
add_action('admin_enqueue_scripts' , 'load_scripts');

#load all the custom scripts

function get_current_version() {

    global $wp_version;

    if ( defined( 'VERSION' ) )
        return VERSION;

    return $wp_version;
}
if ( is_development_environment() ) {

    function xooma_dev_enqueue_scripts() {

             // localized variables

        wp_enqueue_media();
        wp_localize_script(  "product_script", "SITEURL", site_url() );
        wp_localize_script(  "product_script", "AJAXURL", admin_url( "admin-ajax.php" ) );
        wp_localize_script(  "product_script", "ajaxurl", admin_url( "admin-ajax.php" ) );
        wp_localize_script(  "product_script", "UPLOADURL", admin_url( "async-upload.php" ) );
        wp_localize_script(  "product_script", "_WPNONCE", wp_create_nonce( 'media-form' ) );




    }

        add_action( 'wp_enqueue_scripts', 'xooma_dev_enqueue_scripts' );
        #action hook into the admin section scripts
        add_action( 'admin_enqueue_scripts', 'xooma_dev_enqueue_scripts' );







}

if (! is_development_environment() ) {

    function xooma_production_enqueue_script() {

    		wp_enqueue_media();
            wp_localize_script( "product_script", "SITEURL", site_url() );
            wp_localize_script(  "product_script", "AJAXURL", admin_url( "admin-ajax.php" ) );
            wp_localize_script(  "product_script", "ajaxurl", admin_url( "admin-ajax.php" ) );
            wp_localize_script(  "product_script", "UPLOADURL", admin_url( "async-upload.php" ) );
            wp_localize_script(  "product_script", "_WPNONCE", wp_create_nonce( 'media-form' ) );

    }

       add_action( 'wp_enqueue_scripts', 'xooma_production_enqueue_script' );
       #action hook into the admin section scripts
       add_action( 'admin_enqueue_scripts', 'xooma_production_enqueue_script' );



}

function is_development_environment() {

    if ( defined( 'ENV' ) && ENV === "production" )
        return FALSE;

    return TRUE;
}

function register_menu() {
  add_menu_page( __( 'Add Product' ), __( 'Add Product' ),
    'manage_options', 'product_settings', 'set_product_settings');
  add_submenu_page( 'product_settings', 'Settings page title', 'Products',
    'manage_options', 'theme-op-settings', 'show_list_products');
  add_submenu_page( 'product_settings', 'Settings', 'Settings and Usage',
    'manage_options', 'theme-op-faq', 'settings');

}
add_action('admin_menu', 'register_menu');


function set_product_settings(){

    global $wpdb;
    $product_type_table = $wpdb->prefix . "defaults";
    $product_type_option = "";
    #get the values from product_type table

    $product_types = $wpdb->get_results( "SELECT * FROM $product_type_table where type='product_type'" );
    foreach ( $product_types as $product_type )
    {
        $product_type_option .= "<option value='".$product_type->id."'>".$product_type->value."</option>";
    }

?>

<html>
<h2>Add Product</h2>

<form id="add_product_form" enctype="multipart/form-data" method="POST">
<div id="response_msg" ></div>
<table class="widefat">
    <tbody>
        <tr>
            <td class="row-title"><label for="tablecell">Name</label></td>
            <td><input name="name" id="name" required type="text" value="" class="regular-text" /></td>
        </tr>
        <tr >
            <td class="row-title"><label for="tablecell">Active</label></td>
            <td><input name="active" type="checkbox" id="active" value="1"  checked /></td>
        </tr>
        <tr>
        	<td><label for="tablecell">Upload Image </label></td>
            <td>
                <a href="#" class="custom_media_upload">Upload</a>
                <img class="custom_media_image" src="" />
                <input class="custom_media_url" type="hidden" name="attachment_url" value="">
                <input class="custom_media_id" type="hidden" name="attachment_id" value=""></td>
        </tr>
        <tr>
            <td class="row-title"><label for="tablecell">Short Description</label></td>
            <td><textarea id="short_desc" required name="short_desc" cols="80" rows="10"></textarea></td>
        </tr>


        <tr >
            <td class="row-title"><label for="tablecell">Product Type</label></td>
            <td><select required  id="product_type" name="product_type">
                <option value=""></option>
                <?php echo $product_type_option ;?>
            </select></td>
        </tr>
        <tr >
            <td class="row-title"><label for="tablecell">Frequency</label></td>
            <td><label title='g:i a'>
            	<input type="radio" id="1" class="radio" name="example" checked value="" /> <span>Anytime</span></label>
				&nbsp;&nbsp;&nbsp;<label title='g:i a'>
				<input type="radio" id="2" class="radio" name="example" value="" /> <span>Scheduled</span></label>
				<input type="hidden" id="frequency" name="frequency" value="1" /></td>
        </tr>
        <tr >
            <td class="row-title"><label for="serving_per_day">Serving per day</label></td>
            <td><select required id="serving_per_day_anytime"  name="serving_per_day_anytime">
                <option value="">Please select</option>
                <option  value="1" >1</option>
                <option value="2" >2</option>
                <option value="3" >3</option>
                <option value="4" >4</option>
                <option value="5" >5</option>
                <option value="6" >6</option>
                <option value="7" >7</option>
                <option value="8" >8</option>
                <option value="9" >9</option>
                <option value="10" >10</option>
                <option value="asperbmi">As per BMI</otpuion>
            </select>
            <select required id="serving_per_day_scheduled" class="add_row_class" name="serving_per_day_scheduled" style="display:none" >
                <option value="">Please select</option>
                <option  value="Once">Once</option>
                <option value="Twice">Twice</option>
                <!--<option value="asperbmi">As per BMI</otpuion>-->
                </select></td>
        </tr>
        <tr id="add_table_weight">

        </tr>
        <tr ><input type="hidden" id="clone_id" name="clone_id" value="" />

        	<td class="row-title"><label for="serving_size">Quantity per servings</label><input type="hidden" name="count" id="count" value="0"></td>
            <td><input type="text" required id="serving_size"  name="serving_size" value="" class="small-text" />

            &nbsp;&nbsp;&nbsp;<label id="row_when" style="display:none" for="when">When</label>
            <select required id="when" name="when" style="display:none">
                <option value="">Please select</option>
                <option  value="1" >Morning before Meal</option>
                <option value="2" >Morning with Meal</option>
                <option value="3" >Evening before Meal</option>
                <option value="4" >Evening with Meal</option>

            </select></td>
        </tr>
        <tr id="clone"></tr>
        <tr>
            <td class="row-title"><label for="serving_per_container">Serving per Container</label></td>
            <td><input type="text" required  id="serving_per_container" name="serving_per_container" value="" class="small-text" /></td>
        </tr>
        <tr>
            <td class="row-title"><label for="total">Total</label></td>
            <td><label id="total"></label></td>
        </tr>
    </tbody>

</table>

<br/>
<input class="button-primary" type="submit" name="save" id="save" value="Save" />
<!-- <input class="button-primary" type="button" name="cancel" id="cancel" value="Cancel" />
 --></form>
</html>

<?php
}

function show_list_products(){

?>

<html>
<div id="form_data">
<h2>Products</h2>
<form id="show_product_form" enctype="multipart/form-data" method="POST">
<div style="position:relative;float:left"><label>Total Number : </label><label id="total_products"></label></div>
<div style="position:relative;float:right">
<!--<a class="button-secondary" href="#" name="export" id="export" title="<?php _e( 'Export' ); ?>"><?php _e( 'Export' ); ?></a>--></div>
<table id="prodcts_table" class="widefat">
    <thead>
        <tr>
            <th class="row-title">Product Name</th>
            <th class="row-title">Product Type</th>
            <th class="row-title">Frequency</th>
            <th class="row-title">Modified Date</th>
            <th class="row-title">Active</th>
        </tr>
    </thead>
    <tbody>

    </tbody>

</table>


</form>
</div>
</html>



<?php
}
//function to show settings
function settings(){

	//get default settings
	global $setting;

	$setting = new setting();
	$response = $setting->get_settings();
	$no_of_days ="";
	$id ="";
	$morning_from ="";
	$morning_to ="";
	$evening_from ="";
	$evening_to ="";
	$user = 0 ;
	if(is_array($response))
	{
		$object = json_decode($response['response']->value);
		$no_of_days = $object->no_of_days;
		$morning_from = $object->morning_from;
		$morning_to = $object->morning_to;
		$evening_from = $object->evening_from;
		$evening_to = $object->evening_to;
		$id = $response['response']->id;
		$user = $response['users'];
	}


?>
<html>
<h2>Settings and Usage</h2></br/>
<form id="settings_form" enctype="multipart/form-data" action="" method="post">
<div id="response_msg"></div>

<table>
	<tr>
		<td>
			<label for="serving_per_container">Stock reminder sent when stock left in hand for </label>
		</td>
		<td>
			<input type="text" required  id="no_of_days" name="no_of_days" value="<?php echo $no_of_days ;?>" class="small-text" /><label> days.</label>
			<input type="hidden" id="settings_id" name="settings_id" value="<?php echo $id;?>" />
		</td>

	</tr>
	<tr>
		<td>
			<label for="user">No. of App users (Web/Mobile)</label>
		</td>
		<td>
			<label for="user"><?php echo $user;?></label>
		</td>
	</tr>
	<!--<tr>
		<td>
			<label for="serving_per_container">Morning Time</label>
		</td>
		<td>
			<input type="text" required  id="morning_from" name="morning_from" value="<?php echo $morning_from ;?>" class="small-text" />
			&nbsp;to&nbsp;<input type="text" required  id="morning_to" name="morning_to" value="<?php echo $morning_to ;?>" class="small-text" />

		</td>

	</tr>
	<tr>
		<td>
			<label for="serving_per_container">Evening Time</label>
		</td>
		<td>
			<input type="text" required  id="evening_from" name="evening_from" value="<?php echo $evening_from ;?>" class="small-text" />
			&nbsp;to&nbsp;<input type="text" required  id="evening_to" name="evening_to" value="<?php echo $evening_to ;?>" class="small-text" />

		</td>

	</tr>-->

</table>
<br/>
<input class="button-primary" id="save" type="submit" name="save" value="<?php _e( 'Save' ); ?>" />

</form>
</html>


<?php



}

function test_modify_user_table( $column ) {
    $column['xooma_id'] = 'XoomaID';
    $column['products'] = 'Products';

    return $column;
}

add_filter( 'manage_users_columns', 'test_modify_user_table' );
add_action('manage_users_custom_column','custom_manage_users_custom_column',10,3);

function custom_manage_users_custom_column($custom_column,$column_name,$user_id) {
    if ($column_name=='xooma_id') {
        $user_info = get_user_meta($user_id,'xooma_member_id' , true);
       
        $custom_column = "\t{$user_info}\n";
    }
    if ($column_name=='products') {
        
        global $wpdb;

		$table = $wpdb->prefix . "product_main";

		$user = $wpdb->get_row("SELECT *,count(product_id) as products from $table where user_id=".$user_id." and deleted_flag=0");
       
       	$products = $user->products;
        $custom_column = "\t{$products}\n";
    }
    return $custom_column;
}

//communication module//
function dba_add_communication_components($defined_comm_components){

	$defined_comm_components['xooma_users'] = array(
				'xooma_admin_email' => array('preference'=>1),
				'xooma_user_email'  => array('preference'=>1)

		);

	$defined_comm_components['stock_emails'] = array(
				'stock_low_email' => array('preference'=>1),
				'stock_over_email'  => array('preference'=>1)

		);

	$defined_comm_components['admin_config_emails'] = array(
				'add_product_email' => array('preference'=>1),
				'edit_product_email'  => array('preference'=>1)

		);

	return $defined_comm_components;
}
add_filter('add_commponents_filter','dba_add_communication_components',10,1);

add_action('CRON_SCHEDULE_SEND_REMINDERS', 'cron_job_reminders', 2,1);
add_action('CRON_SCHEDULE_LOW_STOCK', 'send_stock_reminders', 2,0);
add_action('CRON_SCHEDULE_OVER_STOCK', 'send_stock_reminders_over', 2,0);
//add_action('admin_init', 'send_stock_reminders', 2, 1);



function load()
{
  $data = file_get_contents(get_template_directory_uri().'/xoomaapp/json/php/status.txt');
  $proper_data = json_decode($data, true);

  return $proper_data;

}
function load_x2o()
{
  $data = file_get_contents(get_template_directory_uri().'/xoomaapp/json/php/x2o_status.txt');
  $proper_data = json_decode($data, true);

  return $proper_data;

}
function wpse_11244_restrict_admin() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __('You are not allowed to access this part of the site') );
    }
}
add_action( 'admin_init', 'wpse_11244_restrict_admin', 1 );

function my_custom_action_link($actions, $user_object) { 

	global $wp_roles; 

	$userRole = new WP_User( $user_object->ID ); 
	
	$profileurl= site_url()."/xooma-app/#/user_id/$user_object->ID"; 

	if ($userRole->roles[0] == 'subscriber')
	{
		$actions['view'] = "<a class='cgc_ub_edit_badges' target='_blank' href='" .$profileurl. "'>" . __( 'View', 'cgc_ub' ) . "</a>"; 
	
	}

	return $actions; 
} 
add_filter('user_row_actions', 'my_custom_action_link', 10, 2);