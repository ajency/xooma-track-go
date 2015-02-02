<script id="login-template" type="text/template">
	<div class="topheader">
		<nav class="navbar " role="navigation">
			<div class="container">
				<div class="row">
					<div class="col-sm-3 col-xs-6">
						<div class="navbar-header">
							<a href="#">
								<img alt="Brand" src="<?php echo get_template_directory_uri(); ?>/img/logo.png" class="tp-img-align img-responsive" width="200px">
							</a>
						</div>
					</div>
					<div class="col-sm-9 col-xs-6">
					<!--    <a href="#menu">
							<h5><i class="fa fa-cog pull-right "></i></h5>
						</a>-->
					  
					</div>
				</div>
			</div>
		</nav>
	</div>
	<div class="container">
			<div class="row">
			<div class="col-sm-3">
			</div>
					<div class="col-sm-6">
							<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
									<br>
									<br>
<br>
									<ol class="carousel-indicators">
										<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
										<li data-target="#carousel-example-generic" data-slide-to="1"></li>
										<li data-target="#carousel-example-generic" data-slide-to="2"></li>
										<li data-target="#carousel-example-generic" data-slide-to="3"></li>
										<li data-target="#carousel-example-generic" data-slide-to="4"></li>
									</ol>
									<div class="carousel-inner" role="listbox">
										<div class="item active">
											<img src="<?php echo get_template_directory_uri(); ?>/images/slider1.jpg" alt="" class="center-block img-responsive">
											<div class="carousel-caption text-center">
													<h5>Easy and intuitive way to keep track of your Xooma products intake.</h5>
													
											</div>
										</div>
											<div class="item ">
											<img src="<?php echo get_template_directory_uri(); ?>/images/reminder.png " alt="" class="center-block img-responsive"  >
											<div class="carousel-caption text-center">
													<h5>App offers timely notification and email reminders making sure you never miss a dose!</h5>
											</div>
										</div>
										<div class="item ">
											<img src="<?php echo get_template_directory_uri(); ?>/images/chart.png" alt="" class="center-block img-responsive" >
											<div class="carousel-caption text-center">
													<h5>Measure your fitness with Progress chart</h5>
											</div>
										</div>
										<div class="item ">
											<img src="<?php echo get_template_directory_uri(); ?>/images/low-stock.png" alt="" class="center-block img-responsive" >
											<div class="carousel-caption text-center "  >
													<h5>Know when your stock is running out and order in time</h5>
											</div>
										</div>
										<div class="item ">
											<img src="<?php echo get_template_directory_uri(); ?>/images/platform.png" alt="" class="center-block img-responsive"  >
											<div class="carousel-caption text-center"  >
													<h5>One screen where download to app link (ios and android ) available</h5>
											</div>
										</div>
									</div>

							</div>
<div class="col-sm-3">
			</div>
							<!-- Login Button  -->
					</div>
			</div>
			<button type="button" fb-scope="email" class="btn btn-primary btn-lg center-block aj-fb-login-button">Login with facebook</button>
	</div>
</script>
<script id="404-template" type="text/template">
		<div class="container">
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
				<img src="<?php echo get_template_directory_uri(); ?>/images/404.jpg" class="center-block"/>
				<h4 class="text-center" > We can't seem to find page you're looking for</h4>
				</div>
				<div class="col-md-3"></div>
			</div>
		</div>
</script>


<script id="xooma-app-template" type="text/template">
		<div class="topheader">
				<nav class="navbar " role="navigation">
						<div class="container">

								<div class="row">

										<div class="col-sm-3 col-xs-6">
												<div class="navbar-header">
														<a href="#">
																<img alt="Brand" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/images/logo.png" class="img-responsive tp-img-align" width="200px">
															</a>
												</div>
										</div>
										<div class="col-sm-9 col-xs-6">
											<div ui-region="currentUser" class="pull-right user-data">

											</div>
											 <a class="link" href="#settings">
							<h4><i class="fa fa-cog pull-right "></i></h4>
							</a>
							<a class="link" href="#/home">
							<h4><i class="fa fa-home pull-right"></i></h4>
							</a>
										</div>
					
								</div>
						</div>
				</nav>
		</div>

		<div class="clearfix"></div>
		

    <div id="loader"></div> 


		<div ui-region style="margin-top:60px">
		
		</div>
</script>
<script id="profile-template" type="text/template">
		<div class="sub-header">
				<div class="container">
						<div class="row">
								<div class="col-sm-12">
										<ul class="list-inline">
												<li class="tag"><a id="profile" href="#/profile/personal-info"><i class="fa fa-user"></i>
														<span class="hidden-xs"> PERSONAL INFO</span></a>
												</li>
												<li class="tag"><a id="measurement" href="#/profile/measurements"><i class="fa fa-pencil-square-o"></i>
														<span class="hidden-xs">MEASUREMENT</span></a>
												</li>
												<li class="tag"><a id="product" href="#/profile/my-products"><i class="fa fa-list"></i>

														<span class="hidden-xs">MY PRODUCTS</span></a>

														

												</li>
										</ul>
								</div>
						</div>
				</div>
		</div>
		<div class="clearfix"></div>
		<div ui-region></div>
