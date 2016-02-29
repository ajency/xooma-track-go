<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">

    <script id="login-template" type="text/template">
<div class="topheader" id="logintemplate">
        <nav class="navbar " role="navigation">
            <div class="container mobile-container">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                   
                                <img alt="Brand" src="<?php echo get_template_directory_uri(); ?>/img/logo.png" class="tp-img-align  center-block" width="200px">
                         
                        
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

    <br>

    <div class="slider single-item">
                    <div><h3><img src="<?php echo get_template_directory_uri(); ?>/images/slider1.jpg" alt="" class="center-block img-responsive"></h3>
                        <h5 class="text-center">Fun and Easy way to keep track <br>of your Xooma product usage</h5>
                    </div>
                     <div><h3>  <img src="<?php echo get_template_directory_uri(); ?>/images/low-stock.png" alt="" class="center-block img-responsive" ></h3>
                    <h5 class="text-center"> Timely notification and email reminders<br>to support your product use and health goals</h5>
                    </div>
                    
                    <div><h3> <img src="<?php echo get_template_directory_uri(); ?>/images/fitness.png" alt="" class="center-block img-responsive" ></h3>
                    <h5 class="text-center">Measure the improvements <br> in your shape and size</h5>
                    </div>
                   <div><h3>   <img src="<?php echo get_template_directory_uri(); ?>/images/reminder.png " alt="" class="center-block img-responsive"  ></h3>
                    <h5 class="text-center"> Get notified when you are running low<br>on your xooma products </h5>
                    </div>
                    
                           <div><h3>   <img src="<?php echo get_template_directory_uri(); ?>/images/products-1.jpg " alt="" class="center-block img-responsive"  ></h3>
                    <h6 class="text-center"> Xooma Track & Go has been designed to help you track your personal X2O Water Consumption and 

additionally help you properly maintain your personal regime of Xooma’s entire supplement line. </h6>
                    </div>
                    <div><h3>   <img src="<?php echo get_template_directory_uri(); ?>/images/products-2.jpg " alt="" class="center-block img-responsive"  ></h3>
                    <h6 class="text-center"> As you may already know, Xooma’s X2O helps you get the most out of your water by increasing the 

alkalinity (pH) of your water, optimizing hydration, and revitalizing your body with 70+ essential trace 

minerals.  Now “Xooma Track & Go” can help you get the most out of your X2O and other Xooma 

