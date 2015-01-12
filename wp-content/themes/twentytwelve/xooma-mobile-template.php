<?php
/*
	Template Name: Xooma-mobile Template
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
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/pickadate/lib/themes/default.css">
	<script "text/javascript" src="<?php echo site_url(); ?>/wp-content/themes/twentytwelve/js/tooltip.js"></script>


	<script type="text/javascript">
	   
	function getUrlData()
	   {
			
			var FullURl = window.location.href;
			var access_token=FullURl.substring(FullURl.indexOf("=")+1,FullURl.indexOf("&"));
			console.log(access_token);
			window.location.href = "phoenixapp://?access_token="+access_token;
			
			
	   }


	 </script>

</head>
<body onload="getUrlData()" class="gradient">
<div ui-region></div>
<div id="fb-root"></div>
<!-- Templates -->




<!-- build:js({.js}) scripts/vendors.js -->
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/underscore/underscore.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/backbone/backbone.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/backbone.marionette/lib/backbone.marionette.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/backbone.syphon/lib/backbone.syphon.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/parsleyjs/dist/parsley.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/handlebars/handlebars.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/pickadate/lib/compressed/picker.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/pickadate/lib/compressed/picker.date.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/pickadate/lib/compressed/picker.time.js"></script><script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/plupload/js/moxie.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jQuery-Storage-API/jquery.storageapi.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/cryptojslib/rollups/md5.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/rrule/lib/rrule.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/rrule/lib/nlp.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jQuery.mmenu/src/js/jquery.mmenu.min.all.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/rangeslider.js/dist/rangeslider.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/classie/classie.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/moment/min/moment.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/chartjs/Chart.js"></script>
<!-- endbuild -->

<!-- build:js({*.js}) scripts/ajency.js -->
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/marionette.state/dist/marionette.state.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/ajency.marionette/dist/ajency.marionette.js"></script>
<!-- endbuild -->






</body>
</html>

 <?php wp_footer(); ?>