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
			<form action="<?php echo site_url() ?>" method="POST" id="submit-testimonial" enctype="multipart/form-data">	
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