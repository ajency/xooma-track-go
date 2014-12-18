<?php
/*
    Template Name: Xooma Template
*/

?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?> xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?> xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/xoomaapp/css/theme.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/animate.css/animate.min.css">
    <style scoped>
        #buttongroup-home .head {
          display: block;
            margin: 1em;
          height: 110px;
          background: url(../content/mobile/shared/sales.jpg) no-repeat center center;
            -webkit-background-size: 100% auto;
            background-size: 100% auto;
        }
        .km-ios .head,
        .km-blackberry .head {
            -webkit-border-radius: 10px;
            border-radius: 10px;
        }
        #select-period {
            margin: auto;
        }
        #buttongroup-home .km-list span {
          float: right;
        }
        #buttongroup-home .sales-up {
          color: green;
        }
        #buttongroup-home .sales-down {
          color: red;
        }
        #buttongroup-home .sales-hold {
          color: blue;
        }
    </style>
</head>
<body class="gradient">
<div ui-region></div>
<div id="fb-root"></div>
<!-- Templates -->
<script id="login-template" type="h-template">
    <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <br><br>
    
    <!-- Indicators -->
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
                          <img src="<?php echo get_template_directory_uri(); ?>/images/slider1.jpg" alt=""  class="center-block">
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
            </div><button type="button" class="btn btn-primary btn-lg center-block aj-fb-login-button">Login with facebook</button>
             </div>
        
  
</script>
<script id="404-template" type="h-template">
    <h3>Add 404 View Here</h3>
</script>
<script id="xooma-app-template" type="h-template">
    <div class="topheader">
       <nav class="navbar " role="navigation">
              <div class="container">
                <div class="row">
                    <div class="col-sm-3 col-xs-5">
                      <div class="navbar-header">
                              <a  href="#">
                                <img alt="Brand" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/images/logo.png" class="img-reponsive" width="200px">
                              </a>
                        </div>
                    </div>
                       <div class="col-sm-9 col-xs-7">
                        <a href="#menu"> <h5><i class="fa fa-cog pull-right "></i></h5></a>
                    </div>
                </div>
              </div>
        </nav>
    </div>
    <div class="clearfix"></div>
    <div ui-region style="margin-top:60px"></div>
