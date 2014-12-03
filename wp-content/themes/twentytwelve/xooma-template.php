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

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/xoomaapp/css/style.css">
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
    <h1>Login Screen</h1>
    <a class="btn btn-primary" href="#/personal-info">Login</a>
</script>
<script id="404-template" type="h-template">
<h3>Nothing found</h3>
</script>
<script id="no-access-template" type="h-template">
    sss
    {{#if noaccess}}
    <h1>No Access Template</h1>
    {{/if}}
    {{#if noaccesslogin}}
    <h1>No Access Template. Please  login</h1>
    {{/if}}
    {{#if notdefined}}
    <h1>Not defined. Please configure</h1>
    {{/if}}

</script>
<!-- build:js({.tmp,app}) scripts/scripts.js -->
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/underscore/underscore.js"></script> 
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jquery/dist/jquery.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/backbone/backbone.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/backbone.marionette/lib/backbone.marionette.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/handlebars/handlebars.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/marionette.state/dist/marionette.state.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/ajency.marionette/dist/ajency.marionette.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/config.js"></script>
<script "text/javascript">
App = new Marionette.Application
App.LoginCtrl = Ajency.LoginCtrl
App.NothingFoundCtrl = Ajency.NothingFoundCtrl 
</script>
<!--load all the apps-->
<!-- Profile module --
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/profile/personalinfo.ctrl.js"></script> 
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/profile/profile.states.js"></script> 
-->
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/xooma/xooma.app.root.ctrl.js"></script> 
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/xooma/xooma.states.js"></script> 
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/app.js"></script>	
</body>	
</html>