Products.</h6>
                    </div>
                    <div><h3> <img src="<?php echo get_template_directory_uri(); ?>/images/platform.png" alt="" class="center-block img-responsive"  ></h3>
          
                        <div class="row app-link">
                            <div class="col-md-6 col-xs-6"> <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/google-btn.png" alt="" class="center-block "  ></a></div>
                            <div class="col-md-6 col-xs-6"> <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/apple-btn.png" alt="" class="center-block "  ></a></div>
                        </div>
                 
                    </div>
                   
                </div>



                            </div>
    <div class="col-sm-3">
            </div>
                            <!-- Login Button  -->
                    </div>
            </div>
            <br>
            <button type="button" fb-scope="email" class="btn btn-primary btn-lg center-block aj-fb-login-button">Login with facebook</button><br>
            <a href="#/signin"><button type="button" class="btn btn-primary btn-lg center-block aj-log-in-button">Login In</button></a><br>
            <a href="#/signup"><button type="button" class="btn-lg btn center-block aj-sign-up-button">Sign Up</button></a>
            

    </div>
    </script>

    <script id="sign_up_template" type="text/template">
        <div id="signuptemplate" class="section-list">
            <div class="container">
                <div class="row">
                    <div class="col-sm-offset-3 col-sm-6">
                        <form role="form" class="form-horizontal user-sign-up">
                            <h5 class="text-center bold margin-none">Register</h5>
                            <br>
                            <div class="aj-response-message"> </div>
                            <input type="hidden" value="" id="current_time" name="current_time" class="" />

                                <div class="form-group">
                                    <label for="text1" class=" col-sm-3 col-xs-4 col-lg-4 control-label">Xooma ID  <span class="requiredField text-danger"> * </span></label>
                                        <div class="col-sm-9 col-xs-8 col-lg-8">
                                            <input type="text"  aj-field-type="number" aj-field-equalTo="6" aj-field-required="true" class="form-control " name="profile[xooma_member_id]">
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-4 col-lg-4 control-label">Full name:  <span class="requiredField text-danger"> * </span></label>
                                    <div class="col-sm-9 col-xs-8 col-lg-8">
                                    <input type="text" class="form-control tabelements" name="fullname" id="firstname" placeholder="Full name" required />
                                    </div>
                                    <!--input type="text" name="lastname" id="lastname" placeholder="Last name" /-->
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-4 col-lg-4 control-label">Email:  <span class="requiredField text-danger"> * </span></label>
                                    <div class="col-sm-9 col-xs-8 col-lg-8">
                                    <input type="email" class="form-control tabelements" name="email" id="email" required />
                                    </div>
                                    </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-4 col-lg-4 control-label">Password:  <span class="requiredField text-danger"> * </span></label>
                                    <div class="col-sm-9 col-xs-8 col-lg-8">
                                    <input type="password" class="form-control tabelements" name="password" id="password" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-4 col-lg-4 control-label">Re-type Password:  <span class="requiredField text-danger"> * </span></label>
                                    <div class="col-sm-9 col-xs-8 col-lg-8">
                                    <input type="password" class="form-control tabelements repassword" name="repassword" id="repassword" required />
                                    <span style="display:none;" class="parsley-errors-list filled reError"></span>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="text5" class=" col-sm-3 col-xs-4 col-lg-4 control-label">Gender  <span class="requiredField text-danger"> * </span></label>
                                    <div class="col-sm-9 col-xs-8 col-lg-8">
                                        <div class="rd-gender">
                                        <label class="wrap pull-left">
                                        <input type="radio" aj-field-required="true" name="profile[gender]" class="radio tabelements" value="male" />
                                        <span class="rd-visual male" title="Male"></span>
                                        </label>

                                        <label class="wrap pull-left">
                                        <input type="radio" aj-field-required="true" name="profile[gender]" class="radio tabelements" value="female" />

                                        <span class="rd-visual female" title="Female"></span>
                                        </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="text7" class=" col-sm-3 col-xs-4 col-lg-4 control-label">Birth date  <span class="requiredField text-danger"> * </span></label>
                                    <div class="col-sm-9 col-xs-8 col-lg-8">

                                    <input class="form-control tabelements" type="text" id="birth_date" name="profile[birth_date]" required  autocomplete="off" />
                                    </div>
                                </div>
                                <div class="loadingconusme"></div>
                    <div class="col-sm-12">
                        <button type="submit" id="user_sign_up" name="user_sign_up" class="btn btn-primary pull-right aj-submit-button"><i class="fa fa-check"></i>Sign Up</button>
                    </div>
               </form>
               </div>
           </div>
       </div>
       </div>
    </script>

    <script id="sign_in_template" type="text/template">
        <div id="signintemplate" class="section-list">        
        <div class="container">
            <div class="row">
                <div class="col-sm-offset-3 col-sm-6">
                    <form role="form" class="form-horizontal sign-in-user">
                    <h5 class="text-center bold margin-none">Sign In</h5>
                    <br>
                    <div class="aj-response-message"> </div>
                    <div class="form-group">
                        <label class=" col-sm-3 col-xs-4 col-lg-4 control-label">Email: </label>
                        <div class="col-sm-9 col-xs-8 col-lg-8">
                        <input class="form-control tabelements" type="email" name="useremail" id="useremail" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class=" col-sm-3 col-xs-4 col-lg-4 control-label">Password: </label>
                        <div class="col-sm-9 col-xs-8 col-lg-8">
                        <input type="password" class="form-control tabelements" name="password" id="password" required />
                        <span style="display:none;" class="parsley-errors-list filled creError"></span>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <button type="submit" id="user_sign_in" name="user_sign_in" class="btn btn-primary pull-right aj-submit-button"><i class="fa fa-check"></i>Sign In</button>
                    </div>
               </form>
               </div>
           </div>
       </div>
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
    <div class="topheader" id="xoomaapptemplate">
                <nav class="navbar " role="navigation">
                        <div class="container mobile-container">

                                <div class="row">

                                        <div class="col-sm-3 col-xs-3 ">
                                        <div class="menulink">
                                              <a class="menuanchor" href="#menu">
                                                     <h4 class="margin-none"><i class="fa fa-bars "></i></h4>
                                                </a>
                                          </div>  
                                        </div>
                                          <div class="col-sm-6 col-xs-6">
                
                                                        <a href="#" >
                                                                <img alt="Brand"  src="<?php echo get_template_directory_uri(); ?>/xoomaapp/images/logo.png" class=" tp-img-align logo_link center-block" width="200px">
                                                            </a>
                                               
                                        </div>
                                        <div class="col-sm-3 col-xs-3">
                                           <div ui-region="currentUser" class="pull-right user-data ">

                                            </div>
                                         <!--    <a class="link" href="#settings">
                            <h4><i class="fa fa-cog pull-right "></i></h4>
                            </a>
                            <a class="link" href="#/home">
                            <h4><i class="fa fa-home pull-right"></i></h4>
                            </a>-->
                                         
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
    <div class="sub-header home-sub-header profile-template">
                <div class="container">
                        <div class="row">
                                <div class="col-sm-12">
                                        <ul class="list-inline">
                                                <li class="tag"><a  id="profile" href="#/profile/personal-info"><img  src="<?php echo get_template_directory_uri(); ?>/images/icon3.png"/>
                                                        <span class="hidden-xs"> My Personal Info</span></a>
                                                </li>
                                                <li class="tag"><a id="measurement" href="#/profile/measurements"><img  src="<?php echo get_template_directory_uri(); ?>/images/icon2.png"/>
                                                        <span  class="hidden-xs"> My Measurements</span></a>
                                                </li>
                                                <li class="tag"><a id="product" href="#/profile/my-products"><img  src="<?php echo get_template_directory_uri(); ?>/images/icon1.png"/>

                                                        <span class="hidden-xs" >My Products</span></a>

                                                        

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
        <div class="aj-response-message no-tab"> </div>
          <div class="row section-nm">
         <div class="col-md-2">
         </div>
            <div class="col-md-8 col-xs-12">
              <br>
              <form class="form-horizontal ">
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


    <div class="form-group ">
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
    <a href="http://xooma.com/" target="_blank" style="color:#787878">
     <div class="form-group link"  >
    <label  class="col-sm-12 col-xs-12  control-label " >About Xooma</label>
    </div>
    </a>
    </form>
              
              
              
              
              </div>
              <div class="loadingconusme"></div>
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

        <div id="personalinfo" class="section-list">

                <div class="container">

                        <div class="aj-response-message"> </div>
                        <form class="form-horizontal update_user_details" role="form">
                        <h5 class="text-center bold margin-none data1">User details.</h5>
    <h5 class="text-center bold margin-none data">Tell us a little about yourself.</h5>
                                
                                <p class="text-center data">Fill in your details and click on save.
    Fields marked * are mandatory</p><img src="{{profile_picture.sizes.thumbnail.url}}" alt="{{display_name}}" class="img-circle center-block profile-picture hidden-xs data" width="150px" height="150px">
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
                                                                <input type="text"  readonly class="form-control " name="display_name">
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
                                                                <input type="text" aj-field-type="number" class="form-control tabelements" name="profile[phone_no]">
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label for="text5" class=" col-sm-3 col-xs-4  control-label">Gender  <span class="requiredField text-danger"> * </span></label>
                                                        <div class="col-sm-9 col-xs-8">
                                                                <div class="rd-gender">
                                                                        <label class="wrap pull-left">
                                                                                <input type="radio" aj-field-required="true" name="profile[gender]" class="radio tabelements" value="male" />
                                                                                <span class="rd-visual male" title="Male"></span>
                                                                        </label>

                                                                        <label class="wrap pull-left">
                                                                                <input type="radio" aj-field-required="true" name="profile[gender]" class="radio tabelements" value="female" />

                                                                                <span class="rd-visual female" title="Female"></span>
                                                                        </label>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label for="text7" class=" col-sm-3 col-xs-4  control-label">Birth date  <span class="requiredField text-danger"> * </span></label>
                                                        <div class="col-sm-9 col-xs-8">

                                                                <input class="form-control tabelements" type="text" id="birth_date" name="profile[birth_date]" required />
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label for="text8" class=" col-sm-3 col-xs-4  control-label">Time zone</label>
                                                        <div class="col-sm-9 col-xs-8">
                                                                <select class="form-control tabelements" name="profile[timezone]" id="timezone]">
                                                                        <option value="America/New_York">America/New York</option>
                                                                        <option value="America/Adak">America/Adak</option>
                                                                        <option value="America/Mexico_city">America/Mexico_city</option>
                                                                        <option value="America/Chicago">America/Chicago</option>
                                                                        <option value="America/Los_Angeles">America/Los_Angeles</option>
                                                                        <option value="Europe/London">Europe/ London</option>
                                                                        <option value="Europe/Paris">Europe/Paris</option>
                                                                        <option value="Europe/Istanbul">Europe/Istanbul</option>
                                                                        <option value="Europe/Zagreb">Europe/Zagreb</option>
                                                                        <option value="Europe/Moscow">Europe/Moscow</option>
                                                                        <option value="Asia/Kolkata">Asia/Kolkata</option>
                                                                        <option value="Asia/Karachi">Asia/Karachi</option>
                                                                        <option value="Asia/Singapore">Asia/Singapore</option>
                                                                        <option value="Asia/Tokyo">Asia/Tokyo</option>
                                                                        <option value="Asia/Dubai">Asia/Dubai</option>
                                                                        <option value="Africa/Johannesburg">Africa/Johannesburg</option>
                                                                        <option value="Africa/Dakar">Africa/Dakar</option>
                                                                        <option value="Africa/Kampala">Africa/Kampala</option>
                                                                        <option value="Africa/Freetown">Africa/Freetown</option>
                                                                        <option value="Africa/Algiers">Africa/Algiers</option>
                                                                        <option value="Australia/Sydney">Australia/Sydney</option>
                                                                        <option value="Australia/Adelaide">Australia/Adelaide</option>
                                                                        <option value="Australia/Brisbane">Australia/Brisbane</option>
                                                                        <option value="Australia/Perth">Australia/Perth</option>
                                                                        <option value="Australia/Auckland">Australia/Auckland</option>

                                                                        
                                                                </select>
                                                        </div>
                                                </div>

                                                <div class="row">
                                                <div class="loadingconusme"></div>
                                                        <div class="col-sm-12">
                                                                <button type="submit" id="add_user" name="add_user" class="btn btn-primary pull-right aj-submit-button"><i class="fa fa-check"></i> Save</button>
                                                        </div>
                                                </div>

                                        </div>
                                </div>
                        </form>
                </div>
        </div>
    </script>
    <script id="profile-measurements-template" type="text/template">
    <div id="measuremnt" class="section-list">
                
                <div class="container ">
                <h5 class="text-center bold margin-none">Set your measurements for  <span class="measurements_update top-panel-picker "><img src="<?php echo get_template_directory_uri(); ?>/images/arrow-down.png" /><input type="text"  id="update" class="home-datepicker-sub" placeholder="&#xf073;"></span></h5>
                <p class="text-center">Knowing this information will help us determine the ideal amount of X2O water that your body needs on a daily basis 
    </p>                <!--<div class="alert alert-warning alert-msg measurements_update hidden" role="alert">
                  <i class="fa fa-bullhorn"></i> Choose a date from the calender and update your measurement by clicking on save!
                
                <div class="clearfix"></div>
                </div>-->
                <div class="aj-response-message"></div>


                        <form id="add_measurements" class="form-horizontal" role="form" method="POST">
                                <br><br>

                                <div class="row">
                                        
                                        <div class="col-sm-6 imageMap">

                                               <a  class="hotspot-neck link" href="#demo2_tip" onclick="return false;" onmouseover="tooltip.pop(this, '#demo2_tip', {sticky:true})">
            <i class="fa fa-dot-circle-o"></i>
           </a>
        <div style="display:none;">
            <div id="demo2_tip">
                <b>Neck (inches)</b><br />
           <input type="text" name="neck" id="neck" class="inpt_el" value="{{measurements.neck}}" class="col-sm-5" tabindex=1/> 
           <small>Please press enter or return</small></div>

        </div>

          <a class="hotspot-chest link" href="#demo3_tip" onclick="return false;" onmouseover="tooltip.pop(this, '#demo3_tip', {sticky:true})" >
              <i class="fa fa-dot-circle-o"></i>
          </a>
        <div style="display:none;">
            <div id="demo3_tip">
                <b>Chest (inches)</b><br />
           <input type="text" name="chest" id="chest" class="inpt_el" value="{{measurements.chest}}"  tabindex=2/>
            <small >Please press enter or return</small> </div>
        </div>
           <a class="hotspot-arm link" href="#demo4_tip" onclick="return false;" onmouseover="tooltip.pop(this, '#demo4_tip', {sticky:true})">
                <i class="fa fa-dot-circle-o"></i>
           </a>
           <div style="display:none;">
            <div id="demo4_tip">
                <b>Arm (inches)</b><br />
           <input type="text" name="arm" id="arm" class="inpt_el" value="{{measurements.arm}}" />
            <small >Please press enter or return</small> </div>
        </div>
           <a class="hotspot-abdomen link" href="#demo5_tip" onclick="return false;" onmouseover="tooltip.pop(this, '#demo5_tip', {sticky:true})">
                <i class="fa fa-dot-circle-o"></i>
           </a>
        <div style="display:none;">
            <div id="demo5_tip">
                <b>Abdomen (inches)</b><br />
           <input type="text" name="abdomen" id="abdomen" class="inpt_el" value="{{measurements.abdomen}}" />
            <small >Please press enter or return</small></div>
        </div>
           <a class="hotspot-waist link" href="#demo6_tip" onclick="return false;" onmouseover="tooltip.pop(this, '#demo6_tip', {sticky:true})">                  <i class="fa fa-dot-circle-o"></i>

           </a>
         <div style="display:none;">
            <div id="demo6_tip">
                <b>Waist (inches)</b><br />
           <input type="text" name="waist" id="waist" class="inpt_el" value="{{measurements.waist}}" />
           <small >Please press enter or return</small></div>
        </div>
           <a class="hotspot-hips link "  href="#demo7_tip" onclick="return false;" onmouseover="tooltip.pop(this, '#demo7_tip', {sticky:true})">
                <i class="fa fa-dot-circle-o"></i>
         
           </a>
                          <div style="display:none;">
            <div id="demo7_tip">
                <b>Hips (inches)</b><br />
           <input type="text" name="hips" id="hips" class="inpt_el" value="{{measurements.hips}}" />
            <small >Please press enter or return</small></div>
        </div>  
           <a class="hotspot-thigh link " href="#demo8_tip"  onclick="return false;" onmouseover="tooltip.pop(this, '#demo8_tip', {sticky:true})">
               <i class="fa fa-dot-circle-o"></i>
           </a>
                          <div style="display:none;">
            <div id="demo8_tip">
                <b>Thigh (inches)</b><br />
           <input type="text" name="thigh" id="thigh" class="inpt_el" value="{{measurements.thigh}}" />
            <small >Please press enter or return</small></div>
        </div>  
           <a class="hotspot-midcalf link " href="#demo9_tip" onclick="return false;" onmouseover="tooltip.pop(this, '#demo9_tip', {sticky:true})"  >
               <i class="fa fa-dot-circle-o"></i>
           </a>

                         <div style="display:none;">
            <div id="demo9_tip">
                <b>Midcalf (inches)</b><br />
           <input type="text" name="midcalf" id="midcalf" class="inpt_el" value="{{measurements.midcalf}}"/>
            <small >Please press enter or return</small></div>
        </div> 
          



           <img id="body" src="<?php echo get_template_directory_uri();?>/images/humanbody.png" class="center-block">
                                        <small>Click on the blinking red spot to enter the measurement of the selected part of the body in inches.</small><br><br>
                                        </div>
                                    <div class="col-sm-6 ">
                                                <div class="panel-default panel">
                                                <div class="panel-body ">
                                              <!--  <div class="row">
                                                <input type="hidden" name="date_field" id="date_field" value="{{measurements.date}}" />
                                                        <div class="col-md-5 col-xs-5">
                                                                <img src="<?php echo get_template_directory_uri();?>/images/height.png" class="pull-right m-t-10">
                                                        </div>
                                                        <div class="col-md-7">
                                                                <h4 class="text-left"> <output class="heightcms"></output><small> Ft/inches</small></h4>
                                                        </div>
                                                        <input type="range" min="4.0" max="9.0" step="0.1" value="{{measurements.height}}" id="height" name="height" required data-rangeslider>
                                                <div class="convertheight text-center m-t-30 text-muted"></div>
                                                </div>
                                                        <fieldset>
            <label for="valueA">Height:</label>
            <select value="{{measurements.height}}" id="height" name="height">
               <option value="4">4&rsquo;</option>
                    <option value="4.1">4&rsquo;&nbsp;1&rdquo;</option>
                    <option value="4.2;">4&rsquo;&nbsp;2&rdquo;</option>
                    <option value="4.3">4&rsquo;&nbsp;3&rdquo;</option>
                    <option value="4.4">4&rsquo;&nbsp;4&rdquo;</option>
                    <option value="4.5">4&rsquo;&nbsp;5&rdquo;</option>
                    <option value="4.6">4&rsquo;&nbsp;6&rdquo;</option>
                    <option value="4.7">4&rsquo;&nbsp;7&rdquo;</option>
                    <option value="4.8">4&rsquo;&nbsp;8&rdquo;</option>
                    <option value="4.9">4&rsquo;&nbsp;9&rdquo;</option>
                    <option value="4.10">4&rsquo;&nbsp;10&rdquo;</option>
                    <option value="4.11">4&rsquo;&nbsp;11&rdquo;</option>
               <option value="5">5&rsquo;</option>
                    <option value="5.1">5&rsquo;&nbsp;1&rdquo;</option>
                    <option value="5.2">5&rsquo;&nbsp;2&rdquo;</option>
                    <option value="5.3">5&rsquo;&nbsp;3&rdquo;</option>
                    <option value="5.4">5&rsquo;&nbsp;4&rdquo;</option>
                    <option value="5.5">5&rsquo;&nbsp;5&rdquo;</option>
                    <option value="5.6">5&rsquo;&nbsp;6&rdquo;</option>
                    <option value="5.7">5&rsquo;&nbsp;7&rdquo;</option>
                    <option value="5.8">5&rsquo;&nbsp;8&rdquo;</option>
                    <option value="5.9">5&rsquo;&nbsp;9&rdquo;</option>
                    <option value="5.10">5&rsquo;&nbsp;10&rdquo;</option>
                    <option value="5.11">5&rsquo;&nbsp;11&rdquo;</option>
                <option value="6">6&rsquo;</option>
                    <option value="6.1">6&rsquo;&nbsp;1&rdquo;</option>
                    <option value="6.2">6&rsquo;&nbsp;2&rdquo;</option>
                    <option value="6.3">6&rsquo;&nbsp;3&rdquo;</option>
                    <option value="6.4">6&rsquo;&nbsp;4&rdquo;</option>
                    <option value="6.5">6&rsquo;&nbsp;5&rdquo;</option>
                    <option value="6.6">6&rsquo;&nbsp;6&rdquo;</option>
                    <option value="6.7">6&rsquo;&nbsp;7&rdquo;</option>
                    <option value="6.8">6&rsquo;&nbsp;8&rdquo;</option>
                    <option value="6.9">6&rsquo;&nbsp;9&rdquo;</option>
                    <option value="6.10">6&rsquo;&nbsp;10&rdquo;</option>
                    <option value="6.11">6&rsquo;&nbsp;11&rdquo;</option>
                
            </select>
    
        </fieldset>
                                                </br>
                                                </br>
                                                <div class="row">
                                                        <div class="col-md-5 col-xs-5">
                                                                <img src="<?php echo get_template_directory_uri();?>/images/weight.jpg" class="pull-right m-t-10">
                                                        </div>
                                                        <div class="col-md-7 ">
                                                                <h4 class="text-left"> <output class="weightcms"></output><small> pounds</small></h4>
                                                        </div>

                                                        <input type="range" min="111" max="500" step="1" value="{{measurements.weight}}" id="weight" name="weight" required data-rangeslider>
                                                        <div class="convertweight text-center m-t-30 text-muted"></div>
                                                </div>
                                                 </br>
                                                </br>-->

                                     <div class="row">
                                                <input type="hidden" name="date_field" id="date_field" value="{{measurements.date}}" />
                                                        <div class="col-md-3 col-xs-3">
                                                                <img src="<?php echo get_template_directory_uri();?>/images/height.png" class="pull-right m-t-10">
                                                        </div>
                                                        <div class="col-md-5">
                                                                <h4 class="text-left">
             <label for="valueA" class="pull-right"><h5 class="margin-none">Height</h5><h6 class="text-muted margin-none"> Ft/inches</h6></label>
            <select value="{{measurements.height}}" id="height" name="height" class="default-select">
                <option value="4">4&rsquo;</option>
                    <option value="4.1">4&rsquo;&nbsp;1&rdquo;</option>
                    <option value="4.2;">4&rsquo;&nbsp;2&rdquo;</option>
                    <option value="4.3">4&rsquo;&nbsp;3&rdquo;</option>
                    <option value="4.4">4&rsquo;&nbsp;4&rdquo;</option>
                    <option value="4.5">4&rsquo;&nbsp;5&rdquo;</option>
                    <option value="4.6">4&rsquo;&nbsp;6&rdquo;</option>
                    <option value="4.7">4&rsquo;&nbsp;7&rdquo;</option>
                    <option value="4.8">4&rsquo;&nbsp;8&rdquo;</option>
                    <option value="4.9">4&rsquo;&nbsp;9&rdquo;</option>
                    <option value="4.10">4&rsquo;&nbsp;10&rdquo;</option>
                    <option value="4.11">4&rsquo;&nbsp;11&rdquo;</option>
                <option value="5">5&rsquo;</option>
                    <option value="5.1">5&rsquo;&nbsp;1&rdquo;</option>
                    <option value="5.2">5&rsquo;&nbsp;2&rdquo;</option>
                    <option value="5.3">5&rsquo;&nbsp;3&rdquo;</option>
                    <option value="5.4">5&rsquo;&nbsp;4&rdquo;</option>
                    <option value="5.5">5&rsquo;&nbsp;5&rdquo;</option>
                    <option value="5.6">5&rsquo;&nbsp;6&rdquo;</option>
                    <option value="5.7">5&rsquo;&nbsp;7&rdquo;</option>
                    <option value="5.8">5&rsquo;&nbsp;8&rdquo;</option>
                    <option value="5.9">5&rsquo;&nbsp;9&rdquo;</option>
                    <option value="5.10">5&rsquo;&nbsp;10&rdquo;</option>
                    <option value="5.11">5&rsquo;&nbsp;11&rdquo;</option>
                <option value="6">6&rsquo;</option>
                    <option value="6.1">6&rsquo;&nbsp;1&rdquo;</option>
                    <option value="6.2">6&rsquo;&nbsp;2&rdquo;</option>
                    <option value="6.3">6&rsquo;&nbsp;3&rdquo;</option>
                    <option value="6.4">6&rsquo;&nbsp;4&rdquo;</option>
                    <option value="6.5">6&rsquo;&nbsp;5&rdquo;</option>
                    <option value="6.6">6&rsquo;&nbsp;6&rdquo;</option>
                    <option value="6.7">6&rsquo;&nbsp;7&rdquo;</option>
                    <option value="6.8">6&rsquo;&nbsp;8&rdquo;</option>
                    <option value="6.9">6&rsquo;&nbsp;9&rdquo;</option>
                    <option value="6.10">6&rsquo;&nbsp;10&rdquo;</option>
                    <option value="6.11">6&rsquo;&nbsp;11&rdquo;</option>
            </select>
            </h4>
    </div>
       <div class="col-md-4 col-xs-12">
                                                         <div class="convertheight text-center m-t-20 text-muted">123cm</div>
                                                        </div>                                               
    
                                                </div>
                          </br>
                                               
                                                <div class="row">
                                                        <div class="col-md-3 col-xs-3">
                                                                <img src="<?php echo get_template_directory_uri();?>/images/weight.jpg" class="pull-right m-t-10">
                                                        </div>
                                                        <div class="col-md-5 ">
                                                                <h4 class="text-left">  <label for="valueA" class="pull-right"><h5 class="margin-none">Weight</h5><h6 class="text-muted margin-none">pounds</h6></label>
            <select value="{{measurements.weight}}" id="weight" name="weight" class="default-select">
                    
            </select></h4>
                                                        </div>

                                                  <div class="col-md-4 col-xs-12">
                                                               <div class="convertweight text-center m-t-20 text-muted">3.46kg</div>
                                                        </div>     
                                                        
                                                </div>
                                                 </br>
                                               
                                        </div>
                                         </div>
                                        


    <button type="button" id="save_measure" name="save_measure" class="btn btn-primary center-block aj-submit-button hidden-xs"><i class="fa fa-check"></i> Save Measurements</button>
                               </div>   </div>
                                <div class="row">
                                 <div class="loadingconusme"></div>
                                                <div class="col-sm-12"><hr>
                                                        <button type="button" id="save_measure" name="save_measure" class="btn btn-primary center-block aj-submit-button visible-xs"><i class="fa fa-check"></i> Save Measurements</button>
                                                </div>
                                        </div>
                </div>
        </div>
    </script>
    <script id="home-template" type="text/template">
