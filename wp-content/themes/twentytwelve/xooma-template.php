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
<!--Css-->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/kendo.common.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/kendo.rtl.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/kendo.default.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/kendo.dataviz.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/kendo.dataviz.default.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/kendo.mobile.all.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/kendo.metroblack.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/kendo.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">
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
<!--css-->  
<?php wp_head(); ?>
</head>




<body>
<!-- #header-region -->
<div id="header-region">


</div>

<!-- main-region -->
<div  id="main-region" >




</div>

<!-- footer-region -->
<div id="footer-region"></div>


 
<script src="<?php echo get_template_directory_uri(); ?>/bower_components/jquery/dist/jquery.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/bower_components/jquery.validation/dist/jquery.validate.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/bower_components/underscore/underscore.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/bower_components/backbone/backbone.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/bower_components/backbone.marionette/lib/core/backbone.marionette.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/bower_components/backbone.wreqr/lib/backbone.wreqr.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/bower_components/handlebars/handlebars.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/bower_components/ajency.marionette/dist/ajency.marionette.js"></script>
<!--Script-->  
<!--Script-->

  


 
<script>
window.Xoomapp = {};
var AJAXURL = '<?php echo admin_url('admin-ajax.php') ?>';
var SITEURL = '<?php echo site_url() ?>';

</script>
<!--load all the apps-->
<script src="<?php echo get_template_directory_uri(); ?>/common/profile/ProfilePersonalInfoController.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/common/profile/ProfilePersonalInfoView.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/common/measurements/MeasurementController.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/common/measurements/MeasurementView.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/xoomaapp/app.js"></script>
  
   

<?php wp_footer(); ?>	
</body>	
</html>
