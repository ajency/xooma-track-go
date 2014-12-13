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
<div ui-region>
<div id="fb-root"></div>
</div>
<!-- Templates -->
<script id="login-template" type="h-template">
    <h1>Add Login Screen Markup Here</h1>
    <div class="btn btn-primary f-login-button" >Login With Facebook</div>
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
                                <img alt="Brand" src="http://localhost/xooma/wp-content/themes/twentytwelve/xoomaapp/images/logo.png" class="img-reponsive" width="200px">
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
                        <li><a href="#/xooma-products"><i class="fa fa-check-circle-o"></i> 
                            <span class="hidden-xs">XOOMA PRODUCTS</span></a></li>
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
            <img src="assets/images/profile.jpg" alt="..." class="img-circle center-block" width="150px" height="150px">
            <h6 class="text-center bold">You are on the the spot!</h6>
            <p class="text-center">Let us know something about you.</p>
            <br>
            <div class="row">
                <div class="col-sm-offset-3 col-sm-6">
                    <form class="form-horizontal" role="form">
                      <div class="form-group">
                        <label for="text1" class=" col-sm-3 control-label">xooma id</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="text1" placeholder="0001">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="text2" class=" col-sm-3 control-label">Name</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="text2" placeholder="Martin Luther">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="text3" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="text3" placeholder="xyz@mail.com">
                        </div>
                      </div>
                     <div class="form-group">
                        <label for="text4" class="col-sm-3 control-label">Phone</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="text4" placeholder="0010100100">
                        </div>
                      </div>
                     <div class="form-group">
                        <label for="text5" class=" col-sm-3 control-label">Gender</label>
                        <div class="col-sm-9">
                        <div class="rd-gender">
                                  <label class="wrap">
                                    <input type="radio" name="city" class="radio" checked="checked"/>
                                    <span class="rd-visual male" title="Male"></span>
                                  </label>
                                  <label class="wrap">
                                    <input type="radio" name="city" class="radio"/>
                                    <span class="rd-visual female" title="Female"></span>
                                  </label>
                            </div>
                        </div>
                      </div>
                        <div class="form-group">
                            <label for="text7" class=" col-sm-3 control-label">Birth date</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="text7" placeholder="">
                            </div>
                      </div>  
                       <div class="form-group">
                            <label for="text8" class=" col-sm-3 control-label">Time Zone</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="text8" placeholder="">
                            </div>
                      </div> 
                
                        <div class="row">
                           <div class="col-sm-12">
                              <button type="button" class="btn btn-primary btn-lg pull-right">Next</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</script>
<script id="profile-measurements-template" type="h-template">
    <div id="measuremnt" class="section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h5 class="text-center bold">Set your mesurements</h5>
                    <p class="text-center">Knowing this information will help us determine the ideal amount of X2O water that your bodyneeds on a daily basis </p>
                    <div class="row">
                        <div class="col-md-5 col-xs-6">
                            <img src="assets/images/height.png" class="pull-right m-t-40">
                        </div>
                        <div class="col-md-7">
                            <h4 class="text-left"> <output></output><small>Feet</small></h4>
                        </div>
                        <input type="range" min="4" max="9" step="0.1" value="1.1" data-rangeslider>
                    </div>
                    </br>
                    </br>
                    <div class="row">
                        <div class="col-md-5 col-xs-6">
                            <img src="assets/images/weight.jpg" class="pull-right m-t-40">
                        </div>
                        <div class="col-md-7 ">
                            <h4 class="text-left"> <output></output><small>pounds</small></h4>
                        </div>
                        <input type="range" min="25" max="500" step="1" value="25" data-rangeslider>
                    </div>
                    </br>
                    </br>
                </div>
                <div class="col-sm-6 imageMap">
                    <a id="element" tabindex="0" class="hotspot-neck " data-toggle="popover" title="Neck" data-content="<input                               type='text'>"><i class="fa fa-dot-circle-o"></i></a>
                    <a id="element1" tabindex="0" class="hotspot-chest " data-toggle="popover" title="Chest" data-content="                                    <input type='text'>"><i class="fa fa-dot-circle-o"></i></a>
                    <a id="element2" tabindex="0" class="hotspot-arm " data-toggle="popover" title="Upper Arm" data-content="                                    <input type='text'>"><i class="fa fa-dot-circle-o"></i></a>
                    <a id="element3" tabindex="0" class="hotspot-abdomen " data-toggle="popover" title="Abdomen" data-content="<input type='text'>"><i class="fa fa-dot-circle-o"></i></a>
                    <a id="element4" tabindex="0" class="hotspot-waist " data-toggle="popover" title="Waist" data-content="                                    <input type='text'>"><i class="fa fa-dot-circle-o"></i></a>
                    <a id="element5" tabindex="0" class="hotspot-hips " data-toggle="popover" title="Hips" data-content="<input type='text'>"><i class="fa fa-dot-circle-o"></i></a>
                    <a id="element6" tabindex="0" class="hotspot-thigh " data-toggle="popover" title="Upper Thigh" data-content="<input type='text'>"><i class="fa fa-dot-circle-o"></i></a>
                    <a id="element7" tabindex="0" class="hotspot-midcalf " data-toggle="popover" title="Mid Calf" data-content="<input type='text'>"><i class="fa fa-dot-circle-o"></i></a>
                    <img src="assets/images/humanbody.png" class="center-block">
                </div>

            </div>
        </div>
    </div>
</script>
<!-- build:js({.js}) scripts/vendors.js -->
<!-- 
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/modernizr/modernizr.js"></script> 
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/detectizr/dist/detectizr.js"></script>  -->
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/underscore/underscore.js"></script> 
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jquery/dist/jquery.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/backbone/backbone.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/backbone.marionette/lib/backbone.marionette.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jquery.validation/dist/jquery.validate.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/handlebars/handlebars.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/plupload/js/moxie.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jQuery-Storage-API/jquery.storageapi.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/cryptojslib/rollups/md5.js"></script>
<!-- endbuild -->

<!-- build:js({*.js}) scripts/ajency.js -->
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/marionette.state/dist/marionette.state.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/ajency.marionette/dist/ajency.marionette.js"></script>
<!-- endbuild -->



<script type="text/javascript">
  userData = <?php echo json_encode(aj_get_user_model(get_current_user_id())); ?>;
  App                   = new Marionette.Application()  
  //App.LoginCtrl         = Ajency.LoginCtrl  
  App.NothingFoundCtrl  = Ajency.NothingFoundCtrl
  APIURL                = '<?php echo json_url() ?>';
  _SITEURL              = '<?php echo site_url() ?>';

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1548551822025926',
      xfbml      : true,
      version    : 'v2.2'
    });

    FB.getLoginStatus(function(response){
      if(response.status === 'connected'){
          FB.api('/me', function(user){
            App.currentUser.authenticate('facebook', user, response.authResponse.accessToken);
          });
      }
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<!-- build:js(*.js) application.js -->
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/common/common.js"></script>   
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/xooma/xooma.app.root.ctrl.js"></script>   
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/app.js"></script>	
<!-- endbuild -->

</body>	
</html>