<!--<div class="error-connection">
    <div class="container">
        <div class="row">
                <div class="col-md-12 text-center text-muted m-t-30">
               <h2 > <i class="fa fa-wifi"></i></h2>
                        <h4 > No Connection Found</h4>
                        Your connection to the wireless network is turned off.<br> Restore your connection and try again
                </div>

        </div>
    </div>
</div>-->
        <div class="container" id="homeregion"> 
        <!--<div class="alert alert-warning alert-msg measurements_update text-center" role="alert">
                  <i class="fa fa-bullhorn"></i>  Pick up a date here and update your consumptions for that day
    !
                
                </div>-->

        <div class="aj-response-message no-tab"> </div>
     <div class="row section-nm">
            <div class="col-md-2"> 
            </div>
         <div class="col-md-8"> 
         <div class="panel panel-default panel-mobile">
                  <div class="panel-body  ">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/icon-calender.png" class="m-t--10" width="22px"/>
                        <span class="top-panel-picker ">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-down.png" />
                    <input type="text"  id="update" class="home-datepicker " >
                    </span>
                <a id="showHome">( Apply ) </a> <img src="" class="daynightclass pull-right"/>

                  </div>
            </div>

                <div class="loading"></div> 
                 <div ui-region="x2o" id="x2oregion">
                      
                    </div>
        

       <div ui-region="other-products" id="otherproducts">
       
         </div>         




    <div class="panel panel-default">
          <div class="panel-body">
            <h5 class=" margin-none mid-title ">Progress Chart <i type="button" class="fa fa-bars pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
                     <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="#" class="update">Update Measurements</a></li>
                        <li><a href="#" class="history">Measurements History</a></li>
                        </ul>
                                      </h5>
                    <form id="generate_graph" method="POST"  role="form">
                        <div class="row m-t-30">
                            <div class="col-md-4 col-xs-6"> 
                                <label for="exampleInputFile">Measurement Area</label>
                                    <select class="form-control" aj-field-required="true" id="param" name="param">
                                              <option value="">Please select</option>
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
                            <div class="col-md-4 col-xs-6"> 
         <input type="hidden" id="start_date" name="start_date" >
                                <input type="hidden"  id="end_date" name="end_date">
                        
                        
                           <label for="exampleInputFile " class="time_period">Period of Time</label>
                                <select class="form-control time_period ">
                                  <option value="">--Select--</option>
                                  <option value="30">Last 30 days</option>
                                  <option value="60">Last 60 days</option>
                                  <option value="all">All time</option>
                                </select>
                            </div>
                               
                       <div class="col-md-4 col-xs-12"> <br>
   <button type="button" name="generate" class="aj-submit-button  btn-link" >Generate Graph <i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>  
        
                 
    <div class="clearfix"></div><br><div class="loadinggraph"></div> 

                <div id="canvasregion" style="width:100%">

                                <div>
                                <div id="graph-container">
                                    <canvas id="canvas" height="450" width="600"></canvas></div>
                                <div id="y-axis" class="text-center"><b></b></div>
         <div id="x-axis" class="text-center">Date</div>
         <div class="row">
            <div class="col-sm-12">
            <div id="bmi" >Legend :  <i class="fa fa-circle"></i> Normal</div>
            </div>
             
            </div>
         </div>

                                </div>
                    
            
            </div>

            <div class="col-md-2"> 
            </div>
        </div>

    </div>

    </script>
    <script id="produts-template" type="h-template">
