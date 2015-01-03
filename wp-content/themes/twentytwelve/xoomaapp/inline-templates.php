
<script id="login-template" type="text/template">
    <div class="topheader">
        <nav class="navbar " role="navigation">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 col-xs-5">
                        <div class="navbar-header">
                            <a href="#">
                                <img alt="Brand" src="<?php echo get_template_directory_uri(); ?>/img/logo.png" class="img-reponsive" width="200px">
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-9 col-xs-7">
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
					<div class="col-sm-12">
							<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
									<br>
									<br>

									<ol class="carousel-indicators">
										<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
										<li data-target="#carousel-example-generic" data-slide-to="1"></li>
										<li data-target="#carousel-example-generic" data-slide-to="2"></li>
									</ol>
									<div class="carousel-inner" role="listbox">
										<div class="item active">
											<img src="<?php echo get_template_directory_uri(); ?>/images/slider1.jpg" alt="" class="center-block">
											<div class="carousel-caption text-center">
													<h3>Xooma Track & Go</h3>
													<p>Has been desiged to help you track your personal x2o water consumption</p>
											</div>
										</div>
										<div class="item ">
											<img src="<?php echo get_template_directory_uri(); ?>/images/slider1.jpg" alt="" class="center-block">
											<div class="carousel-caption text-center">
													<h3>Xooma Track & Go</h3>
													<p>Has been desiged to help you track your personal x2o water consumption</p>
											</div>
										</div>
										<div class="item ">
											<img src="<?php echo get_template_directory_uri(); ?>/images/slider1.jpg" alt="" class="center-block">
											<div class="carousel-caption text-center">
													<h3>Xooma Track & Go</h3>
													<p>Has been desiged to help you track your personal x2o water consumption</p>
											</div>
										</div>
									</div>

							</div>

							<!-- Login Button  -->
					</div>
			</div>
			<button type="button" fb-scope="email" class="btn btn-primary btn-lg center-block aj-fb-login-button">Login with facebook</button>
	</div>
</script>
<script id="404-template" type="text/template">
		<h3>Add 404 View Here</h3>
</script>


<script id="xooma-app-template" type="text/template">
		<div class="topheader">
				<nav class="navbar " role="navigation">
						<div class="container">
								<div class="row">
										<div class="col-sm-3 col-xs-5">
												<div class="navbar-header">
														<a href="#">
																<img alt="Brand" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/images/logo.png" class="img-reponsive" width="200px">
															</a>
												</div>
										</div>
										<div class="col-sm-9 col-xs-7">
											<div ui-region="currentUser" class="pull-right user-data">

											</div>
										</div>
										<div class="col-sm-9 col-xs-7">
                        <a href="#menu">
                            <h5><i class="fa fa-cog pull-right "></i></h5>
                        </a>
                    </div>
								</div>
						</div>
				</nav>
		</div>
		<div class="clearfix"></div>
		 <nav id="menu">
        <ul>
            <li><a  class="link" href="#/home">Home</a>
            </li>
            <li><a  class="link" href="#/profile/personal-info">Profile</a>
            </li>
            <li><a  class="link" href="#/profile/measurements">Measurements</a>
            </li>
            <li><a  class="link" href="#/profile/my-products">My Products</a>
            </li>
        </ul>
    </nav>
		<div ui-region style="margin-top:60px"></div>
</script>
<script id="profile-template" type="text/template">
		<div class="sub-header">
				<div class="container">
						<div class="row">
								<div class="col-sm-12">
										<ul class="list-inline">
												<li><a id="profile" href="#/profile/personal-info"><i class="fa fa-check-circle-o"></i>
														PERSONAL INFO</a>
												</li>
												<li><a id="measurement" href="#/profile/measurements"><i class="fa fa-check-circle-o"></i>
														MEASUREMENT</a>
												</li>
												<li><a id="product" href="#/profile/my-products"><i class="fa fa-check-circle-o"></i> 
														MYPRODUCTS</a>
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
		<h2>THis is the settings template </h2>
