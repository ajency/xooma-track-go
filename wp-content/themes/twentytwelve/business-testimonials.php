<?php

	/*

		Template Name: Business Testimonials

	*/

?>

<?php 



//process form here

//Bail if not a POST action

$error = false;

$error_message = array();

$search_query = '';

if (isset($_POST['search-query']))

{

	$search_query = $_POST['search-query'];

}

if (('POST' === strtoupper( $_SERVER['REQUEST_METHOD'] )) && isset($_POST['email']))

{

	//check if all required data is passed with request

	$email 		= empty($_POST['email']) ? false : $_POST['email'];

	$name 		= empty($_POST['xmname']) ? false : $_POST['xmname'];

	$counrty 	= empty($_POST['country']) ? false : $_POST['country'];

	$profile_pic= false;

	

	if(is_numeric($_POST['user_fb_id']) || !empty($_FILES['profile_pic']['name']))

	{

		$profile_pic = true;

	}

	

	if(($profile_pic !== false) && ($email !== false) && ($name !== false) && ($counrty !== false) && ($product !== false) && ($ailment !== false))

	{

		

		//check for testimonial

		$content= false;

		if(isset($_POST['testimonial']) && !empty($_POST['testimonial']))

		{

			$content = stripslashes($_POST['testimonial']);	

		}

		if(isset($_POST['video_testimonial']) && !empty($_POST['video_testimonial']))

		{

			$video = $_POST['video_testimonial'];

			//if is http .. convert to https

			$video = parse_yturl($video);

			$video = "https://www.youtube.com/embed/$video?origin=https://mystory.xoomaworldwide.com";

			$iframe = "<br /><br /><iframe type='text/html' width='425' height='190' src='$video' frameborder='0'></iframe>";

			$content .= $iframe;	

		}

		

		$content = remove_line_breaks($content);

		

		if($content !== false)

		{

			$user_id = 0;

			//check if user exists

			if(!email_exists($email))

			{

				//create user

				$user_id  = wp_insert_user(array(

									'user_login' 	=> 'xm_user_'. rand(25879,98756),

									'user_email' 	=> $email,

									'user_pass' 	=> md5('xooma'),

									'first_name' 	=> $name

							));

						

			}

			else 

			{

				//get user id	

				$user = get_user_by('email', $email);

				$user_id = $user->ID;

			}

			

			

						

						

			//create testimonial post			

			$post_data = array(

					'post_title' 	=>  'Testimonial by '. $_POST['xmname'],

					'post_content' 	=> $content,

					'post_status' 	=> 'pending',

					'post_author' 	=> $user_id,

			);



			//create a new recipe post

			$post_id = wp_insert_post($post_data);

			

			//set xooma member ID

			$xm_id	= $_POST['xm_id'];

			update_post_meta($post_id,'xooma_member_id',$xm_id);

			

			

			//assign categories

			//$cat_ids = array_merge($_POST['ailment'],$_POST['product']);;

					

			$cat_ids = array();		

				

			//check for country category

			$country = country_code_to_country($_POST['country']);

			

			$cat_id = term_exists($country,'category',48);

			if ($cat_id !== 0 && $cat_id !== null) {

				$cat_ids[] = $cat_id['term_id'];

			}

			else

			{	

				$cat_id = wp_insert_term( $country, 'category', array('parent'=>48));

				$cat_ids[] =  $cat_id['term_id'];

			}

			

			//set categories

			wp_set_post_categories( $post_id, $cat_ids );

			

			//set tag

			wp_set_post_tags($post_id,'Business Testimonials',false);

			

			//check if testimonial is submitted using fb data

			if(isset($_POST['user_fb_id']) && !empty($_POST['user_fb_id']))

			{

				//submitted using FB. add user id to user meta

				update_user_meta($user_id, 'fb_id', $_POST['user_fb_id']);

			}

			else

			{

				//user submitted testimonial

				$files = $_FILES['profile_pic'];

				if ($files['name']) {

					$file = array(

						'name' => $files['name'],

						'type' => $files['type'],

						'tmp_name' => $files['tmp_name'],

						'error' => $files['error'],

						'size' => $files['size']

					);

				}	

				

				$_FILES = array("profile_pic" => $file);

			

				foreach ($_FILES as $file => $array) {

					$newupload = upload_gallery_attachment($file,$post_id,true);

				}

				

			}

			//wp_redirect(site_url('xooma?a=success'));

			//send mail to admin

			

			$link = get_permalink($post_id);

			

			$link = str_replace('http://','https://',$link);

			

			$message = "Hi,<br /><p>Please review the testimonial and approve it. You can see your testimonial by clicking the link below<br /><a href='". $link ."'>". $link ."</a></p><p>Xooma Worldwide.<p>";

				

			$admin_emails = get_all_admin_email_ids();



			foreach($admin_emails as $admin_email)

			{			

				add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));	

				wp_mail($admin_email ,'New Business Testimonial waiting for approval', $message);

			}	

			setcookie('submitted', 'yes',  time() + 50, '/');

		    header("Location: " . site_url('business-testimonials'));

		    exit;

		}

		else		

		{

			$error = true;

		}

	}

	else

	{

		$error = true;

	}

}