<div id="xoomaproduct" class="section-list"> 
                <h5 class="text-center bold margin-none">My Xooma products</h5>
                <p class="text-center">Your xooma products are displayed here once you add them.
    </p>
        <div class="container">
        <div class="aj-response-message"> </div>
              <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-8">
               <a href="#/products" class="btn btn-primary center-block add" style="width:180px"><i class="fa fa-plus-circle"></i> Add Products</a>
               <br>

    <!--<div class="panel panel-default">
          <div class="panel-body ">
            <h5 class="bold margin-none mid-title ">Focus Up
              <i type="button" class="fa fa-ellipsis-v pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
                     <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="#">Edit product</a></li>
                        <li><a href="#">Inventory</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Remove the product</a></li>
                      </ul>
              </h5>
                      <ul class="list-inline   m-t-20">
                        <li class="col-md-7 col-xs-7 dotted-line">
                                  <ul class="list-inline no-dotted ">
        
                                <li> <h3 class="bold margin-none"><div class="cap capsule_occurred_class"></div>3</h3>
                                
                                       
                              </li>
                                 <li>

                                          <h3 class="bold margin-none"><div class="cap capsule_occurred_class"></div>3</h3>
                                   
                                       
                              </li>
                                <li>

                                          <h3 class="bold margin-none"><div class="cap capsule_occurred_class"></div>3</h3>
                                   
                                        
                              </li>
                          </ul>      
                        </li>
                        <li class="col-md-1 col-xs-1">
                    <h4>    <i class="fa fa-random text-muted m-t-20"></i></h4>
                        </li>
                        <li class="col-md-4  col-xs-4 text-center">
                         Servings left
                          <h2 class="margin-none bold text-danger">3</h2>
                          10 container (300 sachet)
                      
                        </li>
                    </ul>
          </div>
          <div class="panel-footer">
          <i id="bell" class="fa fa-bell-slash no-remiander"></i> 
           No Remiander is set
          </div>
        </div>-->
        
    <div class="userproducts"></div>
     <a href="#/products" class="btn btn-primary pull-left add1"><i class="fa fa-plus-circle"></i> Add Products</a>
     <button type="button" class="btn btn-primary  center-block save_products"><i class="fa fa-check"></i>Congrats! Get started right away!</button>               
                  </div>
                  <div class="col-md-2"></div>
              </div>
        </div>  
                </div>

    </script>
    <script id="add-product-template" type="h-template">
