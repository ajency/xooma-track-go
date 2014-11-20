<?php 
require_once( get_stylesheet_directory() .'/inc/src/facebook.php');

//Function to outut the html for the xooma frame page
function xww_xframe_menu_page(){
	if(isset($_POST['post_category']))
				$xframe_code = xww_xframe_create_iframe($_POST['post_category'],$_POST['xww_xframe_sizes'],$_POST['xframe_testimonial_type']);
	?>
	<div class='wrap'>
		<div id='icon-iframe-id' class='icon-iframe'>
			<br/>
		</div>
  		<h2>Xframe</h2>
		<span class="description">Create iframe of testimonials from selected categories in the drop down.</span>
		<form id="xww-generate-xframe" action="" method="post">
		<table class="form-table">
		<tbody>
		<tr valign="top">
			<th scope="row"><label for="xww-iframe-sizes">Select Testimonial Type</label></th>
			<td>
				<label for="xframe_testimonial_type"><input type="radio" name="xframe_testimonial_type" class="xframe-test-select" value="personal"/>&nbsp;Product Testimonials</label><br>
				<label for="xframe_testimonial_type"><input type="radio" name="xframe_testimonial_type" class="xframe-test-select" value="business"/>&nbsp;Business Testimonials</label>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="xww-iframe-sizes">Select Testimonial Categories</label></th>
			<td>
				<div class="xww-cats-wrapper">
					<ul class="xww-cats">
						<?php wp_category_checklist();?>
					</ul>
				</div>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="xww-iframe-sizes">Select Grid Size</label></th>
			<td>
				<select id="xww-iframe-sizes" name="xww_xframe_sizes">
					<option value="505">5x5</option>
					<option value="707">5x7</option>
					<option value="1010">5x10</option>
				</select>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"></th>
			<td>
				<input type="submit" name="xww_xframe_submit" class="button button-primary" value="Generate"/>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="xww-xframe-code">Xframe Code</label></th>
			<td>
				<textarea id="xww-xframe-code" name="xww_xframe_code"><?php echo $xframe_code;?></textarea>
			</td>
		</tr>
		</tbody>
		</table>
			
		
		</form>
	</div>
	<script>
		var jq = jQuery;
		jq(document).ready(function(){
			//Listen for the click event for the testimonial type.
			jq('.xframe-test-select').click(function(){
				var selectedValue = jq(this).val();
				switch(selectedValue)
				{
					case 'business':
							 //Add more categories ids to this array
							var showCats = [48];
							xframeHideCats(showCats);
						break;
					case 'personal':
							//Add more categories ids to this array
							var showCats = [2,25,48]; 
							xframeHideCats(showCats);
						break;		
				}
			});
			//Trigger initial click to setup the category view.
			jq('.xframe-test-select').first().trigger('click');
			//Listen for any checkbox click event.
			jq('[type="checkbox"]').click(function(){
					xframeSelectDeselectCheckbox(this);
			});
		});
		//Reusable function to selectively hide categories for xframe.
		var xframeHideCats = function (showCats){
			jq('.xww-cats li [type="checkbox"]').prop('checked',false);
			jq('.xww-cats').children().hide();
			for(var i = 0;i < showCats.length; i++)
			{
				jq('.xww-cats li#category-' + showCats[i]).show();
			}
		}
		//Reusable function to recurrsively select all the child categories
		//when parent category is selected.
		var xframeSelectDeselectCheckbox = function(catDeselect){
			if(jq(catDeselect).is(':checked'))
					jq(catDeselect).parent().parent().find('ul.children li [type="checkbox"]').prop('checked',true);
				else
					jq(catDeselect).parent().parent().find('ul.children li [type="checkbox"]').prop('checked',false);
		}
	</script>
	<?php 
}
//Function to create the option page for Xooma frame.
function xww_xframe_register_menu_page()
{
	$page_title = 'Xframe';
	$menu_title = 'Xframe';
	$capability = 'manage_options';
	$menu_slug 	= 'xww-xframe';
	$function	= 'xww_xframe_menu_page';
	$icon_url	= get_template_directory_uri().'/img/iframe-icon-single.png';
	$position	= '2.3';
	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
}
add_action('admin_menu','xww_xframe_register_menu_page');

function xww_xframe_admin_print_scripts()
{
	echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/css/xframe-css.css">';
}
add_action('admin_print_styles-toplevel_page_xww-xframe','xww_xframe_admin_print_scripts');

function xww_xframe_create_iframe($categories,$size,$testimonial_type){
	$site_url 			= get_bloginfo('url');
	$xframe_tpl 		= 'xww-xframe';
	$xframe_categories 	= $categories;
 	$xframe_url = add_query_arg( 'xcatin', $xframe_categories, $site_url.'/'.$xframe_tpl);
	$xframe_url = add_query_arg( 'xtt', $testimonial_type, $xframe_url);
	
	//http to https://
	$xframe_url = str_replace('http://','https://',$xframe_url);
	
	return esc_html( sprintf('<iframe src="%s" frameborder="0" scrolling="no" height="%d" width="520"></iframe>',$xframe_url,$size) );
}

