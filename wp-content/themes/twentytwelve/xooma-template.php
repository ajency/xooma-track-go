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
<body>
<div ui-region>
</div>
<!-- Templates -->
<script id="login-template" type="h-template">
    <h1>Add Login Screen Markup Here</h1>
    <a class="btn btn-primary" href="#/">Login</a>
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
    <div class="sub-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                        <ul class="list-inline" >
                            <li class="selected"><a><i class="fa fa-check-circle-o"></i> <span class="hidden-xs">PERSONAL INFO</span></a></li>
                            <li><a><i class="fa fa-check-circle-o"></i> <span class="hidden-xs">MEASUREMENT</span></a></li>
                            <li><a><i class="fa fa-check-circle-o"></i> <span class="hidden-xs">XOOMA PRODUCTS</span></a></li>
                            <li><a><i class="fa fa-check-circle-o"></i> <span class="hidden-xs">MYPRODUCTS</span></a></li>
                            
                        </ul>
                </div>
            </div>
        </div>    
    </div>
    <div ui-region></div>
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

<!-- build:js({.js}) scripts/vendors.js -->
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
    App.LoginCtrl         = Ajency.LoginCtrl  
    App.NothingFoundCtrl  = Ajency.NothingFoundCtrl
    APIURL                = '<?php echo json_url() ?>';
    _SITEURL              = '<?php echo site_url() ?>';
</script>

<!-- build:js(*.js) application.js -->
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/xooma/xooma.app.root.ctrl.js"></script>   
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/app.js"></script>	
<!-- endbuild -->

</body>	
</html>
