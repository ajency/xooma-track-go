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

<?php wp_head(); ?>
</head>




<body>


<script type="text/javascript">
 window.fbAsyncInit = function() {
  FB.init({
    appId      : '376973229145085',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.1' // use version 2.1
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

 



</script>
<script src="<?php echo get_template_directory_uri(); ?>/bower_components/jquery/dist/jquery.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/bower_components/jquery.validation/dist/jquery.validate.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/bower_components/underscore/underscore.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/bower_components/backbone/backbone.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/bower_components/backbone.marionette/lib/core/backbone.marionette.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/bower_components/handlebars/handlebars.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/bower_components/ajency.marionette/dist/ajency.marionette.js"></script>
<script type="text/javascript">
$('#fb-button').click(function(event){

	window.currentUser.authenticate('facebook');
})
</script>

<input type="button" id="fb-button" value="Fb" >
<?php wp_footer(); ?>	
</body>	
</html>