</script>
<script id="settings-template" type="text/template">
		<div class="container"> 
		<div class="aj-response-message"> </div>
		  <div class="row">
		 <div class="col-md-2">
		 </div>
			<div class="col-md-8 col-xs-12">
			  
			  <form class="form-horizontal m-t-30">
  <div class="form-group link"  onclick="location.href='#profile/my-products'">
	<label class="col-sm-12 col-xs-12  control-label">My Xooma Products</label></a>
  </div>
	<div class="form-group link"  onclick="location.href='#products'">
	<label  class="col-sm-12 col-xs-12  control-label">List of Xooma Products</label>
  </div>

   <div class="form-group link"  onclick="location.href='#profile/personal-info'">
	<label  class="col-sm-12 col-xs-12  control-label">Personal Info</label>

  </div>
   <div class="form-group link"  onclick="location.href='#profile/measurements'">
	<label  class="col-sm-12 col-xs-12  control-label">Set your measurements</label>
  </div>


  <div class="form-group">
	<label class="col-sm-8 col-xs-8  control-label">Notifications</label>
	<div class="col-sm-4 col-xs-4 ">
	 <div class="switch">
			<input id="notification" value=""  name="notification" class="cmn-toggle cmn-toggle-round-flat" type="checkbox">
			<label for="notification"></label>
   </div>
	</div>
  </div> 
  <div class="form-group">
	<label  class="col-sm-8 col-xs-8 control-label">Email Alerts</label>
	<div class="col-sm-4 col-xs-4 ">
 <div class="switch">
			<input id="emails" name="emails" value="" class="cmn-toggle cmn-toggle-round-flat" type="checkbox">
			<label for="emails"></label>
   </div>
	</div>
  </div> 
	 <div class="form-group link"  onclick="location.href='http://xooma.com/'">
	<label  class="col-sm-12 col-xs-12  control-label">About Xooma</label>
  </div>

</form>
			  
			  
			  
			  
			  </div>
			<div class="col-md-2">
		 </div>
		</div>
	  
	</div> 