<div id="listproduct" >
<div class="sub-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                   <a href="#/profile/my-products"><i class="fa fa-chevron-left"></i> Back </a> | <b>My Xooma products</b>
                </div>
            </div>
        </div>
    </div>
    <br/><br/>
    <div class="container">
        <div class="aj-response-message"></div> 
              <div class="row">
                  <div class="col-md-12">
                    <div id="cbp-vm" class="cbp-vm-switcher cbp-vm-view-grid ">
                    <div>
                    <div class="row m-t-10">
                        <div class="col-sm-6 col-xs-6">
                                <h5 class="bold margin-none"> List of products</h5>
                         </div> 
                            <div class="col-sm-6 col-xs-6">
                                <div class="cbp-vm-options">
                                    <a href="#" class="cbp-vm-icon cbp-vm-grid cbp-vm-selected grid" data-view="cbp-vm-view-grid"></a>
                                    <a href="#" class="cbp-vm-icon cbp-vm-list grid" data-view="cbp-vm-view-list"></a>
                                </div>
                            </div>
                    </div>  
                    <hr class="hr-mobile">
                    </div>  
                    <ul class="products-list">
                        
                    </ul>
                </div>
            </div>
                  
                  
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
            <hr class="margin-none"><br>
    <a href="#/profile/my-products" class=" btn-link  pull-right"><i class="fa  fa-times"></i> Cancel</a><div class="clearfix"></div><br>
                            </div>
            </div>
              
              </div>

                </div>
    </script>
    <script id="current-user-template" type="text/template">
