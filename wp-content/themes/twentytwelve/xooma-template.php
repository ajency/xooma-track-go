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

 
<?php wp_head(); ?>

    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/bower_components/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/bower_components/animate.css/animate.min.css">
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
    <div id="fb-root"></div>
    <script>

    window.fbAsyncInit = function() {
      FB.init({
        appId      : '376973229145085',
        cookie     : true,  // enable cookies to allow the server to access 
                            // the session
        version:  'v1.0',
        xfbml      : true,  
      });
    };
    // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
    </script>
<div ui-region class="container-fluid">

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
    <h1>Add xooma header template here</h1>
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
<!-- main-region -->
<div  id="main-region" >




</div>

<!-- footer-region -->
<div id="footer-region"></div>


<script>
window.Xoomapp = {};
var AJAXURL = '<?php echo admin_url('admin-ajax.php') ?>';
var SITEURL = '<?php echo site_url() ?>';

</script>
 
   

<?php wp_footer(); ?>	

</script>
<input type="button" name="login" id="login" value="login" onclick="checklogin()" />
<!-- build:js({.tmp,app}) scripts/vendors.js -->
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/underscore/underscore.js"></script> 
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jquery/dist/jquery.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jquery.validation/dist/jquery.validate.js"></script><script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/bower_components/backbone/backbone.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/backbone.marionette/lib/backbone.marionette.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/marionette.state/dist/marionette.state.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/handlebars/handlebars.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/ajency.marionette/dist/ajency.marionette.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/marionette.state/dist/marionette.state.js"></script>
<!-- endbuild -->

<!-- build:js(.) scripts/application.js -->
<script "text/javascript">
function checklogin() {
  FB.login(function (response) {
    if (response.authResponse) {
      var access_token =   FB.getAuthResponse()['accessToken'];
     console.log('Access Token = '+ response);
     FB.api('/me', {fields:'email,picture,id,first_name,last_name'} , function(response) {
     console.log('Good to see you, ' + response.picture.data.url + '.');
     data = 'id='+response.id+'&first_name='+response.first_name+'&last_name='+response.last_name+'&email='+response.email+'&picture='+response.picture.data.url
     $.ajax({
                type : 'POST',
                url : SITEURL+'/wp-json/tokens',
                data : data,
                success:function(response){
                    console.log(response);
                },
                error:function(error){
                    console.log(error); 
                    
                } 
            });
     });
      
      
      }
    else {
      alert("Login attempt failed!");
    }
  }, { scope: 'email,user_photos,publish_actions' });

}
var App = new Marionette.Application
App.LoginCtrl = Ajency.LoginCtrl
App.NothingFoundCtrl = Ajency.NothingFoundCtrl 
// $.post(APIURL + '/authenticate', {}, function(resp){console.log(resp);}, 'json');
</script>
<!--load all the apps-->
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/xooma/xooma.app.root.ctrl.js"></script>  
<script src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/profile/ProfilePersonalInfoCtrl.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/profile/ProfilePersonalInfoView.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/app.js"></script>	
<!-- endbuild -->


</body>	
</html>