</script>
<script id="profile-template" type="h-template">
<div class="sub-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                    <ul class="list-inline" >
                        <li class="selected"><a href="#/profile/personal-info"><i class="fa fa-check-circle-o"></i> 
                            <span class="hidden-xs">PERSONAL INFO</span></a></li>
                        <li><a href="#/profile/measurements"><i class="fa fa-check-circle-o"></i> 
                            <span class="hidden-xs">MEASUREMENT</span></a></li>
                        <li><a href="#/12/products"><i class="fa fa-check-circle-o"></i> 
                            <span class="hidden-xs">MYPRODUCTS</span></a></li>
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
<script id="no-access-template" type="h-template">
    {{#if no_access}}
    <h1>Add no access View Here</h1>
    {{/if}}
    {{#if no_access_login}}
    <h1>Add no access with login options View Here</h1>
    {{/if}}
    {{#if not_defined}}
    <h1>This view is not configured. Please contact administrator</h1>
    {{/if}}
</script>
<script id="profile-personal-info-template" type="h-template">

    <div id="personalinfo" class="section">
        <div class="container">


            <form id="add_user_details" class="form-horizontal" role="form" method="POST">
            

            <img src="{{profile_picture.sizes.thumbnail.url}}" alt="..." class="img-circle center-block profile-picture" width="150px" height="150px">
            
            <h6 class="text-center bold">You are on the the spot!</h6>
            <p class="text-center">Let us know something about you.</p>
            <br>
            <div class="row">
                <div class="col-sm-offset-3 col-sm-6">
                <div class="response_msg"></div>
                    
                      <div class="form-group">
                        <label for="text1" class=" col-sm-3 control-label">xooma id</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="xooma_member_id" name="xooma_member_id" required value="{{xooma_member_id}}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="text2" class=" col-sm-3 control-label">Name</label>
                        <div class="col-sm-9">
                          <input type="text" readonly class="form-control" id="name" name="name" value="{{name}}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="text3" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                          <input type="email" readonly class="form-control" id="email_id" name="email_id" value="{{email_id}}">
                        </div>
                      </div>
                     <div class="form-group">
                        <label for="text4" class="col-sm-3 control-label">Phone</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="phone_no" name="phone_no" value="{{phone_no}}">
                        </div>
                      </div>
                     <div class="form-group">
                        <label for="text5" class=" col-sm-3 control-label">Gender</label>
                        <div class="col-sm-9">
                        <div class="rd-gender">
                                  <label class="wrap">
                                    <input type="radio" name="radio_grp" id="male" class="radio" value="male" />
                                    <span class="rd-visual male" title="Male"></span>
                                  </label>
                                  <label class="wrap">
                                    <input type="radio" name="radio_grp" id="female" class="radio" value="female"/>
                                    <span class="rd-visual female" title="Female"></span>
                                  </label>
                            </div>
                            <input type="hidden" name="gender" id="gender" value = "" />
                        </div>
                      </div>
                        <div class="form-group">
                            <label for="text7" class=" col-sm-3 control-label">Birth date</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="birth_date"  name="birth_date" required value="{{birth_date}}">
                            </div>
                      </div>  
                       <div class="form-group">
                            <label for="text8" class=" col-sm-3 control-label">Time Zone</label>
                            <div class="col-sm-9">
                                <select id="timezone" name="timezone">
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
                              <button type="submit" id="add_user" name="add_user" class="btn btn-primary btn-lg pull-right">Next</button>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </form>
        </div>
    </div>
</script>
<script id="profile-measurements-template" type="h-template">
    <div id="measuremnt" class="section">
        <div class="container">
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
                        <input type="range" min="4" max="9" step="0.1" value="{{height}}" id="height" name="height" required data-rangeslider>
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
                        <input type="range" min="25" max="500" step="1" value="{{weight}}" id="weight" name="weight" required data-rangeslider>
                    </div>
                    </br>
                    </br>
                </div>
                <div class="col-sm-6 imageMap">
                    <a id="element1" tabindex="0" class="popover-element hotspot-neck " data-toggle="popover" title="Neck" data-content="<input type='text' name='neck' id='neck' value='{{neck}}'>"><i class="fa fa-dot-circle-o"></i></a>
                    <a id="element2" tabindex="0" class="popover-element hotspot-chest " data-toggle="popover" title="Chest" data-content="<input type='text' name='chest' id='chest' value='{{chest}}'>"><i class="fa fa-dot-circle-o"></i></a>
                    <a id="element3" tabindex="0" class="popover-element hotspot-arm " data-toggle="popover" title="Upper Arm" data-content="<input type='text' name='arm' id='arm' value='{{arm}}'>"><i class="fa fa-dot-circle-o"></i></a>
                    <a id="element4" tabindex="0" class="popover-element hotspot-abdomen " data-toggle="popover" title="Abdomen" data-content="<input type='text' name='abdomen' id='abdomen' value='{{abdomen}}'>"><i class="fa fa-dot-circle-o"></i></a>
                    <a id="element5" tabindex="0" class="popover-element hotspot-waist " data-toggle="popover" title="Waist" data-content="<input type='text' name='waist' id='waist' value='{{waist}}'>"><i class="fa fa-dot-circle-o"></i></a>
                    <a id="element6" tabindex="0" class="popover-element hotspot-hips " data-toggle="popover" title="Hips" data-content="<input type='text' name='hips' id='hips' value='{{hips}}'>"><i class="fa fa-dot-circle-o"></i></a>
                    <a id="element7" tabindex="0" class="popover-element hotspot-thigh " data-toggle="popover" title="Upper Thigh" data-content="<input type='text' name='thigh' id='thigh' value='{{thigh}}'>"><i class="fa fa-dot-circle-o"></i></a>
                    <a id="element8" tabindex="0" class="popover-element hotspot-midcalf " data-toggle="popover" title="Mid Calf" data-content="<input type='text' name='midcalf' id='midcalf' value='{{midcalf}}'>"><i class="fa fa-dot-circle-o"></i></a>
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

<script id="home-template" type="h-template">
<div>
Add Home template here
</div>
</script>
<!-- build:js({.js}) scripts/vendors.js -->
<!-- 
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/modernizr/modernizr.js"></script> 
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/detectizr/dist/detectizr.js"></script>  -->

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/underscore/underscore.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/backbone/backbone.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/backbone.marionette/lib/backbone.marionette.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jquery.validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/handlebars/handlebars.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/plupload/js/moxie.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jQuery-Storage-API/jquery.storageapi.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/cryptojslib/rollups/md5.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/rrule/lib/rrule.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/rrule/lib/nlp.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jQuery.mmenu/src/js/jquery.mmenu.min.all.js"></script>  
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/rangeslider.js/dist/rangeslider.min.js"></script>
<!-- endbuild -->

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/common/facebook.js"></script>

<!-- build:js({*.js}) scripts/ajency.js -->
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/marionette.state/dist/marionette.state.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/ajency.marionette/dist/ajency.marionette.js"></script>
<!-- endbuild -->

<script type="text/javascript">
    App                   = new Marionette.Application()  
    APIURL                = '<?php echo json_url() ?>';
    _SITEURL              = '<?php echo site_url() ?>';
    facebookConnectPlugin.browserInit('376973229145085', 'v2.2');
</script>
<!-- build:js(*.js) application.js -->
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/common/common.js"></script>   
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/xooma/xooma.app.root.ctrl.js"></script>   
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/profile/ProfilePersonalInfoCtrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/profile/ProfilePersonalInfoView.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/measurements/profileMeasurementCtrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/measurements/MeasurementView.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/app.js"></script>
    <!-- endbuild -->
</body>	
</html>
  