<div class="hidden" data-placement="bottom" data-toggle="popover" title="Welcome to xooma {{display_name}}" ><img class="media-object dp img-rounded" src="{{profile_picture.sizes.thumbnail.url}}" style="width: 30px;height:30px;"></div>
                <div class="hidden popover-content">
                    <div class="text-center">
                        <img class="media-object dp img-rounded" src="{{profile_picture.sizes.thumbnail.url}}" style="width: 100px;height:100px;">
                        <a href="<?php echo wp_logout_url(site_url().'/xooma-app/#login'); ?>" class="btn btn-small logout-button" >Logout</a>
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
    <div class="section">
    <div class="container "> 
    <div class="aj-response-message"></div>
        <h3 class="bold margin-none">{{name}}</h3>

          <div class="row " >
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
            <input type="hidden" name="homeDate" id="homeDate" value="" / >
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
              <b class="bold-sum text-primary">{{x2o}}</b>
                </div>
                 </div>
                 <div class="form-group">
                  <label for="inputEmail2" class="col-sm-6 col-xs-7  control-label">Please slide to add bottle </label>
                        <div class="col-sm-6 col-xs-5 range-inventory">
                <h3 class=" bold-sum margin-none "> <output class="text-primary"></output> <small>Bottle(s)</small></h3>
                 <div class="clearfix"></div>
                    <input class="pull-left" type="range" id="x2o" name="x2o" min="1" max="9" step="1" value="{{defaultbmi}}" data-rangeslider>
                    </div>
    </div>
           </div>
              
              <div class="anytime">
              <div class="form-group">
    <label for="inputEmail3" class="col-sm-6 col-xs-5  control-label">Serving(s) per day</label>
    <div class="col-sm-6 col-xs-7 ">
      <select class="form-control servings_per_day " name="servings_per_day">
          <option value="">Please Select</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          
        </select>
        <input type="hidden" name="servings_per_day_value" id="servings_per_day_value" value="" />
    </div>
    </div>

    <div class="form-group">
    <div class="checkbox">
    <label class=" control-label">
     &nbsp;&nbsp;&nbsp; <input type="checkbox" name="servings_diff" value="0"> Allow me to set different quantity per serving
    <input type="hidden" name="check" id="check" value="0" /></label>
    <input type="hidden" name="timeset" id="timeset" value=""  >
    </div> 

    </div> 
    <div class="qty_per_servings_div">
    <div class="qtyper">
    <div class="form-group ">
    <label for="inputPassword3" class="col-sm-6  col-xs-5 control-label">Quantity per serving</label>
    <div class="col-sm-6 col-xs-7">
      <select class="form-control  col-sm-6 col-xs-3 qty_per_servings" name="qty_per_servings0" id="qty_per_servings0">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          
        </select> <!--<label for="inputPassword3" class="control-label"> &nbsp; Capsule</label>-->
    </div>
    </div>
    </div>

    </div>
    </div> 

    <div class="schedule_data ">
    <div class="form-group ">
    <label for="inputEmail3" class="col-sm-6 col-xs-6  control-label">Serving(s) per day</label>
    <div class="col-sm-6 col-xs-6 ">
     <div class="btn-group" role="group" aria-label="...">
      <button type="button" data-time="Once"  class="btn schedule {{once}}">  Once</button>
      <button type="button" data-time="Twice"   class="btn schedule {{twice}}"> Twice</button>
      
    </div>
    </div>
    </div>
    <div class="form-group ">
    <label for="inputPassword3" class="col-sm-6  col-xs-5 control-label"><b>Quantity per serving</b></label>
    <label for="inputPassword3" class="control-label col-sm-6  col-xs-7 "><B>When</B> </label>
    </div>
    <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 col-xs-4 control-label">Serving1</label>
    <div class="col-sm-4 col-xs-8 ">
      <select class="form-control qty0" name="qty_per_servings0">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          
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
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
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
    <div class="form-group hidden">

    <label for="inputEmail3" class="col-sm-6 col-xs-5  control-label">Number of 

    container(s)</label>
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

    <div class="form-group hidden">

    <label for="inputPassword3" class="col-sm-6  col-xs-5 control-label">Samples given to the prospective customer</label>
     <div class="col-sm-6 col-xs-7">

      <input type="text" name="subtract" aj-field-type="number" value="" class="form-control"/>
      </div>
    </div>
    </div>
    <div class="form-group ">
    <label for="inputPassword3" class="col-sm-6 col-xs-7 control-label">Set reminder</label>
    <div class="col-sm-6 col-xs-5">
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
    <div class="col-sm-6 col-xs-7 input-append  ">
    <div class="bootstrap-timepicker">
    <span class="top-panel-picker ">     <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-down.png" /> <input name="reminder_time0" id="reminder_time0" disabled class="input-small inputcss" type="text" value="{{reminder}}" ></span>
    <span class="add-on"><i class="icon-time"></i></span></div>
    </div>
    </div>
    </div>
    </div>
    
   
    <div >
     <div class="loadingconusme"></div>
     <button type="button" class=" btn-link cancel pull-right"><i class="fa fa-times "></i> Cancel</button> 

      <button type="submit" class="btn btn-primary aj-submit-button save pull-right m-r-10" name="save"><i class="fa fa-check"></i> Save</button>
      <button type="submit" class="btn btn-primary aj-submit-button save_another hidden hidden-xs pull-right m-r-10" name="save_another">Save</button>

         <!--<a href="#/inventory/{{id}}/view" class="btn btn-primary view hidden" >View History</a>-->
         

    
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
    <div class="section">
    <div class="container " >
    <div class="aj-response-message"></div>
    <div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">

     <form id="inventory" class="form-horizontal" role="form" method="POST">
      <div class="form-group">
        <label for="inputPassword3" class="col-sm-6  col-xs-8 control-label">Inventory in hand</label>
        <div class="col-sm-6 col-xs-4">
          <b id="container_label" class="bold-sum text-primary"></b>
        </div>
      </div>
         <div class="form-group">
        <label for="inputPassword3" class="col-sm-6  col-xs-8 control-label">{{producttype}}(s) I have with me
       <br> <small><i>Each container has {{total}} {{product_type}}(s)</i></small>
        </label>
        <div class="col-sm-6 col-xs-4">
          <b class="bold-sum text-primary">{{available}}</b>
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
       
            <label for="inputPassword3" class="col-sm-6  col-xs-6 control-label">
            Add inventory
            </label>
            <div class="col-sm-6 col-xs-6">
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
                  <h3 class="bold-sum text-primary"><span class="newsum"><span class="ncon"></span> * <span class="ntotal"></span> = <span class="nequalto"></span></span></h3>
                </div>
      </div>
     
        <div class="form-group">
                <label class="col-sm-6  col-xs-7 control-label">
                    Adjust
                </label>
                <div class="col-sm-6 col-xs-5 range-inventory">
                <h3 class=" bold-sum margin-none "> <output class="text-primary"></output> <small>{{product_type}}(s)</small></h3>
                 <div class="clearfix"></div>
                 <input class="pull-left" type="range" name="slider" id="slider"  min="-20" max="20" disabled step="1" value="0" data-rangeslider>
                </div>
      </div>
       <div class="form-group">
                <label class="col-sm-6  col-xs-6 control-label">
                    Number of {{product_type}}(s) will be updated to 
                </label>
                <div class="col-sm-6 col-xs-6">
                 <h3 class="bold-sum text-primary"><span class="finaladd"><span class="navail"></span><span class="record"> + <span class="nadd"></span></span><span class="sign"> - </span><span class="nsub"></span>  = <span class="eqa"></span></h3>
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
                    <div class="">
                    <div class="loadingconusme"></div>
                                 
                    <input type="hidden" id="subtract" name="subtract" aj-field-type="number" value="" />
                          <input type="hidden" name="total" value="{{total}}" / >
                     <a href="#/profile/my-products" class="btn-link cancel pull-right"><i class="fa fa-times "></i> Cancel</a> 
                      <button type="submit" class="btn btn-primary aj-submit-button save pull-right m-r-10" name="save"><i class="fa fa-check"></i> Save</button>
                      <!-- <a href="#/inventory/{{id}}/view" class="btn btn-link  " >View History</a>-->    
                      <div class="clearfix"></div> <br>
                    </div>
                </div>
             </form>
          </div>
        <div class="col-sm-2"></div>
     </div>
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
    <div class="aj-response-message"></div> 
    <div class="row">
    <div class="col-sm-6 col-sm-offset-3">
    <h5 class="text-center bold product_name">Product name</h5>
    <small class="text-center center-block msg bottle-msg text-warning">Click on each card to view consumption details </small>
    <ul id='timeline' class="viewInventory">
    </ul>
    </div>
    </div>
    <hr>
    <a href="#/profile/my-products" class=" btn-link pull-right" ><i class="fa fa-times"></i> Cancel</a>    

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
                    <!--<a href="" class="btn btn-primary consume">Consume</a>-->
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
                   <a href="#/home"><i class="fa fa-chevron-left"></i> Back </a> | <b>Consumption</b>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="container"> 
    <div class="tab aj-response-message"></div>