</script>
<script id="no-access-template" type="text/template">
		{{#if no_access}}
				<div class="container">
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
				<img src="<?php echo get_template_directory_uri(); ?>/images/noaccess.jpg" class="center-block"/>
				<h4 class="text-center" > You do not have permission to view the page</h4>
				</div>
				<div class="col-md-3"></div>
			</div>
		</div> {{/if}} {{#if no_access_login}}
		<div class="container">
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
				<img src="<?php echo get_template_directory_uri(); ?>/images/noaccess.jpg" class="center-block"/>
				<h4 class="text-center" > Please login to view this page</h4>
				<a class="btn btn-primary aj-submit-button center-block" href="#/login">Click here to login</a>
				</div>
				<div class="col-md-3"></div>
			</div> {{/if}} {{#if not_defined}}
		<div class="container">
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
				<h1 class="text-center" style="font-size: 260px;"><i class="fa fa-user"></i></h1>
				<h4 class="text-center" >This view is not configured. Please contact administrator</h4>
		
				</div>
				<div class="col-md-3"></div>
			</div>  {{/if}}
</script>
<script id="profile-personal-info-template" type="text/template">

		<div id="personalinfo" class="section">

				<div class="container">

						<div class="aj-response-message"> </div>
						<form class="form-horizontal update_user_details" role="form">


								<img src="{{profile_picture.sizes.thumbnail.url}}" alt="{{display_name}}" class="img-circle center-block profile-picture hidden-xs" width="150px" height="150px">

								
								<p class="text-center">Let us know something about you.</p>
								<br>
								<div class="row">
										<div class="col-sm-offset-3 col-sm-6">


												<div class="form-group">
														<label for="text1" class=" col-sm-3 col-xs-4 control-label">Xooma ID  <span class="requiredField text-danger"> * </span></label>
														<div class="col-sm-9 col-xs-8">
																<input type="text"  aj-field-type="number" aj-field-equalTo="6" aj-field-required="true" class="form-control " name="profile[xooma_member_id]">
														</div>
												</div>
												<div class="form-group">
														<label for="text2" class=" col-sm-3 col-xs-4 control-label">Name</label>
														<div class="col-sm-9  col-xs-8">
																<input type="text"  readonly class="form-control" name="display_name">
														</div>
												</div>
												<div class="form-group">
														<label for="text3" class="col-sm-3 col-xs-4 control-label">Email</label>
														<div class="col-sm-9 col-xs-8">
																<input type="text" readonly class="form-control" name="user_email">
														</div>
												</div>
												<div class="form-group">
														<label for="text4" class="col-sm-3 col-xs-4  control-label">Phone</label>
														<div class="col-sm-9 col-xs-8">
																<input type="text" aj-field-type="number" class="form-control" name="profile[phone_no]">
														</div>
												</div>
												<div class="form-group">
														<label for="text5" class=" col-sm-3 col-xs-4  control-label">Gender  <span class="requiredField text-danger"> * </span></label>
														<div class="col-sm-9 col-xs-8">
																<div class="rd-gender">
																		<label class="wrap pull-left">
																				<input type="radio" aj-field-required="true" name="profile[gender]" class="radio" value="male" />
																				<span class="rd-visual male" title="Male"></span>
																		</label>

																		<label class="wrap pull-left">
																				<input type="radio" aj-field-required="true" name="profile[gender]" class="radio" value="female" />

																				<span class="rd-visual female" title="Female"></span>
																		</label>
																</div>
														</div>
												</div>
												<div class="form-group">
														<label for="text7" class=" col-sm-3 col-xs-4  control-label">Birth date  <span class="requiredField text-danger"> * </span></label>
														<div class="col-sm-9 col-xs-8">

																<input class="form-control" type="text" id="birth_date" name="profile[birth_date]" required />
														</div>
												</div>
												<div class="form-group">
														<label for="text8" class=" col-sm-3 col-xs-4  control-label">Time zone</label>
														<div class="col-sm-9 col-xs-8">
																<select class="form-control" name="profile[timezone]">
																		<option value="UTC-05:00">Eastern Time Zone (UTC-05:00)</option>
																		<option value="UTC-06:00">Central Time Zone (UTC-06:00)</option>
																		<option value="UTC-07:00">Mountain Time Zone (UTC-07:00)</option>
																		<option value="UTC-08:00">Pacific Time Zone (UTC-08:00)</option>
																		<option value="UTC-09:00">Alaska Time Zone (UTC-09:00)</option>
																		<option value="UTC-10:00">Hawaii-Aleutian Time Zone (UTC-10:00)</option>
																		
																</select>
														</div>
												</div>

												<div class="row">
														<div class="col-sm-12">
																<button type="submit" id="add_user" name="add_user" class="btn btn-primary btn-lg pull-right aj-submit-button"><i class="fa fa-check"></i> Save</button>
														</div>
												</div>

										</div>
								</div>
						</form>
				</div>
		</div>
</script>
<script id="profile-measurements-template" type="text/template">
		<div id="measuremnt" class="section">

				<div class="container">
				<div class="alert alert-warning alert-msg measurements_update hidden" role="alert">
				  <i class="fa fa-bullhorn"></i> Choose a date from the calender and update your measurement by clicking on save!
				<input type="text"  id="update" class="line-datepicker " placeholder="&#xf073;">
				<div class="clearfix"></div>
				</div>
				<div class="aj-response-message"></div>


						<form id="add_measurements" class="form-horizontal" role="form" method="POST">
								<div class="row">
										<div class="col-sm-6">
												<h5 class="text-center bold">Set your measurements</h5>
												<p class="text-center">Knowing this information will help us determine the ideal amount of X2O water that your body needs on a daily basis </p>
												<div class="row">
												<input type="hidden" name="date_field" id="date_field" value="{{measurements.date}}" />
														<div class="col-md-5 col-xs-5">
																<img src="<?php echo get_template_directory_uri();?>/images/height.png" class="pull-right m-t-10">
														</div>
														<div class="col-md-7">
																<h4 class="text-left"> <output></output><small> Ft/inches</small></h4>
														</div>
														<input type="range" min="4" max="9" step="0.1" value="{{measurements.height}}" id="height" name="height" required data-rangeslider>
												</div>
												</br>
												</br>
												<div class="row">
														<div class="col-md-5 col-xs-5">
																<img src="<?php echo get_template_directory_uri();?>/images/weight.jpg" class="pull-right m-t-10">
														</div>
														<div class="col-md-7 ">
																<h4 class="text-left"> <output></output><small> pounds</small></h4>
														</div>

														<input type="range" min="100" max="500" step="1" value="{{measurements.weight}}" id="weight" name="weight" required data-rangeslider>

												</div>
												</br>
												</br>

										</div>

										<div class="col-sm-6 imageMap">

											   <a  class="hotspot-neck link" href="#demo2_tip" onclick="return false;" onmouseover="tooltip.pop(this, '#demo2_tip', {sticky:true})">
			<i class="fa fa-dot-circle-o"></i>
		   </a>
		<div style="display:none;">
			<div id="demo2_tip">
				<b>Neck(inches)</b><br />
		   <input type="text" name="neck" id="neck" class="inpt_el" value="{{measurements.neck}}" />
			</div>
		</div>

		  <a class="hotspot-chest link" href="#demo3_tip" onclick="return false;" onmouseover="tooltip.pop(this, '#demo3_tip', {sticky:true})" >
			  <i class="fa fa-dot-circle-o"></i>
		  </a>
		<div style="display:none;">
			<div id="demo3_tip">
				<b>Chest(inches)</b><br />
		   <input type="text" name="chest" id="chest" class="inpt_el" value="{{measurements.chest}}" />
			</div>
		</div>
		   <a class="hotspot-arm link" href="#demo4_tip" onclick="return false;" onmouseover="tooltip.pop(this, '#demo4_tip', {sticky:true})">
				<i class="fa fa-dot-circle-o"></i>
		   </a>
		   <div style="display:none;">
			<div id="demo4_tip">
				<b>Arm(inches)</b><br />
		   <input type="text" name="arm" id="arm" class="inpt_el" value="{{measurements.arm}}" />
			</div>
		</div>
		   <a class="hotspot-abdomen link" href="#demo5_tip" onclick="return false;" onmouseover="tooltip.pop(this, '#demo5_tip', {sticky:true})">
				<i class="fa fa-dot-circle-o"></i>
		   </a>
		<div style="display:none;">
			<div id="demo5_tip">
				<b>Abdomen(inches)</b><br />
		   <input type="text" name="abdomen" id="abdomen" class="inpt_el" value="{{measurements.abdomen}}" />
			</div>
		</div>
		   <a class="hotspot-waist link" href="#demo6_tip" onclick="return false;" onmouseover="tooltip.pop(this, '#demo6_tip', {sticky:true})">                  <i class="fa fa-dot-circle-o"></i>
	
		   </a>
		 <div style="display:none;">
			<div id="demo6_tip">
				<b>Waist(inches)</b><br />
		   <input type="text" name="waist" id="waist" class="inpt_el" value="{{measurements.waist}}" />
			</div>
		</div>
		   <a class="hotspot-hips link "  href="#demo7_tip" onclick="return false;" onmouseover="tooltip.pop(this, '#demo7_tip', {sticky:true})">
				<i class="fa fa-dot-circle-o"></i>
		 
		   </a>
						  <div style="display:none;">
			<div id="demo7_tip">
				<b>Hips(inches)</b><br />
		   <input type="text" name="hips" id="hips" class="inpt_el" value="{{measurements.hips}}" />
			</div>
		</div>  
		   <a class="hotspot-thigh link " href="#demo8_tip"  onclick="return false;" onmouseover="tooltip.pop(this, '#demo8_tip', {sticky:true})">
			   <i class="fa fa-dot-circle-o"></i>
		   </a>
						  <div style="display:none;">
			<div id="demo8_tip">
				<b>Thigh(inches)</b><br />
		   <input type="text" name="thigh" id="thigh" class="inpt_el" value="{{measurements.thigh}}" />
			</div>
		</div>  
		   <a class="hotspot-midcalf link " href="#demo9_tip" onclick="return false;" onmouseover="tooltip.pop(this, '#demo9_tip', {sticky:true})"  >
			   <i class="fa fa-dot-circle-o"></i>
		   </a>

						 <div style="display:none;">
			<div id="demo9_tip">
				<b>Midcalf(inches)</b><br />
		   <input type="text" name="midcalf" id="midcalf" class="inpt_el" value="{{measurements.midcalf}}"/>
			</div>
		</div> 
		  
  
   

		   <img id="body" src="<?php echo get_template_directory_uri();?>/images/humanbody.png" class="center-block">
										<small>Click on the blinking red spot to enter the measurement of selected part of the body in inches.</small>
										</div>
										
								</div>
								<div class="row">
												<div class="col-sm-12"><hr>
														<button type="button" id="save_measure" name="save_measure" class="btn btn-primary btn-lg pull-right aj-submit-button"><i class="fa fa-check"></i> Save</button>
												</div>
										</div>
				</div>
		</div>
</script>

<script id="home-template" type="text/template">
		<div class="container"> </br>
		<div class="aj-response-message"> </div>
	 <div class="row">
			<div class="col-md-2"> 
			</div>
		 <div class="col-md-8"> 
				 <div ui-region="x2o">
					  
					</div>
		   <br>   

	   <div ui-region="other-products" id="otherproducts">
	   
		 </div>         



	
	<div class="panel panel-default">
		  <div class="panel-body">
			<h5 class="bold margin-none mid-title ">Progress Chart <i type="button" class="fa fa-ellipsis-v pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
					 <ul class="dropdown-menu pull-right" role="menu">
						<li><a href="#" class="update">Update Measurements</a></li>
						<li><a href="#" class="history">Measurements History</a></li>
						</ul>
									  </h5>
						<form id="generate_graph" method="POST"  role="form">

						  <div class="m-t-30">
							<label for="exampleInputFile">Select</label>
							<select class="form-control" aj-field-required="true" id="param" name="param">
							  <option value="weight">Weight</option>
							  <option value="neck">Neck</option>
							  <option value="chest">Chest</option>
							  <option value="arm">Arm</option>
							  <option value="abdomen">Abdomen</option>
							  <option value="waist">Waist</option>
							  <option value="hips">Hips</option>
							  <option value="thigh">Thigh</option>
							  <option value="bmi">BMI</option>
							 
							</select>
						  </div>

					
						<div class="m-t-30">
								  <input type="hidden" id="start_date" name="start_date" >
								<input type="hidden"  id="end_date" name="end_date">
						
						
						   <label for="exampleInputFile " class="time_period">Select</label>
								<select class="form-control time_period ">
								  <option value="">--Select--</option>
								  <option value="7">Last 7 days</option>
								  <option value="30">Last 30 days</option>
								  <option value="all">All time</option>
								</select>
					  </div>
				
					<br/>
					<button type="button" name="generate" class="aj-submit-button" >Generate</button>
	<div class="clearfix"></div><br>
				<div style="width:100%">
								<div>
									<canvas id="canvas" height="450" width="600"></canvas>
								</div>
					</div>
		  	
		  	</div>

		  	<div class="col-md-2"> 
			</div>
		</div>

</div>
</script>



<script id="produts-template" type="h-template">
<div id="xoomaproduct" class="section">
				<h4 class="text-center"> List of Xooma products</h4>
	
		<div class="container">
		<div class="aj-response-message"> 
			  <div class="row">
				  <div class="col-md-2"></div>
				  <div class="col-md-8">
			   <a href="#/products" class="btn btn-primary center-block add" style="width:180px"><i class="fa fa-plus-circle"></i> Add Products</a>
			   <br>
	<div class="userproducts"></div>
	 <a href="#/products" class="btn btn-primary btn-lg pull-left add1"><i class="fa fa-plus-circle"></i> Add Products</a>
	 <button type="button" class="btn btn-primary btn-lg pull-right save_products"><i class="fa fa-check"></i>Congrats! Get started right away!</button>               
				  </div>
				  <div class="col-md-2"></div>
			  </div>
		</div>  
				</div>
	
</script>



<script id="add-product-template" type="h-template">
	<div id="listproduct" >
<div class="container">
		<div class="aj-response-message"> 
			  <div class="row">
				  <div class="col-md-12">
					<div id="cbp-vm" class="cbp-vm-switcher cbp-vm-view-grid">
						 <h4 class="text-center pull-left"> Add Products</h4>
					<div class="cbp-vm-options">
						<a href="#" class="cbp-vm-icon cbp-vm-grid cbp-vm-selected grid" data-view="cbp-vm-view-grid">Grid View</a>
						<a href="#" class="cbp-vm-icon cbp-vm-list grid" data-view="cbp-vm-view-list">List View</a>
					</div>
					<ul class="products-list">
						
					</ul>
				</div>
			</div>
				  
				  
				  </div>
				  <div class="row">
					<div class="col-sm-12">
			<hr>
<a href="#/profile/my-products" class="btn btn-primary btn-lg pull-right"><i class="fa  fa-chevron-right"></i> Next</a>
							</div>
			</div>
			  
			  </div>
   
				</div>
</script>
<script id="current-user-template" type="text/template">
<div data-placement="bottom" data-toggle="popover" title="Welcome to xooma {{display_name}}" ><img class="media-object dp img-rounded" src="{{profile_picture.sizes.thumbnail.url}}" style="width: 30px;height:30px;"></div>
				<div class="hidden popover-content">
					<div class="text-center">
						<img class="media-object dp img-rounded" src="{{profile_picture.sizes.thumbnail.url}}" style="width: 100px;height:100px;">
						<a class="btn btn-small logout-button" >Logout</a>
					</div>
				</div>
</script>


<script id="edit-product-template" type="text/template">
	<div class="sub-header">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
				   <a href="#/profile/my-products"><i class="fa fa-chevron-left"></i> Back </a> | <b>Edit Product</b>
				</div>
			</div>
		</div>
	</div>

	<div class="container"> </br></br>
	<div class="aj-response-message"></div>
		<h3 class="bold">{{name}}</h3>
		  <div class="row">
			<div class="col-md-6 col-xs-12">
				  <div class="row">
					<div class="col-md-8 col-xs-8">
						<p class="truncate" name="description">{{description}}</p>
					</div>
					<div class="col-md-4 col-xs-4">
						<img name="image" src="{{image}}" class="img-responsive"/>
					</div>
				</div>
				<br>
			</div>
			<form id="edit_product" class="form-horizontal" role="form" method="POST">
			<input type="hidden" name="frequency_type" value="{{frequency_value}}" />
			<div class="col-md-6 col-xs-12">
				<!--<b>Choose the consumption of {{name}}</b>
				<div class=" m-t-10 btn-group btn-group-justified" role="group" aria-label="...">
				  <div class="btn-group" role="group">
					<button type="button" {{anytime}}  class="btn btn-default {{anytimeclass}}">Any Time</button>
				  </div>
				  <div class="btn-group" role="group">
					<button type="button"  {{schedule}} class="btn btn-default {{scheduleclass}}">Schedule</button>
				   </div>
				</div>-->

				<div class="asperbmi">
				<div class="form-group">
				 <label for="inputEmail2" class="col-sm-6 col-xs-5  control-label">Recommended Number of Bottles</label>
				 <div class="col-sm-6 col-xs-7">
					<p class="form-control-static"><b>{{x2o}}</b></p>
				</div>
				 </div>
				 <div class="form-group">
					<h4 class="text-center margin-none"> <output></output> <small>Bottle(s)</small></h4>
					<input class="pull-left" type="range" name="x2o" min="1" max="9" step="1" value="{{defaultbmi}}" data-rangeslider>
		  <small ><i class="text-center center-block">Please slide to add bottle </i></small> 
  </div>
		   </div>
			  
			  <div class="anytime">
			  <div class="form-group">
	<label for="inputEmail3" class="col-sm-6 col-xs-5  control-label">Serving per day</label>
	<div class="col-sm-6 col-xs-7 ">
	  <select class="form-control servings_per_day " name="servings_per_day">
		  <option value="1">1</option>
		  <option value="2">2</option>
		  <option value="3">3</option>
		  
		</select>
	</div>
  </div>
  
  <div class="form-group">
	<div class="checkbox">
	<label class=" control-label">
	 &nbsp;&nbsp;&nbsp; <input type="checkbox" name="servings_diff" value="0"> Allow me set to set different quantity per serving
	<input type="hidden" name="check" id="check" value="0" /></label>
	<input type="hidden" name="timeset" id="timeset" value=""  >
  </div> 
 
  </div> 
  <div class="qty_per_servings_div">
  <div class="qtyper">
  <div class="form-group ">
	<label for="inputPassword3" class="col-sm-6  col-xs-5 control-label">Quantity Per Serving</label>
	<div class="col-sm-6 col-xs-7">
	  <select class="form-control form-control-sm col-sm-6 col-xs-3 qty_per_servings" name="qty_per_servings0" id="qty_per_servings0">
		  <option value="1">1</option>
		  <option value="2">2</option>
		  <option value="3">3</option>
		  <option value="4">4</option>
		  
		</select> <label for="inputPassword3" class="control-label"> &nbsp; Capsule</label>
	</div>
  </div>
	</div>

  </div>
  </div> 

  <div class="schedule_data ">
  <div class="form-group ">
  <label for="inputEmail3" class="col-sm-6 col-xs-6  control-label">Serving per day</label>
	<div class="col-sm-6 col-xs-6 ">
	 <div class="btn-group" role="group" aria-label="...">
	  <button type="button" data-time="Once"  class="btn schedule {{once}}">  Once</button>
	  <button type="button" data-time="Twice"   class="btn schedule {{twice}}"> Twice</button>
	  
	</div>
	</div>
  	</div>
  <div class="form-group ">
	<label for="inputPassword3" class="col-sm-6  col-xs-5 control-label"><b>Quantity Per Serving</b></label>
   <label for="inputPassword3" class="control-label col-sm-6  col-xs-7 "><B>When</B> </label>
 </div>
 <div class="form-group">
	<label for="inputEmail3" class="col-sm-2 col-xs-4 control-label">Serving1</label>
	<div class="col-sm-4 col-xs-8 ">
	  <select class="form-control qty0" name="qty_per_servings0">
		  <option value="1">1 capsule</option>
		  <option value="2">2 capsule</option>
		  <option value="3">3 capsule</option>
		  <option value="4">4 capsule</option>
		  
		</select>
	</div>
		<div class="col-sm-6 col-xs-8 xs-t-10 pull-right">
	  <select class="form-control when0" name="when0">
		  <option value="1">Morning Before meal</option>
		  <option value="2">Morning After meal</option>
		  <option value="3">Night Before Meal</option>
		  <option value="4">Night After Meal</option>
		</select>
	</div>
  </div>
  <div class="second">
  <div class="form-group">
	<label for="inputEmail3" class="col-sm-2 col-xs-4  control-label">Serving2</label>
	<div class="col-sm-4 col-xs-8">
	  <select class="form-control qty1" name="qty_per_servings1">
		  <option value="1">1 capsule</option>
		  <option value="2">2 capsule</option>
		  <option value="3">3 capsule</option>
		  <option value="4">4 capsule</option>
		</select>
	</div>
		<div class="col-sm-6 col-xs-8 xs-t-10 pull-right ">
	  <select class="form-control when1" name="when1">
		  <option value="1">Morning Before meal</option>
		  <option value="2">Morning After meal</option>
		  <option value="3">Night Before Meal</option>
		  <option value="4">Night After Meal</option>
		</select>
	</div>
  </div>
  </div>
  </div>
  <div class="noofcontainer">
  <div class="form-group">

	<label for="inputEmail3" class="col-sm-6 col-xs-7  control-label">Number of 

	container</label>
	<div class="col-sm-6 col-xs-7">
	  <select class="form-control no_of_container" name="no_of_container">
		  <option value="1">1</option>
		  <option value="2">2</option>
		  <option value="3">3</option>
		  <option value="4">4</option>
		  <option value="5">5</option>
		</select>
	</div>
  </div>
  <div class="form-group">
	<label for="inputPassword3" class="col-sm-6  col-xs-5 control-label">Available with me</label>
	<div class="col-sm-6 col-xs-7">
	  <p class="form-control-static"><span class="available">{{total}} </span>&nbsp;{{product_type_name}}(s)</p>
	  <input type="hidden" name="available" id="available" value="{{total}}" /> 
	</div>
  </div>

   <div class="form-group">

	<label for="inputPassword3" class="col-sm-6  col-xs-5 control-label">Samples given to the prospective customer</label>
	 <div class="col-sm-6 col-xs-7">

	  <input type="text" name="subtract" aj-field-type="number" value="" class="form-control"/>
	  </div>
  </div>
  </div>
<div class="form-group ">
	<label for="inputPassword3" class="col-sm-6 col-xs-5  control-label">Set remainder</label>
	<div class="col-sm-6 col-xs-7 ">
	 <div class="btn-group" role="group" aria-label="...">
	  <button type="button" data-reminder="1" class="btn  {{success}} reminder_button">  Yes</button>
	  <button type="button" data-reminder="0" class="btn {{default}} reminder_button"> No</button>
	  <input type="hidden" name="reminder" id="reminder" value="0" /> 
	</div>
	</div>
  </div>
  <div class="reminder_div">
  <div class="reminder">
<div class="form-group reminder_data">
	<label for="inputPassword3" class="col-sm-6 col-xs-5  control-label">Remind me at</label>
	<div class="col-sm-6 col-xs-7 ">
	 <input name="reminder_time0" id="reminder_time0" disabled class="fieldset__input js__timepicker form-control" type="text" value="{{reminder}}">
	</div>
  </div>
  </div>
  </div>
  <div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
	  <button type="submit" class="btn btn-primary aj-submit-button save" name="save"><i class="fa fa-check"></i> Save</button>
	  <button type="submit" class="btn btn-primary aj-submit-button save_another hidden" name="save_another">Save</button>

		 <!--<a href="#/inventory/{{id}}/view" class="btn btn-primary view hidden" >View History</a>-->
		  <button type="button" class="btn btn-link cancel"><i class="fa fa-times"></i> Cancel</button>	

	</div>
  </div>

		   
			  
			  
			  
			  </div>
		   
		</div>
	  
	</div>    
</script>

<script id="update-inventory-template" type="text/template">
   
	<div class="sub-header">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
				   <a href="#/profile/my-products"><i class="fa fa-chevron-left"></i> Back </a> | <b>Inventory details</b>
				</div>
			</div>
		</div>
	</div>
<br>
<br>
<br>
<div class="container">

<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-8">
	<div class="aj-response-message"></div>
	 <form id="inventory" class="form-horizontal" role="form" method="POST">
	  <div class="form-group">
		<label for="inputPassword3" class="col-sm-6  col-xs-7 control-label">How many containers do I have ?</label>
		<div class="col-sm-6 col-xs-5">
		  <p class="form-control-static"><b><div id="container_label"></div></b></p>
		</div>
	  </div>
		 <div class="form-group">
		<label for="inputPassword3" class="col-sm-6  col-xs-7 control-label">{{producttype}}(s) I have with me
	   <br> <small><i>Each container has {{total}} {{product_type}}(s)</i></small>
		</label>
		<div class="col-sm-6 col-xs-5">
		  <p class="form-control-static"><b>{{available}}</b></p>
		</div>
	  </div>	
	   <div class="form-group">
			<div class="col-sm-12">
				<div class=" m-t-10 btn-group btn-group-justified" role="group" aria-label="...">
				  <div class="btn-group" role="group">
					  <button type="button" class="btn entry btn-default" value="adjust">Edit inventory</button>
				  </div>
				  <div class="btn-group" role="group">
					<button type="button" class="btn entry btn-default" id="record" value="record">Refill</button>
				  </div>
		  
				</div>	
			</div>    
	</div>	 
	<!-- Record new entry --->
	
		<div class="form-group record_new">
	   
			<label for="inputPassword3" class="col-sm-6  col-xs-7 control-label">
			Number of new containers
			</label>
			<div class="col-sm-6 col-xs-5">
				<select class="form-control" name="containers" id="containers">
				<option value="0">Please select</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				</select>
			</div>
	  </div>	
	  <div class="form-group record_new">
				<label class="col-sm-6  col-xs-7 control-label">
					Number of {{product_type}}(s) which will be added
				</label>
				<div class="col-sm-6 col-xs-5">
				  <h3 class="bold-sum"><span class="newsum"><span class="ncon"></span> * <span class="ntotal"></span> = <span class="nequalto"></span></span></h3>
				</div>
	  </div>
	 
		<div class="form-group">
				<label class="col-sm-6  col-xs-7 control-label">
					Adjust
				</label>
				<div class="col-sm-6 col-xs-5 range-inventory">
				<h3 class="bold-sum  margin-none"> <output></output><small>{{product_type}}(s)</small></h3>
				 <input class="pull-left" type="range" name="slider" id="slider"  min="-20" max="20" disabled step="1" value="0" data-rangeslider>
				</div>
	  </div>
	   <div class="form-group">
				<label class="col-sm-6  col-xs-7 control-label">
					Number of {{product_type}}(s) will be updated to 
				</label>
				<div class="col-sm-6 col-xs-5">
				 <h3 class="bold-sum"><span class="finaladd"><span class="navail"></span><span class="record"> + <span class="nadd"></span></span><span class="sign"> - </span> <span class="nsub"></span>  = <span class="eqa"></span></h3>
				</div>
	  </div>
	  
	  <!-- Record new entry --->
	<!--
	<div class="form-group">
		   <label for="inputPassword3" class="col-sm-6  col-xs-7 control-label">Samples given to the prospective customer</label>
						 <div class="col-sm-6 col-xs-5">
						  </div>			 
	</div>-->			

				<div class="">
					<div class="col-sm-12 pull-right">
					<input type="hidden" id="subtract" name="subtract" aj-field-type="number" value="" />
						  <input type="hidden" name="total" value="{{total}}" / >
						  
					  <button type="submit" class="btn btn-primary aj-submit-button save pull-right" name="save"><i class="fa fa-check"></i> Save</button>
					  <!-- <a href="#/inventory/{{id}}/view" class="btn btn-link  " >View History</a>-->	

					</div>
				</div>
			 </form>
		  </div>
		<div class="col-sm-2"></div>
	 </div>
  </div>
</script>

<script id="view-inventory-template" type="text/template">
	<div class="sub-header">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
				   <a href="#/profile/my-products"><i class="fa fa-chevron-left"></i> Back </a> | <b>Inventory History</b>
				</div>
			</div>
		</div>
	</div>
<br>
<br>

<div class="container"> 
<div class="aj-response-message"> 
<div class="row">
<div class="col-sm-6 col-sm-offset-3">
<ul id='timeline' class="viewInventory">
</ul>
</div>
</div>
<hr>
<a href="#/profile/my-products" class="btn btn-primary pull-right" ><i class="fa fa-times"></i> Cancel</a>	

</div>

</script>

<script id="view-history-template" type="text/template">
<div class="sub-header">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
				   <a href="#/home"><i class="fa fa-chevron-left"></i> Back </a> | <b>History</b>
				</div>
			</div>
		</div>
	</div>
<br>
<br>
<div class="container">
<div class="row">
<div class="aj-response-message"> </div>
         <div class="col-md-2"> </div>
            <div class="col-md-8 col-xs-12">
              <h3 class="text-center "><span class="name"></span><small> ( History )</small></h3>
              <form class="form-horizontal history-calender">

                    <div id="picker_inline_fixed"></div>
                    <br/>
                    <button class="btn btn-primary" type="button" id="show" name="show">Show</button>
               </form>
              <ul id='timeline' class="viewHistory">
              
              </ul>
            </div>
            <div class="col-md-2"> </div>
</div>
</div>
</script>
<script id="measurement-history-template" type="text/template">
<div class="sub-header">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
				   <a href="#/home"><i class="fa fa-chevron-left"></i> Back </a> | <b>Progress History</b>
				</div>
			</div>
		</div>
	</div>
<br>
<br>
<div class="container">
<div class="row">
<div class="aj-response-message"> </div>
         <div class="col-md-2">
         </div>
            <div class="col-md-8 col-xs-12">
              <h3 class="text-center "><span class="name"></span><small> Progress History</small></h3>
              <form class="form-horizontal history-calender ">

                    <div id="picker_inline_fixed"></div>
                    <br/>
                    <button class="btn btn-primary" type="button" id="show" name="show">Show</button>
               </form>
              <ul id='timeline' class="viewHistory ">
              
              </ul>
            </div>
            <div class="col-md-2">
         </div>
        </div>
      </div>
</script>
<script id="asperbmi-template" type="text/template">
<div class="sub-header">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
				   <a href="#/home"><i class="fa fa-chevron-left"></i> Back </a> | <b>Bottle Consumption</b>
				</div>
			</div>
		</div>
	</div>
<br>
<br>
<div class="container">	
<div class="aj-response-message"></div>
  <div class="row">
  <br>
	
		<h4 class="text-center">Serving 1<small>(Bonus)</small></h4>
<!-- <h4 class="text-center"><span class="bottlecnt">{{confirm}}</span>/1<small>Bottle</small></h4>-->
		<div class="row">
			
			<div class="col-md-4 col-xs-3"> 
			</div>
			<div class="col-md-4 col-xs-6">
			
				<div class="water-100 water-marker"> 
					100%<br>
					Consumed ------------

				</div>
				<div class="water-75 water-marker"> 
					75%<br>
					Consumed ------------
				</div>
				<div class="water-50 water-marker"> 
					50%<br>
					Consumed ------------
				</div>
				<div class="water-25 water-marker"> 
					25%<br>
					Consumed ------------
				</div>
			<!--- Bottle UI -->

				<div> <img src="<?php echo site_url() ?>/wp-content/themes/twentytwelve/xoomaapp/images/bottle-cap.png" class="center-block"/></div>
				<div class="bottle-bg">
						<div class="bottle"></div>
						<div class="bottle-msg">Completed 25% </div>
				 </div>
				 	<small class="text-center center-block">Swipe down the bottle to consume</small>	
			<!--- Bottle UI -->
			</div>

			 <div class="col-md-4 col-xs-3">
			</div>
		</div>
		
	   <div class="row m-t-20">
	   		<div class="col-sm-5"></div>
			<div class="col-sm-2">
				<input type="hidden" name="percentage" id="percentage" value="0" / >
				<input type="hidden" name="meta_id" id="meta_id" value="" / >
			  	<button type="submit" data-count="0" id="confirm" class="change-progress btn btn-primary  center-block" > Confirm </button>
              	
			</div>
			<div class="col-sm-5"><button class="reset-progress btn-link pull-left" type="button"> <i class="fa fa-refresh"></i> Reset</button></div>
		</div>
  </div>
	
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Modal title</h4>
	  </div>
	  <div class="modal-body">
		...
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="button" id="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save changes</button>
	  </div>
	</div>
  </div>
</div>

</script>

<script id="schedule-template" type="text/template">
<div class="container"> </br></br>
<div class="aj-response-message"></div>
<form id="consume" class="form-horizontal" role="form" method="POST">
<div><span class="day">{{day}}</span></div>
<div><span class="today">{{today}}</span></div>
<div><span>Bonus:</span><span class="bonus">{{bonus}}</span></div>
{{#no_servings}}
<a href="#" data-target="#mydataModal" class="servings" data-value="{{meta_id}}" data-qty="{{qty}}">

{{#servings}}
<div class="{{newClass}}"></div>
{{/servings}}

{{/no_servings}}
<br/></a>

<br/>
<a href="#" data-toggle="modal" class="original {{original}}" ></a>

<input type="hidden" name="schduleid"  id="schduleid" value="{{scheduleid}}" />
<input type="hidden" name="meta_id"  id="meta_id" value="" />

</div>
<div class="hidden" id="mydataModal" >
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Modal title</h4>
	  </div>
	  <div class="modal-body">
		<input type="text" name="qty"  id="qty" value="" />
	  </div>
	  <div class="modal-footer">
		<button type="button"  class="btn btn-default cancel" data-dismiss="modal">Close</button>
		<button type="button" id="intake" class="btn btn-primary intake"> <i class="fa fa-check"></i> Save changes</button>
	  </div>
	</div>
  </div>
</div>
</form>
</script>