function xww_fb_post_metabox()
{
	$id 		= 'xww-fb-post';
	$title 		= 'Post to Xomma FB page';
	$post_type 	= 'post';
	$context 	= 'side';
	$priority 	= 'core';
	$callback   = 'xww_fb_post_metabox_html';
	
	global $post;
	if($post->post_status == 'publish')
		add_meta_box( $id, $title, $callback, $post_type, $context, $priority );
}
add_action('add_meta_boxes','xww_fb_post_metabox');

function xww_fb_post_metabox_html()
{
	echo '<div style="display:none;" class="fb-xframe-post-login button button-primary">Login To Facebook</div>';
	echo '<div style="display:none;" class="fb-xframe-post-page button button-primary">Post Testimonial To Xooma Page</div>';
	?>
	<div id="fb-root"></div>
	<?php 
		global $post;
		$post_link  = get_permalink($post->ID);
		$post_title = $post->post_title;
		$post_excerpt =  xww_the_excerpt_max_charlength(150,$post->post_content);
		$post_thumb   = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' );
		$post_thumb_url = $post_thumb[0];	
	?>
<script>

  // Additional JS functions here
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '101968866648981', // App ID
      channelUrl : '//mystory.xoomaworldwide.com/channel.html', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

    // Additional init code here
	
	FB.getLoginStatus(function(response) {
		if (response.status === 'connected') {
			jQuery('.fb-xframe-post-page').show();
		} else if (response.status === 'not_authorized') {
		// not_authorized
			jQuery('.fb-xframe-post-login').show();
		} else {
		// not_logged_in
			jQuery('.fb-xframe-post-login').show();
		}
	});

  };
  
  jQuery('.fb-xframe-post-login').click(function(){
		xfb_login();
	});
  jQuery('.fb-xframe-post-page').click(function(){
		xfb_post_api();
  })

	function xfb_login() {
		FB.login(function(response) {
			if (response.authResponse) {
				jQuery('.fb-xframe-post-login').hide();
				jQuery('.fb-xframe-post-page').show();
			} else {
				console.log('Auth Cancelled.');
			}
		},{scope: 'manage_pages,publish_stream'});
	}
		
	function xfb_post_api(){
		FB.api('/me/accounts', function(response) {
		  // handle response
		  xfb_post_to_page(response.data);
		});
	}

	function xfb_post_to_page(response){
		var page_id = "161997160517385"; //Put xooma page id here.161997160517385  260770023999582
		if(response)
		{
			for(var i=0;i<response.length;i++)
			{
				if(response[i].id == page_id)
				{
					FB.api('/'+ page_id +'/feed', 'post', 
					  { 
						  message     : "Another Amazing Xooma Story",
						  link        : '<?php echo $post_link;?>',
						  picture     : '<?php echo  $post_thumb_url;?>',
						  name        : '<?php echo $post_title;?>',
						  to: page_id,
						  from: page_id,
						  description : '<?php echo $post_excerpt;?>',
						  access_token:response[i].access_token
				  }, 
				  function(response) {

					  if (!response || response.error) {
						  alert(JSON.stringify(response.error));
					  } else {
						  alert('This Testimonial was successfully shared on your page: ' + response.id);
					  }
				  });
				}
			}
		}
		
	} 	

  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));
</script>
	<?php 
}

function xww_xframe_get_testimonials()
{
	$args = array();
	
	if(isset($_GET['xcatin']) && is_array($_GET['xcatin']))
	{
		//get teh category ids to filter
		$_cat_ids = $_GET['xcatin'];  
		
		if(!empty($_cat_ids))
		{
			$args['category__in'] = $_cat_ids;
		}	
	}

	if(isset($_GET['xtt']) && $_GET['xtt'] == 'business')
		$args['tag_id'] = 80;
	else
		$args['tag__not_in'] = 80;	
	
	$args['post_status'] 	= 'publish';
	$args['orderby'] 		= 'rand';
	$args['posts_per_page'] = 46;
	$args['post_type'] 		= 'post';
	
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
				if($cat->parent == 25)
				{
					$ailment .= $cat->name . ', ';
				}
				if($cat->parent == 2)
				{
					$product .= $cat->name . ', ';
				}
				if($cat->parent == 48)
				{
					$country = $cat->name;
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
							
			$data[] = array('ImageUrl' => $img[0],
							'LinkUrl'  => $img[0],
							'HTML' 	   => '<a class="xww-xframe-url" href="'.get_permalink($testimonial->ID).'"></a>',
							'Href' => get_permalink($testimonial->ID)
					);	
		endforeach;
	}	
		
	echo json_encode(array('data' => $data,'ids' => $ids));
}

function xww_the_excerpt_max_charlength($charlength,$content) {
	$excerpt = strip_tags($content);
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			return mb_substr( $subex, 0, $excut ).'[...]';
		} else {
			return $subex.'[...]';
		}
	} else {
		return $excerpt;
	}
}