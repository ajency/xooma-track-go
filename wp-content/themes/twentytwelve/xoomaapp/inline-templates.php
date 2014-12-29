
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
												<li><a id="product" href="#/profile/my-products"><i class="fa fa-check-circle-o"></i> 
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
														<label for="text1" class=" col-sm-3 control-label">xooma id  <span class="requiredField text-danger"> * </span></label>
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
		<div id="xoomaproduct" class="section">
                <h4 class="text-center"> List Of xooma products</h4>

        <div class="container">
              <div class="row">
                  <div class="col-md-3"></div>
                  <div class="col-md-6">

                      <br>
                            <ul class="list-unstyled list-style userProductList">

                             </ul>



                  </div>
                  <div class="col-md-3">
                  	</div>
              </div>

        </div>

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


	<div id="cbp-vm" class="cbp-vm-switcher cbp-vm-view-grid">
					<div class="cbp-vm-options">
						<a href="#" class="cbp-vm-icon cbp-vm-grid cbp-vm-selected" data-view="cbp-vm-view-grid">Grid View</a>
						<a href="#" class="cbp-vm-icon cbp-vm-list" data-view="cbp-vm-view-list">List View</a>
					</div>
					<ul>
						<li>
							<a class="cbp-vm-image" href="#"><img src="images/1.png"></a>
							<h3 class="cbp-vm-title">Silver beet</h3>
							<div class="cbp-vm-price">$19.90</div>
							<div class="cbp-vm-details">
								Silver beet shallot wakame tomatillo salsify mung bean beetroot groundnut.
							</div>
							<a class="cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
						</li>
						<li>
							<a class="cbp-vm-image" href="#"><img src="images/2.png"></a>
							<h3 class="cbp-vm-title">Wattle seed</h3>
							<div class="cbp-vm-price">$22.90</div>
							<div class="cbp-vm-details">
								Wattle seed bunya nuts spring onion okra garlic bitterleaf zucchini.
							</div>
							<a class="cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
						</li>
						<li>
							<a class="cbp-vm-image" href="#"><img src="images/3.png"></a>
							<h3 class="cbp-vm-title">Kohlrabi bok</h3>
							<div class="cbp-vm-price">$5.90</div>
							<div class="cbp-vm-details">
								Kohlrabi bok choy broccoli rabe welsh onion spring onion tatsoi ricebean kombu chard.
							</div>
							<a class="cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
						</li>
						<li>
							<a class="cbp-vm-image" href="#"><img src="images/4.png"></a>
							<h3 class="cbp-vm-title">Melon sierra</h3>
							<div class="cbp-vm-price">$12.90</div>
							<div class="cbp-vm-details">
								Melon sierra leone bologi carrot peanut salsify celery onion jícama summer purslane.
							</div>
							<a class="cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
						</li>
						<li>
							<a class="cbp-vm-image" href="#"><img src="images/5.png"></a>
							<h3 class="cbp-vm-title">Celery carrot</h3>
							<div class="cbp-vm-price">$15.00</div>
							<div class="cbp-vm-details">
								Celery carrot napa cabbage wakame zucchini celery chard beetroot jícama sierra leone.
							</div>
							<a class="cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
						</li>
						<li>
							<a class="cbp-vm-image" href="#"><img src="images/6.png"></a>
							<h3 class="cbp-vm-title">Catsear</h3>
							<div class="cbp-vm-price">$20.00</div>
							<div class="cbp-vm-details">
								Catsear cabbage tomato parsnip cucumber pea brussels sprout spring onion shallot swiss .
							</div>
							<a class="cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
						</li>
						<li>
							<a class="cbp-vm-image" href="#"><img src="images/7.png"></a>
							<h3 class="cbp-vm-title">Mung bean</h3>
							<div class="cbp-vm-price">$88.00</div>
							<div class="cbp-vm-details">
								Mung bean taro chicory spinach komatsuna fennel.
							</div>
							<a class="cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
						</li>
						<li>
							<a class="cbp-vm-image" href="#"><img src="images/8.png"></a>
							<h3 class="cbp-vm-title">Epazote</h3>
							<div class="cbp-vm-price">$34.90</div>
							<div class="cbp-vm-details">
								Epazote soko chickpea radicchio rutabaga desert raisin wattle seed coriander water.
							</div>
							<a class="cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
						</li>
						<li>
							<a class="cbp-vm-image" href="#"><img src="images/9.png"></a>
							<h3 class="cbp-vm-title">Tatsoi caulie</h3>
							<div class="cbp-vm-price">$21.50</div>
							<div class="cbp-vm-details">
								Tatsoi caulie broccoli rabe bush tomato fava bean beetroot epazote salad grape.
							</div>
							<a class="cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
						</li>
						<li>
							<a class="cbp-vm-image" href="#"><img src="images/10.png"></a>
							<h3 class="cbp-vm-title">Endive okra</h3>
							<div class="cbp-vm-price">$18.50</div>
							<div class="cbp-vm-details">
								Endive okra chard desert raisin prairie turnip cucumber maize avocado.
							</div>
							<a class="cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
						</li>
						<li>
							<a class="cbp-vm-image" href="#"><img src="images/1.png"></a>
							<h3 class="cbp-vm-title">Bush tomato</h3>
							<div class="cbp-vm-price">$9.00</div>
							<div class="cbp-vm-details">
								Bush tomato peanut shallot turnip prairie turnip gram desert raisin.
							</div>
							<a class="cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
						</li>
						<li>
							<a class="cbp-vm-image" href="#"><img src="images/2.png"></a>
							<h3 class="cbp-vm-title">Yarrow leek</h3>
							<div class="cbp-vm-price">$22.50</div>
							<div class="cbp-vm-details">
								Yarrow leek cabbage amaranth onion salsify caulie kale desert raisin prairie turnip garlic.
							</div>
							<a class="cbp-vm-icon cbp-vm-add" href="#">Add to cart</a>
						</li>
					</ul>
				</div>
			</div>


</script>
<script id="current-user-template" type="text/template">
markupup
</script>