?>

<?php get_header(); ?>

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

						<?php if(isset($_COOKIE['submitted']) && $_COOKIE['submitted'] == 'yes'): ?>

						<div class="alert alert-success">

							<button type="button" class="close" data-dismiss="alert">&times;</button>

							<span>Thank you for sharing your testimonial and we are glad to hear of the successes you have had with Xooma products. You will receive an email once your submission has been approved and posted for display on the Xooma testimonials wall.</span>

						</div>

						<?php elseif($error): ?>

						<div class="alert alert-error">

							<span>Sorry!!! Unable to submit your testimonial. Please upload your profile picture!</span>

						</div>	

						<?php endif; ?>

					</div>

					<div id="category-filters">

						

					</div>

					<div id="search-filters">

						

					</div><div style=" margin-top: -20px;margin-bottom: 5px;"><i style=" font-size: 11px; line-height: 7px;"> Income examples represent estimated earnings based on the information presented. Your personal results may vary. See official Prosperity Plan documents for details.</i></div>

					<div style="clear:both"></div>

					

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

				<i style=" font-size: 11px; line-height: 7px; "> Income examples represent estimated earnings based on the information presented. Your personal results may vary. See official Prosperity Plan documents for details.</i>

				</div>

				<div class="sidebar span4">

					<div id="logo">

						<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" title="Xooma Worldwide" alt="Xooma Worldwide" />

					</div>

					<div id="search">

						<div class="form-search">

							<div class="input-append">

								<input type="text" class="search-query" id="search-query" value="<?php echo $search_query;?>" name="search-query" placeholder="Search...">

								<button type="button" class="btn" id="search_testimonials"><i class="icon-search"></i></button>

							</div>

						</div>

					</div>

					<div class="share_btn">

					<button class="btn btn-info" type="button" href="#myModal" data-toggle="modal" style=" margin-left: 15px; " > <i class="icon-pencil icon-white"></i> &nbsp;Share Your Story</button>

					</div>

					<div style=" margin: 12px; ">

					<a href="<?php echo site_url(); ?>" style="text-align:center; text-decoration:underline;"> View Personal Testimonials</a>

					</div>

					<div id="filters">

						<h3>Categories</h3>



						<?php 

						//get all categories

						$categories = get_categories('parent=0&hide_empty=0');

						

						

						foreach($categories as $category):

						

						if($category->cat_name == 'Uncategorized' || $category->cat_name == 'Product' || $category->cat_name == 'Testimony')

							continue;

						?>

						<div class="single-filter">

							<div class="filter-toggle" data-toggle="collapse" data-target="#<?php echo $category->slug; ?>">

								<?php echo $category->cat_name; ?>

							</div>

							<div id="<?php echo $category->slug; ?>" class="collapse">

								<ul>

								<?php $sub_categories = get_categories('parent='.$category->term_id); ?>

								<?php foreach($sub_categories as $sub_cat): ?> 

									<li><a id="xm_cat_<?php echo $sub_cat->term_id; ?>" href="#" class="filter_testimonials" data-cat-id="<?php echo $sub_cat->term_id; ?>"><?php echo $sub_cat->cat_name; ?></a></li>

								<?php endforeach; ?>	

									

								</ul>

							</div>

						</div>

						<?php 

						

						endforeach;

						

						?>

					</div >

					<div class="xooma_imgs">

					<img src="<?php echo get_template_directory_uri(); ?>/images/XoomaBottleHighRes.jpg" title="Xooma Bottle" alt="Xooma Bottle" /></br>

					</div></br><img src="<?php echo get_template_directory_uri(); ?>/images/xooma_text.jpg" title="Xooma tag" alt="Xooma tag" />

				</div>

			</div> <!-- /row-fluid -->

        </div> <!-- /container -->

 		<?php //add testimonial popup ?>

 		<!-- Button to trigger modal -->

		<!-- Modal -->

		<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>

				<h1 id="myModalLabel">Submit your Business testimonial</h3>

			</div>

			<div class="alert alert-info" id="fb-login-alert"> 

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

								

							    <a href="#" class=" fileupload-exists file_remove" data-dismiss="fileupload">Remove</a>

								

							  </div>

							</div>

						</div>

						<div class="span4 model-box">						

							<div class="control-group" style=" clear: both; ">

								<label class="control-label" for="inputID">Xooma ID</label>

								<div class="controls">

								  <input type="text" id="inputID" placeholder="" name="xm_id" style=" float: right; " value="<?php echo isset($_POST['xm_id']) ? $_POST['xm_id'] : ''; ?>"/>

								</div>

							</div>

							<div class="control-group" style=" clear: both; ">

								<label class="control-label" for="inputName">Name</label>

								<div class="controls">

								  <input type="text" id="inputName" placeholder="" name="xmname" style=" float: right; " value="<?php echo isset($_POST['xmname']) ? $_POST['xmname'] : ''; ?>"/>

								</div>

							</div>

							<div class="control-group" style=" clear: both; ">

								<label class="control-label" for="inputEmail">Email</label>

								<div class="controls">

								  <input type="text" id="inputEmail" placeholder="" name="email" style=" float: right; " value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"/>

								</div>

							</div>

							<div class="control-group" style=" clear: both; ">

								<label class="control-label" for="inputName">Country</label>

								<div class="controls">

							

							<select name="country" class="input-medium countries" style=" float: right;width: 221px;"></select>

								</div>

							</div>

							<?php /**

							<div class="control-group modal-control" >

								<label class="control-label" for="inputName">Testimony</label>

								<div class="controls">

								<select id="ailment_dropdown" multiple="multiple" name="ailment[]">

									<?php $sub_categories = get_categories('parent=25&hide_empty=0'); ?>

									<?php foreach($sub_categories as $sub_cat): ?> 

										<option value="<?php echo $sub_cat->term_id; ?>"><?php echo $sub_cat->cat_name; ?></option>

									<?php endforeach; ?>

								</select>

								</div>

							</div>

							<div class="clear"></div>

							<div class="control-group">

								<label class="control-label" for="inputName" style=" margin-right: 35px; ">Product</label>

								<div class="controls">

									<select id="product_dropdown" multiple="multiple" name="product[]">

										<?php $sub_categories = get_categories('parent=2&hide_empty=0'); ?>

										<?php foreach($sub_categories as $sub_cat): ?> 

											<option value="<?php echo $sub_cat->term_id; ?>"><?php echo $sub_cat->cat_name; ?></option>

										<?php endforeach; ?>

									</select>

								</div>

							</div>

							*/ ?>

						</div>	

					</div>

					

					<div class="row" style=" margin-top: 00px; ">

						<div class="span5">

							<div  class=" model-box">

						

							<div class="clear"></div>

							</div>

							<div class="control-group" id="text-testimonial">

								<label class="control-label" for="inputEmail">Testimonial</label>

								<div class="controls">

								  <textarea rows="3" name="testimonial"><?php echo isset($_POST['testimonial']) ? $_POST['testimonial'] : ''; ?></textarea>

								</div>

							</div>

							<div class="alert alert-success" style=" width: 121%; margin-top: 5px; ">

							<div class="control-group">

								<div class="controls">

								  <input type="checkbox" value="" id="vid_testimonial" /> Video testimonial?

								</div>

							</div>

							</div>

							<div class="control-group" style="display:none" id="vid-testimonial">

								<div class="controls">

									<input type="text" value="<?php echo isset($_POST['video_testimonial']) ? $_POST['video_testimonial'] : ''; ?>" name="video_testimonial" id="inputtestimonial" class="url" placeholder="Enter youtube video URL"  style=" width: 106%; ">

								</div>

							</div>

						</div>

					</div>	

				</div>

				<input type="hidden" name="user_fb_id" value="" />

				<div class="modal-footer">

				<div class="submit_desc">By clicking Submit, I agree to the terms of <a href="<?php echo site_url('terms'); ?>" target="_blank">Xooma Worldwide's Testimonial Release</a></div>

					<button class="btn btn-primary" type="submit">Submit</button>

					<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

				</div>

			</form>		

		</div>		

		<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/jquery-1.8.3.min.js"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/bootstrap.min.js"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/bootstrap-formhelpers-countries.en_US.js"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/bootstrap-formhelpers-countries.js"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-photofy-2.0.43.js" type="text/javascript"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.validate.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/bootstrap-multiselect.js"></script>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.cookie.js"></script>