<input type="hidden" value="" id="consume_time" name="consume_time" class="fa fa-clock-o  text-muetd input-small home-datepicker  hasDatepicker" />
        <h5 class=" text-center"><span class="serving"></span><small class="bonus"></small></h5>
           <small class="text-center center-block msg bottle-msg text-warning"></small> 
    <!-- <h4 class="text-center"><span class="bottlecnt">{{confirm}}</span>/1<small>Bottle</small></h4>-->
        <div class="row">
            
            <div class="col-md-4 "> 
            </div>
            <div class="col-md-4 col-xs-12">
                
                <div class="water-100 water-marker"> 
                    100% ---
                    
                </div>
                <div class="water-75 water-marker"> 
                    75% ---
                </div>
                <div class="water-50 water-marker"> 
                    50% ---
                </div>
                <div class="water-25 water-marker"> 
                    25% ---
                </div>
            <!--- Bottle UI -->

                <div> 
                
                <img src="<?php echo site_url() ?>/wp-content/themes/twentytwelve/xoomaapp/images/bottle-cap.png" class="center-block bottle-cap"/></div>
                <div class="bottle-bg">
                        <div class="bottle">/div>
                        
                        
                 </div>

                        

                    

            <!--- Bottle UI -->
            </div>

             <div class="col-md-4 ">
            </div>
        </div>

         <input type="hidden" name="date" id="date" value="" / >
       <div class="row m-t-20">
            <div class="col-sm-5 col-xs-4"> <div class="loadingconusme pull-right m-t-10" ></div></div>
            <div class="col-sm-2 col-xs-4">
                <input type="hidden" name="percentage" id="percentage" value="0" / >
                <input type="hidden" name="meta_id" id="meta_id" value="" / >
                <button type="submit" data-count="0" id="confirm" class="change-progress btn btn-primary  center-block" > Confirm </button>
                
            </div>
            <div class="col-sm-5 col-xs-4"><button class="reset-progress btn-link pull-left" type="button"> <i class="fa fa-refresh"></i> Reset</button></div>
        </div>
    </div>
    <br>
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


    </script>
    <script id="schedule-template" type="text/template">
<div class="blur-background">
    <div class="sub-header">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
           <a href="#/home"><i class="fa fa-chevron-left"></i> Back </a> | <b> Consumption </b>
        </div>
      </div>
    </div>
    </div>
    <div class="container"> 
    <div class="section section-normal"> 
    <div class="aj-response-message" ></div>
    <form id="consume" class="form-horizontal" role="form" method="POST">
    <br>

        <div class="row">
            <div class="col-md-3 "> 
           
            </div>
            <div class="col-md-6 col-xs-12">
                <h3 class="text-center margin-none text-muted"> <div class="{{classname}}"></div>{{name}}</h3>
                 <h6 class="text-center text-muted">{{serving}}</h6>
                 <h5 class="text-center text-muted m-t-20">How many {{product_type}}(s) did you have ?</h5>
          




                   <h4 class="text-center margin-none "> <output class="text-muted"></output></h4>
                    <input class="pull-left" type="range" min="1" max="4" step="1" name="qty" value="{{qty}}" data-rangeslider>
                 <h5 class="text-center m-t-40"><i class="fa fa-clock-o text-muted"></i> <span class="top-panel-picker ">     <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-down.png" /><input type="text" value="" id="consume_time" name="consume_time" class="fa fa-clock-o  text-muetd input-small home-datepicker  hasDatepicker" /></span></h5>
            </div>
            <div class="col-md-3">
         
            </div>
        </div>
           <div class="row m-t-20">
        <div class="col-sm-5 col-xs-2"> <div class="loadingconusme pull-right m-t-10 m-r-10"></div></div>
      <div class="col-sm-5 col-xs-10">
        <input type="hidden" name="date" id="date" value="" / >
        <input type="hidden" name="org_qty" id="org_qty" value="" / >
        <input type="hidden" name="meta_id" id="meta_id" value="" / >
        <input type="hidden" name="datehide" id="datehide" value="" / >
          <button type="submit" data-count="0" id="confirm" class="change-progress intake btn btn-primary  " > <i class="fa fa-check"></i>  Confirm </button>
           <button type="submit" data-count="0" id="skip" class="change-progress  btn btn-default  " > <i class="fa fa-angle-double-right"></i> Skip </button>
                <button class="reset-progress btn-link reset text-muted " type="button" > <i class="fa fa-refresh"></i> Reset</button>
    </div>
      <div class="col-sm-4 col-xs-1"></div>
    </div>

    </div>
    </form>
    </div>
    </script>
 <script id="admin-template" type="text/template">
    <div class="sub-header home-sub-header">
                <div class="container">
                        <div class="row">
                                <div class="col-sm-12">
                                        <ul class="list-inline">
                                                <li class="tag"><a  id="profile" class="link" href="#"><img  src="<?php echo get_template_directory_uri(); ?>/images/icon3.png"/>
                                                        <span class="hidden-xs"> My Personal Info</span></a>
                                                </li>
                                                <li class="tag"><a id="measurement" class="link" href="#"><img  src="<?php echo get_template_directory_uri(); ?>/images/icon2.png"/>
                                                        <span  class="hidden-xs"> My Measurements</span></a>
                                                </li>
                                                <li class="tag"><a id="product" class="link" href="#"><img  src="<?php echo get_template_directory_uri(); ?>/images/icon1.png"/>

                                                        <span class="hidden-xs" >My Products</span></a>

                                                        

                                                </li>
                                        </ul>
                                </div>
                        </div>
                </div>
        </div>
        <div class="clearfix"></div>
        
 
  </script>
  <script id="faq-template" type="text/template">
  <div class="sub-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                   <a class="faqlink" href="#"><i class="fa fa-chevron-left"></i> Back </a> | <b>FAQ</b>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <br>
                <div class="container">
                        
