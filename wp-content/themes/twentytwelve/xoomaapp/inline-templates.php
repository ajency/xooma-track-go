<script id="login-template" type="text/template">
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
											<div ui-region="currentUser" class="pull-right">

											</div>
										</div>
								</div>
						</div>
				</nav>
		</div>
		<div class="clearfix"></div>
		<div ui-region style="margin-top:60px"></div>
</script>
<script id="profile-template" type="text/template">
		<div class="sub-header">
				<div class="container">
						<div class="row">
								<div class="col-sm-12">
										<ul class="list-inline">
												<li class="selected"><a id="profile" href="#/profile/personal-info"><i class="fa fa-check-circle-o"></i>
														<span class="hidden-xs">PERSONAL INFO</span></a>
												</li>
												<li><a id="measurement" href="#/profile/measurements"><i class="fa fa-check-circle-o"></i>
														<span class="hidden-xs">MEASUREMENT</span></a>
												</li>
												<li><a id="product" href="#/12/products"><i class="fa fa-check-circle-o"></i> 
														<span class="hidden-xs">MYPRODUCTS</span></a>
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
														<label for="text1" class=" col-sm-3 control-label">xooma id</label>
														<div class="col-sm-9">
																<input type="number" aj-inputmask="999999" aj-field-required="true" aj-field-minlength="6" aj-field-maxlength="6"   class="form-control " name="profile[xooma_member_id]">
														</div>
												</div>
												<div class="form-group">
														<label for="text2" class=" col-sm-3 control-label">Name</label>
														<div class="col-sm-9">
																<input type="text" readonly class="form-control" name="display_name">
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
																<input type="text" aj-inputmask="(999) 999 9999" class="form-control" name="profile[phone_no]">
														</div>
												</div>
												<div class="form-group">
														<label for="text5" class=" col-sm-3 control-label">Gender</label>
														<div class="col-sm-9">
																<div class="rd-gender">
																		<label class="wrap">
																				<input type="radio" aj-field-required="true" name="profile[gender]" class="radio" value="male" />
																				<span class="rd-visual male" title="Male"></span>
																		</label>
																		<label class="wrap">
																				<input type="radio" aj-field-required="true" name="profile[gender]" class="radio" value="female" />
																				<span class="rd-visual female" title="Female"></span>
																		</label>
																</div>
														</div>
												</div>
												<div class="form-group">
														<label for="text7" class=" col-sm-3 control-label">Birth date</label>
														<div class="col-sm-9">
																<input class="form-control" type="text" name="profile[birth_date]" required />
														</div>
												</div>
												<div class="form-group">
														<label for="text8" class=" col-sm-3 control-label">Time Zone</label>
														<div class="col-sm-9">
																<select name="profile[timezone]">
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
														<div class="col-md-5 col-xs-6">
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
														<div class="col-md-5 col-xs-6">
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
												<a id="element1" tabindex="0" class="popover-element hotspot-neck " data-toggle="popover" title="Neck" data-content="<input type='text' name='neck' id='neck' value='{{measurements.neck}}'>"><i class="fa fa-dot-circle-o"></i></a>
												<a id="element2" tabindex="0" class="popover-element hotspot-chest " data-toggle="popover" title="Chest" data-content="<input type='text' name='chest' id='chest' value='{{measurements.chest}}'>"><i class="fa fa-dot-circle-o"></i></a>
												<a id="element3" tabindex="0" class="popover-element hotspot-arm " data-toggle="popover" title="Upper Arm" data-content="<input type='text' name='arm' id='arm' value='{{measurements.arm}}'>"><i class="fa fa-dot-circle-o"></i></a>
												<a id="element4" tabindex="0" class="popover-element hotspot-abdomen " data-toggle="popover" title="Abdomen" data-content="<input type='text' name='abdomen' id='abdomen' value='{{measurements.abdomen}}'>"><i class="fa fa-dot-circle-o"></i></a>
												<a id="element5" tabindex="0" class="popover-element hotspot-waist " data-toggle="popover" title="Waist" data-content="<input type='text' name='waist' id='waist' value='{{measurements.waist}}'>"><i class="fa fa-dot-circle-o"></i></a>
												<a id="element6" tabindex="0" class="popover-element hotspot-hips " data-toggle="popover" title="Hips" data-content="<input type='text' name='hips' id='hips' value='{{measurements.hips}}'>"><i class="fa fa-dot-circle-o"></i></a>
												<a id="element7" tabindex="0" class="popover-element hotspot-thigh " data-toggle="popover" title="Upper Thigh" data-content="<input type='text' name='thigh' id='thigh' value='{{measurements.thigh}}'>"><i class="fa fa-dot-circle-o"></i></a>
												<a id="element8" tabindex="0" class="popover-element hotspot-midcalf " data-toggle="popover" title="Mid Calf" data-content="<input type='text' name='midcalf' id='midcalf' value='{{measurements.midcalf}}'>"><i class="fa fa-dot-circle-o"></i></a>
												<img src="<?php echo get_template_directory_uri();?>/images/humanbody.png" class="center-block">
										</div>
										<div class="row">
												<div class="col-sm-12">
														<button type="submit" id="save_measure" name="save_measure" class="btn btn-primary btn-lg pull-right">Save</button>
												</div>
										</div>
								</div>
				</div>
		</div>
</script>

<script id="home-template" type="text/template">
		<div>
				Add Home template here
		</div>
</script>



<script id="produts-template" type="h-template">
	<div id="xoomaproduct" class="section">
                <h4 class="text-center"> List Of xooma products</h4>
    
        <div class="container">
              <div class="row">
                  <div class="col-md-3"></div>
                  <div class="col-md-6">
                  <a href="#/products" class="btn btn-primary btn-lg center-block" ><i class="fa fa-plus-circle"></i> Add Products</a>
               
                      <br>
                            <ul class="list-unstyled list-style">
                                   <li> 
                                         <div class="list-title">
                                                <h5 class="bold text-primary">X2O</h5>
                                                <h6>Anytime</h6>
                                         </div> 
                                          <img src="../img/bottle.png" height="80px"/>
                                          <img src="../img/bottle.png "height="80px"/>
                                          <img src="../img/bottle.png" height="80px"/>
                                         <img src="../img/bottle.png "height="80px"/>
                                          <img src="../img/bottle.png" height="80px"/>
                                   </li>
                                   <li> 
                                         <b class="text-success"> Any time Suppliments</b>
                                              <div class="list-title">
                                                        <h5 class="bold text-primary">FOCUS UP</h5>
                                                        <h6>Twice a day <b>3 capsules </b></h6>
                                               </div> 
                                               
                                                 <div class="list-title">
                                                        <h5 class="bold text-primary">Xooma Blast</h5>
                                                        <h6>Once a day <b>1 Stick pack </b></h6>
                                               </div> 
                                    </li>
                                    <li> 
                                        <b class="text-success"> Suppliments Define Time</b>
                                            <div class="list-title">
                                                        <h5 class="bold text-primary">Berry Balance</h5>
                                                        <h6> <i class="fa fa-sun-o text-info"></i> <b>3 capsules                                                        </b> &nbsp;&nbsp;
                                            <i class="fa fa-moon-o text-info"></i> <b>2 capsules </b> </h6>
                                            </div> 
                                    
                                    </li>
                             </ul>
                               


                  </div>
                  <div class="col-md-3"></div>
              </div>

        </div>  
                </div>

</script>



<script id="add-product-template" type="h-template">

	<div>
		<ul class="productList">
			

		</ul>

	</div>



</script>