</script>
<script id="no-access-template" type="text/template">
		{{#if no_access}}
		<h1>Add no access View Here</h1> {{/if}} {{#if no_access_login}}
		<h1>Add no access with login options View Here</h1> {{/if}} {{#if not_defined}}
		<h1>This view is not configured. Please contact administrator</h1> {{/if}}
</script>
<script id="profile-personal-info-template" type="text/template">

		<div id="personalinfo" class="section">

				<div class="container">

						<div class="aj-response-message"></div>
						<form class="form-horizontal update_user_details" role="form">


								<img src="{{profile_picture.sizes.thumbnail.url}}" alt="{{display_name}}" class="img-circle center-block profile-picture" width="150px" height="150px">

								<h6 class="text-center bold">You are on the the spot!</h6>
								<p class="text-center">Let us know something about you.</p>
								<br>
								<div class="row">
										<div class="col-sm-offset-3 col-sm-6">


												<div class="form-group">
														<label for="text1" class=" col-sm-3 control-label">xooma id  <span class="requiredField text-danger"> * </span></label>
														<div class="col-sm-9">
																<input type="text"  aj-field-type="number" aj-field-equalTo="6" aj-field-required="true" class="form-control " name="profile[xooma_member_id]">
														</div>
												</div>
												<div class="form-group">
														<label for="text2" class=" col-sm-3 control-label">Name</label>
														<div class="col-sm-9">
																<input type="text"  readonly class="form-control" name="display_name">
														</div>
												</div>
												<div class="form-group">
														<label for="text3" class="col-sm-3 control-label">Email</label>
														<div class="col-sm-9">
																<input type="text" readonly class="form-control" name="user_email">
														</div>
												</div>
												<div class="form-group">
														<label for="text4" class="col-sm-3 control-label">Phone</label>
														<div class="col-sm-9">
																<input type="text" aj-field-type="number" class="form-control" name="profile[phone_no]">
														</div>
												</div>
												<div class="form-group">
														<label for="text5" class=" col-sm-3 control-label">Gender  <span class="requiredField text-danger"> * </span></label>
														<div class="col-sm-9">
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
														<label for="text7" class=" col-sm-3 control-label">Birth date  <span class="requiredField text-danger"> * </span></label>
														<div class="col-sm-9">
																<input class="form-control" type="text" name="profile[birth_date]" required />
														</div>
												</div>
												<div class="form-group">
														<label for="text8" class=" col-sm-3 control-label">Time Zone</label>
														<div class="col-sm-9">
																<select class="form-control" name="profile[timezone]">
																		<option value="Asia/Tehran">(GMT+03:30) Tehran</option>
																		<option value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>
																		<option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
																		<option value="Asia/Kabul">(GMT+04:30) Kabul</option>
																		<option value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
																		<option value="Asia/Tashkent">(GMT+05:00) Tashkent</option>
																		<option value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
																		<option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
																		<option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
																		<option value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>
																		<option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
																		<option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
																		<option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
																		<option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
																		<option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
																		<option value="Australia/Perth">(GMT+08:00) Perth</option>
																		<option value="Australia/Eucla">(GMT+08:45) Eucla</option>
																		<option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
																		<option value="Asia/Seoul">(GMT+09:00) Seoul</option>
																		<option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
																		<option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
																		<option value="Australia/Darwin">(GMT+09:30) Darwin</option>
																		<option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
																		<option value="Australia/Hobart">(GMT+10:00) Hobart</option>
																		<option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
																</select>
														</div>
												</div>

												<div class="row">
														<div class="col-sm-12">
																<button type="submit" id="add_user" name="add_user" class="btn btn-primary btn-lg pull-right aj-submit-button">Save</button>
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
				<div class="aj-response-message"></div>
						<form id="add_measurements" class="form-horizontal" role="form" method="POST">
								<div class="row">
										<div class="col-sm-6">
												<h5 class="text-center bold">Set your mesurements</h5>
												<p class="text-center">Knowing this information will help us determine the ideal amount of X2O water that your bodyneeds on a daily basis </p>
												<div class="row">
												<input type="hidden" name="date_field" value="{{measurements.date}}" />
														<div class="col-md-5 col-xs-5">
																<img src="<?php echo get_template_directory_uri();?>/images/height.png" class="pull-right m-t-40">
														</div>
														<div class="col-md-7">
																<h4 class="text-left"> <output></output><small>Feet</small></h4>
														</div>
														<input type="range" min="4" max="9" step="0.1" value="{{measurements.height}}" id="height" name="height" required data-rangeslider>
												</div>
												</br>
												</br>
												<div class="row">
														<div class="col-md-5 col-xs-5">
																<img src="<?php echo get_template_directory_uri();?>/images/weight.jpg" class="pull-right m-t-40">
														</div>
														<div class="col-md-7 ">
																<h4 class="text-left"> <output></output><small>pounds</small></h4>
														</div>
														<input type="range" min="25" max="500" step="1" value="{{measurements.weight}}" id="weight" name="weight" required data-rangeslider>
												</div>
												</br>
												</br>
										</div>

										<div class="col-sm-6 imageMap">

												<a  class="hotspot-neck " data-bind="popover: {template: 'popoverBindingTemplate1', title: 'Neck'}">
                        <i class="fa fa-dot-circle-o"></i>
           </a>
          <a class="hotspot-chest " data-bind="popover: {template: 'popoverBindingTemplate2', title: 'Chest'}">
              <i class="fa fa-dot-circle-o"></i>
          </a>

           <a class="hotspot-arm " data-bind="popover: {template: 'popoverBindingTemplate3', title: 'Arm'}">
                <i class="fa fa-dot-circle-o"></i>
           </a>
           <a class="hotspot-abdomen " data-bind="popover: {template: 'popoverBindingTemplate4', title: 'Abdomen'}">
                <i class="fa fa-dot-circle-o"></i>
           </a>
           <a class="hotspot-waist " data-bind="popover: {template: 'popoverBindingTemplate5', title: 'Waist'}">                  <i class="fa fa-dot-circle-o"></i>
           </a>
           <a class="hotspot-hips " data-bind="popover: {template: 'popoverBindingTemplate6', title: 'Hips'}">
                <i class="fa fa-dot-circle-o"></i>
           </a>
           <a class="hotspot-thigh " data-bind="popover: {template: 'popoverBindingTemplate7', title: 'Thigh'}" >
               <i class="fa fa-dot-circle-o"></i>
           </a>
           <a class="hotspot-midcalf "  data-bind="popover: {template: 'popoverBindingTemplate8', title: 'Midcalf'}" >
               <i class="fa fa-dot-circle-o"></i>
           </a>
          
  
   

           <img src="<?php echo get_template_directory_uri();?>/images/humanbody.png" class="center-block">
										</div>
										
								</div>
                                <div class="row">
												<div class="col-sm-12">
														<button type="button" id="save_measure" name="save_measure" class="btn btn-primary btn-lg pull-right aj-submit-button">Save</button>
												</div>
										</div>
				</div>
		</div>
</script>

<script id="home-template" type="text/template">
		<div class="container"> </br></br></br>
        <div class="row">
            <div class="col-md-4 col-xs-4"></div>
            <div class="col-md-4 col-xs-4"> <h4 class="text-center">TODAY </h4></div>
            <div class="col-md-4 col-xs-4"> <h5 class="text-center">HISTORY <i class="fa fa-angle-right"></i></h5> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                  <div class="fill-bottle">        
                    <div class="glass">
                            <span class="liquid" style="height: 100%"></span>
                     </div>
                  </div>
                	<div id="canvas-holder">
                        <canvas id="chart-area" width="500" height="500"/>
                    </div>
            
            </div>
        </div>
     <div class="row">
            <div class="col-md-3"> 
            </div>
         <div class="col-md-6"> 
         <div ui-region="x2o">
              
            </div>
           <br>   
       <div ui-region="other-products">
       
         </div>         

        </div>
    </div>
</script>



<script id="produts-template" type="h-template">
	<div id="xoomaproduct" class="section">
                <h4 class="text-center"> My xooma products</h4>

        <div class="container">
        <div class="aj-response-message"></div>
              <div class="row">
                  <div class="col-md-3"></div>
                  <div class="col-md-6">
                  <a href="#/products" class="btn btn-primary btn-lg center-block" ><i class="fa fa-plus-circle"></i> Add Products</a>

                      <br>
                            <ul class="list-unstyled list-style userProductList">

                             </ul>



                  </div>
                  <div class="col-md-3">
                  	</div>
              </div>

        </div>
        <div class="row">
			<div class="col-sm-12">
					<a href="#/home" class="btn btn-primary btn-lg center-block save_products" ><i class="fa fa-plus-circle"></i> Save</a>
			</div>
	</div>
</div>

</script>



<script id="add-product-template" type="h-template">


	<div id="listproduct" class="section">
          <br>  <br>       
    
        <div class="container">
              <div class="row">
                  <div class="col-md-12">
                  	<div id="cbp-vm" class="cbp-vm-switcher cbp-vm-view-grid">
                         <h4 class="text-center pull-left"> Add Products</h4>
					<div class="cbp-vm-options">
						<a href="#" class="cbp-vm-icon cbp-vm-grid cbp-vm-selected" data-view="cbp-vm-view-grid">Grid View</a>
						<a href="#" class="cbp-vm-icon cbp-vm-list" data-view="cbp-vm-view-list">List View</a>
					</div>
					<ul class="products-list">
						
					</ul>
				</div>
			</div>
                  
                  
                  </div><br/>
                  <div class="row">
					<div class="col-sm-12">
							<a class="cbp-vm-icon cbp-vm-add" href="#/home">Next</a>	</div>
			</div>
              
              </div>

   
                </div>


</script>
<script id="current-user-template" type="text/template">
markupup
</script>