<div class="panel-group faq-list" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          How do I benefit with Xooma Track & Go?
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
       <span class="dropcap simple">A: </span> Xooma Track & Go has been designed to help you track your personal X2O Water Consumption and additionally help you stay on track with your personal health goals using other Xooma products. Simply tell us a little bit about yourself (Height, Weight, Health Goals, which Xooma products you use and when you use them). Once you eneter this information Xooma Track & Go will provide you with your Personal Daily Hydration Goal and also remind you when to take your other Xooma Products.  This fun and interactive app has been designed to help you achieve your personal health goals with Xooma’s products.

      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          What is 'My Xooma Products'?
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        <span class="dropcap simple">A: </span>These are the Xooma supplements you currently take. You can add them from the complete 'List of Xooma products' and this app will keep track of your daily usage and notify you when your inventory is running low.
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          What is 'List of Xooma products'?
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="panel-body">
        <span class="dropcap simple">A: </span> This area of the Xooma Track & Go App allows you to click on 'Add' (Available under each product) to select that product as a part of the 'My Xooma products' that you wish to track. Once you have clicked on “add”, the product is no longer displayed under 'List of Xooma products'.  You can choose to receive reminders for a product only when that product is added to 'My Xooma Product'

      </div>
    </div>
  </div>

    <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading4">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapseTwo">
        How can I set reminders for product intake?

        </a>
      </h4>
    </div>
    <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
      <div class="panel-body">
        <span class="dropcap simple">A: </span>Reminders can be set for each serving of a product. Fields for reminders are populated depending on the number of servings selected. You simply have to choose a time for the reminder for each serving. By default, the reminders will be turned ‘on’ at the app level (Available for mobile phones, under 'settings')<br>
There are two options for setting reminders:<br>
a. While adding a product (from 'List of Xooma products'): The product is available to edit and your reminders can be set from here.
<br>
b. Menu option on the product card: Once the product has been added it is available under the 'My product list' section. Each product has a card, wherein a menu icon is available. From the menu icon (3 bars displayed on the right side of the card) select the option to 'edit' and reminders for your product can then be sent.

      </div>
    </div>
  </div>

    <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading5">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="false" aria-controls="collapseTwo">
          How do I track my consumption of X2O?
        </a>
      </h4>
    </div>
    <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
      <div class="panel-body">
        <span class="dropcap simple">A: </span>On the home screen, click on 'Hydrate' (on the X2O bottle in the center) and you will be directed to the consumption screen. From here, simply long press your finger on the X2O bottle and the liquid in the bottle will keep decreasing.When your desired bottle consumption level is reached, release your finger and the amount of your consumption will be displayed. Then click on ‘confirm’ to save your consumption amount.

      </div>
    </div>
  </div>

   <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading6">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="false" aria-controls="collapseTwo">
          How to I show that I’ve consumed a supplement?

        </a>
      </h4>
    </div>
    <div id="collapse6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
      <div class="panel-body">
        <span class="dropcap simple">A: </span>This action can be accomplished from the home screen.  Just click on 'Tap to take' for any product listed and you will be directed to the consumption screen for that product. You can select the time when you consumed the product and then save your progress.

      </div>
    </div>
  </div>

     <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading7">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse7" aria-expanded="false" aria-controls="collapseTwo">
          How do I 'add stock' (inventory) for a product?
        </a>
      </h4>
    </div>
    <div id="collapse7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading7">
      <div class="panel-body">
        <span class="dropcap simple">A: </span>You can manage your stock with the help of 'Inventory'.  Each product has its own inventory tracking. Here you can refill your inventory and also adjust your existing inventory levels with the amount of product that you have on hand. Steps to reach the inventory screen are:<br><br>
  a. Go to 'My Xooma products'<br>
  b. For each product card there is a menu option available. Click on it.<br>
  c. Select the inventory option

      </div>
    </div>
  </div>

     <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading8">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse8" aria-expanded="false" aria-controls="collapseTwo">
          How do I manage my inventory?
        </a>
      </h4>
    </div>
    <div id="collapse8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading8">
      <div class="panel-body">
        <span class="dropcap simple">A: </span>After your stock for a product is added, the inventory will continue to reduce every time you add your consumption. You also have the option to adjust your inventory (add/subtract number of supplements available) by using the slider bar in the inventory section.


      </div>
    </div>
  </div>

       <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading9">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse9" aria-expanded="false" aria-controls="collapseTwo">
          What happens when I 'remove product'?
        </a>
      </h4>
    </div>
    <div id="collapse9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading9">
      <div class="panel-body">
        <span class="dropcap simple">A: </span>Once a product is removed, it is no longer part of your 'my product list'. So, no reminders will be given once a product is removed. You can add the product back to your personal list anytime from the 'List of Xooma products', however all your previous consumption data will have been cleared.



      </div>
    </div>
  </div>

       <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading10">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse10" aria-expanded="false" aria-controls="collapseTwo">
          Why should I enter my measurements?
        </a>
      </h4>
    </div>
    <div id="collapse10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading10">
      <div class="panel-body">
        <span class="dropcap simple">A: </span>By entering your body measurements, we can help you track your progress – especially if you are trying to lose weight or re-shape your body. Updating the measurements on a regular basis helps us to track your personal success with Xooma supplements which can be displayed in the progress chart.
    </div>
    </div>
  </div>

      <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading11">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse11" aria-expanded="false" aria-controls="collapseTwo">
        What is the progress chart?
        </a>
      </h4>
    </div>
    <div id="collapse11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading11">
      <div class="panel-body">
        <span class="dropcap simple">A: </span>The 'progress chart' displays the measurements you enter and update in a graphical format over time. Simply select the part of the body and the time duration you want to see to determine your progress. By default your progress for your weight measurement will be displayed.

    </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading12">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse12" aria-expanded="false" aria-controls="collapseTwo">
        What is the difference between the progress chart for weight and BMI?
        </a>
      </h4>
    </div>
    <div id="collapse12" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading12">
      <div class="panel-body">
        <span class="dropcap simple">A: </span>The progress chart for weight is displayed according to the weight you enter whereas your BMI (Body Mass Index) chart calculates your BMI based on your measurements, and displays your results compared to the normal BMI ratio scale for someone in your age bracket.

    </div>
    </div>
  </div>

  


  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading14">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse14" aria-expanded="false" aria-controls="collapseTwo">
       Can I see my previous updated consumptions and measurements?
        </a>
      </h4>
    </div>
    <div id="collapse14" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading14">
      <div class="panel-body">
        <span class="dropcap simple">A: </span>Yes. You can see your previous updated consumptions and measurements by using the 'history' option. Each Xooma product will have a usage history.
<b>Steps to view consumption history of any product :</b><br>
a. Go to your home screen <br>
b. Select the card of the desired product and click on the ‘menu’ option (Top right corner of the card) and select the option 'consumption history'<br>
<b>Steps to view Measurement history </b> <br>
a. Go to your home screen.<br>
b. Go to the progress chart card, click the menu on the card and select the option 'measurement history'.  

    </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading15">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse15" aria-expanded="false" aria-controls="collapseTwo">
         How do I view the consumption screen of a Xooma product?
        </a>
      </h4>
    </div>
    <div id="collapse15" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading15">
      <div class="panel-body">
        <span class="dropcap simple">A: </span>From your home screen take the following steps:<br>
       a. For X2O, click on ‘hydrate’ or<br>
       b. For any other supplement, click on ‘Tap to take’.

    </div>
  </div>
    </div>
   <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading16">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse16" aria-expanded="false" aria-controls="collapseTwo">
          How can I receive email notifications?
        </a>
      </h4>
    </div>
    <div id="collapse16" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        <span class="dropcap simple">A: </span>An 'Email alerts' option is available. This is available under Menu>Settings>Email alerts  simply select the 'on' switch to receive email alerts.

    </div>
    </div>
  </div>
</div>
                </div>
       
        <div class="clearfix"></div>
        
 
  </script>


    <title></title>
</head>

<body>
</body>
</html>