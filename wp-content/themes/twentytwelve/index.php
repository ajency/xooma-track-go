<?php
	/*
		Template Name: Xooma App
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
	$product	= empty($_POST['product']) ? false : $_POST['product'];
	$ailment	= empty($_POST['ailment']) ? false : $_POST['ailment'];
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
			$cat_ids = array_merge($_POST['ailment'],$_POST['product']);;
						
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
				wp_mail($admin_email ,'New Testimonial waiting for approval', $message);
			}	
			setcookie('submitted', 'yes',  time() + 50, '/');
		    header("Location: " . site_url());
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
						
					</div>
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
					<a href="<?php echo site_url(); ?>/business-testimonials/" style="text-align:center; text-decoration:underline;"> View Business Testimonials</a>
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
				<h1 id="myModalLabel">Submit your testimonial</h3>
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
		<div style="display:none">
			<a href="<?php echo site_url('business-testimonials'); ?>">Business Testimonials</a>
		</div>	
<?php get_footer(); ?>