<script src="https://connect.facebook.net/en_US/all.js" type="text/javascript"></script>

<script type="text/javascript">

	

	var images = [

			<?php 

				$args = array();

				if(isset($_GET['cat']) && is_numeric($_GET['cat']))

					$args['cat'] = $_GET['cat'];

					

				$args['post_status'] 	= 'publish';

				$args['orderby'] 		= 'rand';

				$args['posts_per_page'] = 46;

				$args['post_type'] 		= 'post';

				$args['tag_id'] 		= 80;

				

				//$testimonials = query_posts('post_status=publish&orderby=rand&posts_per_page=21&post_type=post' .  $cat_filter );

				$testimonials = query_posts($args);

				

				$ids = '';

				

				foreach($testimonials as $testimonial):

					

					//store current IDS

					$ids .= $testimonial->ID . ',';

					

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

								

					$content = addslashes($testimonial->post_content);

						

					$content = remove_line_breaks($content);						

						

					//Product</br> <span> '. rtrim($product,', ') .' </span>Testimony</br> <span> '. rtrim($ailment,', ') . '</span>	

						

					echo '{

							ImageUrl: "'.  $img[0] .'", 

							LinkUrl: "'. $img[0] .'", 

							HTML: "<div class=\'facebook_button\' style=\'   position: absolute; z-index: 99999; margin-left: 214px; \'></div><a href=\'' . get_permalink($testimonial->ID) .'\'><h4 class=\'testimonialTitle\'>'. addslashes($testimonial->post_title) .'</h4></a>Country</br> <span> '. $country . '</span><div class=\'slickscroll\'><div>'. $content .'</div></div>",

							Href : "' . get_permalink($testimonial->ID) .'"},';

				endforeach;

			 ?>

  			];



	var _filter_cat_ids = [];

	var _current_ids	= [<?php echo rtrim($ids,','); ?>];



	

	function addToPage() {



        // calling the API ...

        var obj = {

          method: 'pagetab',

          redirect_uri: 'http://mystory.xoomaworldwide.com/',

        };



        FB.ui(obj);

    }

	

	function fbs_click(width, height) {

		var leftPosition, topPosition;

		//Allow for borders.

		leftPosition = (window.screen.width / 2) - ((width / 2) + 10);

		//Allow for title and status bars.

		topPosition = (window.screen.height / 2) - ((height / 2) + 50);

		var windowFeatures = "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no";

		u=location.href;

		t=document.title;

		window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer', windowFeatures);

		return false;

	}

	

  	jQuery(document).ready(function($){	

		

		if($.cookie('submitted') != 'undefined')

  			$.removeCookie('submitted', { path: '/' });	

	

	

		if (jQuery('#search-query').val() !='')

		{

			jQuery('#search_testimonials').click();

		}

		/**

		$('#ailment_dropdown,#product_dropdown').multiselect({

			 button: 'btn btn-small',

			 width: '140px'

		});*/

		

		$(window).load(function(){

			$.getScript("http://static.ak.fbcdn.net/connect.php/js/FB.Share", function(data, textStatus, jqxhr) {

			});

		});	

		

		FB.init({

			appId  : '101968866648981',

			status : true, // check login status

			cookie : true, // enable cookies to allow the server to access the session

			xfbml  : true  // parse XFBML

		});

		

		

		

		//text or video testimonial

		$('#vid_testimonial').change(function(){

			$('#vid-testimonial').slideToggle('fast',function(){

				if($('#vid-testimonial').is(':visible'))

					$('input[name="video_testimonial"]').rules('add',{required : true});

				else

					$('input[name="video_testimonial"]').rules('remove');

			});

		});

		

		$('#load_more_testimonial').live('click',function(){

			get_filtered_data(_current_ids,_filter_cat_ids);

		});	

	   

		

		$('.grid-logo,.grid-like,.grid-write').fadeIn();

			

		

		//facebook connect

		$('#connect-facebook').live('click',function(){

			FB.login(function(response) {

				if (response.authResponse) {

					FB.api('/me', function(response) {

						$('#myModal').find('#fb-login-alert').fadeOut();

						$('#myModal').find('.model-photo').find('span.btn-file').fadeOut();

						$('input[name="user_fb_id"]').val(response.id);

						$('#inputName').val(response.name);

						$('#inputEmail').val(response.email);

						$('#photo-preview').attr('src','https://graph.facebook.com/'+ response.id +'/picture?width=150&height=150');

						

						//remove pic validation rules

						$('input[name="profile_pic"]').rules('remove');

						

					});

				} 

			},{scope: 'email,user_photos'});		

		});

		

		$('#ailment_dropdown').next('btn-group').find('.dropdown-menu').find('input[type="checkbox"]').change(function(){

			$('#ailment_dropdown').parent().find('label').remove();

		});

  				

  	  	$('#submit-testimonial').validate({

			ignore: "",

			errorClass : 'xm_error',

			rules : {

				'xm_id' : {

					minlength : 6,

					maxlength : 6,

					number    : true,

					required  : true	

				},

				'xmname' : 'required',

				'email' : {

					required : true,

					email : true

				},	

				'country' : 'required',				

				'testimonial' : 'required'

			},

			messages: {

				'country': {

					required: "Please select your country!"

			   	}			   

			},

			submitHandler : function(form){

				

				form.submit();

			}

  	  	});	

		

		

		insert_empty_data();

		

  		jQuery("#photofy").photofy({

				imageSource: images,

				maxImages: 50,

				highlight: false,

				copyright: false,

				overlayTransparency: 0.4,

				shuffle : false,

				shuffleAtStart : false,

				fadeDuration: 0

		});

		

		jQuery('.slickscroll').css('margin-top',jQuery(this).closest('.photofy_overlay_html').next('.photofy_overlayImage').height());



		add_video_icon(images);

  		

		jQuery('.single-filter .collapse').on('show', function () {

	

			jQuery(this).parent('.single-filter').find('.filter-toggle').addClass('open');

		})

				

		jQuery('.single-filter .collapse').on('hide', function () {

		

			jQuery(this).parent('.single-filter').find('.filter-toggle').removeClass('open');

		});





		jQuery('a.filter_testimonials').live('click',function(e){



			e.preventDefault();



			//set as selected

			jQuery(this).css({'color' : '#AAC93B' , 'font-weight' : 'bold'});

			

			var _cat_id = jQuery(this).attr('data-cat-id');



			_filter_cat_ids.push(_cat_id);



			var _cat = '<span class="myTag" id="cat_'+ _cat_id +'">'+

							'<span>'+ jQuery(this).html() +'&nbsp;&nbsp;</span>'+

							'<a href="#" class="myTagRemover" id="tagsk_Remover_'+ _cat_id +'" catidtoremove="'+ _cat_id +'" title="Remove">x</a>'+

						'</span>';

			

			jQuery('#category-filters').append(_cat);

			jQuery('#cat_'+ _cat_id).hide().fadeIn();

			

			get_filtered_data([],_filter_cat_ids);

					

  		});	



		<?php if(isset($_GET['cat']) && is_numeric($_GET['cat'])): ?>

			var _cat = '<span class="myTag" id="cat_<?php echo $_GET['cat'] ?>">'+

							'<span><?php echo $_GET['cat_name'] ?>&nbsp;&nbsp;</span>'+

							'<a href="#" class="myTagRemover" id="tagsk_Remover_<?php echo $_GET['cat'] ?>" catidtoremove="<?php echo $_GET['cat'] ?>" title="Remove">&times;</a>'+

						'</span>';

			

			jQuery('#category-filters').append(_cat);

			jQuery('#cat_<?php echo $_GET['cat'] ?>').hide().fadeIn();

		<?php endif; ?>	

			

		

  	});	



  	jQuery('a.myTagRemover').live('click',function(e){



  		e.preventDefault();



  		var cat_id = jQuery(this).attr('catidtoremove');



		//reset selected style

  		jQuery('#xm_cat_'+cat_id).css({'color' : '#005580' , 'font-weight' : 'normal'});



		get_filtered_ids(cat_id);



  		get_filtered_data([],_filter_cat_ids);



  		jQuery(this).parent().fadeOut('slow',function(){

  			jQuery(this).remove();		

  		});



  	});

  	



  	function get_filtered_ids(cat_id)

  	{

  		var _new_filter_ids = [];

  		

  		for( var i=0 ; i < _filter_cat_ids.length ; i++ )

  		{

			if(cat_id != _filter_cat_ids[i])

				_new_filter_ids.push(_filter_cat_ids[i]);

  		}



  		_filter_cat_ids = _new_filter_ids;



  	}





  	function get_filtered_data(_c_ids,_f_ids)

  	{

		if(_c_ids.length == 0)

			_c_ids = 'none';

			

		if(_f_ids.length == 0)

			_f_ids = 'none';

			

			

		

		jQuery('#spinner').css({

							width : jQuery('#photofy').width(),

							height : 500

						}).show().find('div.spinner').height(jQuery(this).height());



		

  		/** make ajax call to get filtered testimonials */

		jQuery.post(ajaxurl,{

						action  	: 'xm_get_testimonials',

						cat_ids 	: _f_ids,

						current_ids : _c_ids,

						search_text : jQuery('#search-query').val(),

						is_business : 1

					},

					function(response)

					{

						//clear UI blocking

						jQuery('#spinner').hide();

						

						//set current ids

						_current_ids = 	response.ids;

						

						//clear images var

						images = [];



						images = response.data;



						insert_empty_data();

						

						//remove all 

						//jQuery('#photofy a.photofy_thumbnail').hide();// ('slow',function(){



						jQuery('#photofy a.photofy_thumbnail').remove();	

						

						jQuery("#photofy").photofy({

								imageSource: images,

								maxImages: 50,

								highlight: false,

								copyright: false,

								overlayTransparency: 0.4,

								shuffle : false,

								shuffleAtStart : false,

								fadeDuration: 0

						});



						//jQuery('#photofy a.photofy_thumbnail').show();

					

						add_video_icon(images);

						

					},'json'); 	

  	}

	

	function postToFeed(i) {



        // calling the API ...

        var obj = {

          method: 'feed',

          redirect_uri: 'http://mystory.xoomaworldwide.com',

          link: images[i].Href,

          picture: images[i].ImageUrl,

          name: '',

          caption: '',

          description: images[i].HTML

        };



        function callback(response) {

            //do nothing

        }



        FB.ui(obj, callback);

  	}  



	function add_video_icon(images)

  	{

  	  	var _video_testimonials = [];

  		for(var i = 0  ; i < images.length ; i++)

		{

			if(images[i].HTML.contains('<iframe'))

				_video_testimonials.push(i);	



			//add the like share button

			if(images[i].Href != null)

			{

				var ele = jQuery('a.photofy_thumbnail').eq(i);

				jQuery(ele).find('.facebook_button').append('<div class="fb-like" data-href="'+ images[i].Href +'" data-send="false" data-layout="standard" data-width="50" data-show-faces="false" data-colorscheme="light" data-action="like"></div><br />');

			}			

		}

		//<a href="http://www.facebook.com/share.php?u='+ images[i].Href +'&app_id=101968866648981" onClick="return fbs_click(500, 200);" target="_blank" title="Share This on Facebook"><img src="/images/facebook3.png" alt="facebook share" width="64" height="24"></a>



  		if(_video_testimonials.length > 0)

  		{

	  		for(var i = 0  ; i < _video_testimonials.length ; i++)

	  		{

		  		var ele = jQuery('a.photofy_thumbnail').eq(_video_testimonials[i]);

				jQuery(ele).append('<div class="video_testimonial"></div>');

	  		}

  		}	

  	} 

  	



  	function insert_empty_data()

  	{

		var placeholder = theme_dir_uri + '/images/bck.gif';

  	  	

		if(images.length < 46) 

			$('#load_more_testimonial').hide();

		else

			$('#load_more_testimonial').show();

		

		if(images.length >= 6 )

		{

			images.insert(6, {ImageUrl: placeholder, LinkUrl: '', HTML: '', Href : null});

		}

		{

		if(images.length >= 7 )

			images.insert(7, {ImageUrl: placeholder, LinkUrl: '', HTML: '', Href : null});

		}

		if(images.length >= 14 )

		{

			images.insert(14, {ImageUrl: placeholder, LinkUrl: '', HTML: '', Href : null});

		}

		if(images.length >= 17 )

		{

			images.insert(17, {ImageUrl: placeholder, LinkUrl: '', HTML: '', Href : null});

		}



		for(var i = images.length  ; i < 50 ; i++)

		{

			if((i != 6) || (i != 7) || (i != 14) || (i != 17))

				images.insert(i, {ImageUrl: placeholder, LinkUrl: '', HTML: '', Href : null});

		}

  	}



  	Array.prototype.insert = function (index, item) {

  	  this.splice(index, 0, item);

  	};

	

	String.prototype.contains = function(substr) {

  	  return this.indexOf(substr) > -1;

  	}

	

	function add_search_text()

	{

		if (jQuery('#search-query').val() !='')

		{

			var _search = '<span class="myTag" id="search_text">'+

							'<span>'+  jQuery('#search-query').val() +'&nbsp;&nbsp;</span>'+

							'<a href="#" class="mySearchTagRemover"  title="Remove">x</a>'+

						'</span>';

			 

			jQuery('#search-filters').html(_search);

			

			get_filtered_data([],_filter_cat_ids);

		}

	}

		

		jQuery('#search_testimonials').live('click',function(e){



			e.preventDefault(); 

			

			add_search_text();

			 

					

  		});	

		

		jQuery('a.mySearchTagRemover').live('click',function(e){



  		e.preventDefault();

		

		jQuery('#search-query').val('')

		

		get_filtered_data([],_filter_cat_ids);



  		jQuery(this).parent().fadeOut('slow',function(){

  			jQuery(this).remove();		

  		});



  	});

  	

	$('#search-query').bind("enterKey",function(e){

		e.preventDefault(); 

			

		add_search_text();

	});

	$('#search-query').keyup(function(e){ 

		if(e.keyCode == 13)

		{

		  $(this).trigger("enterKey");

		} 

		if(jQuery('#search-query').val() =='')

		{

			if ($("#search_text").length > 0){

				get_filtered_data([],_filter_cat_ids);

				

				jQuery('#search_text').fadeOut('slow',function(){

				jQuery('#search_text').remove();	

				});

			}				

		}

	});

</script>

</body>

</html>