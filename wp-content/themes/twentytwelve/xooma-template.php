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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
      <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/xoomaapp/images/favicon.png">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/xoomaapp/css/theme.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/animate.css/animate.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/pickadate/lib/themes/default.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jquery-ui/themes/smoothness/jquery-ui.min.css">
   <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/xoomaapp/css/bootstrap-timepicker.min.css">





</head>
<body class="gradient">
<div ui-region></div>
<div id="fb-root"></div>
<!-- Templates -->
<?php include_once 'xoomaapp/inline-templates.php'; ?>

<script type="text/javascript">
window.ParsleyConfig = {
  validators: {
    equalTo: {
      fn: function (value, requirement) {
      	return value.length == requirement;
      }
    }
  },
  i18n: {
    en: {
      equalTo: 'Enter valid 6 digits Xooma ID'
    }
  }
};



</script>
    
<!-- build:js({.js}) scripts/vendors.js -->
<?php if ( is_development_environment() ) { ?>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/underscore/underscore.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/backbone/backbone.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/backbone.marionette/lib/backbone.marionette.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/backbone.syphon/lib/backbone.syphon.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/parsleyjs/dist/parsley.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/handlebars/handlebars.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/pickadate/lib/compressed/picker.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/pickadate/lib/compressed/picker.date.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/pickadate/lib/compressed/picker.time.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/plupload/js/moxie.min.js"></script>
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
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/ea-vertical-progress/dist/ea-progress-vertical.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/moment-timezone/moment-timezone.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>

<!-- endbuild -->

<!-- build:js({*.js}) scripts/ajency.js -->
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/marionette.state/dist/marionette.state.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/bower_components/ajency.marionette/dist/ajency.marionette.js"></script>
<!-- endbuild -->
<?php 
 }
?>

<?php if (! is_development_environment() ) {?>

<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/dist/plugins.min.js"></script>

<?php }
 
?>
<script type="text/javascript">
var App  = new Marionette.Application()

  
<?php echo  aj_get_global_js_vars(); ?>
<?php echo aj_get_facebook_js(); ?>
 



var Messages = <?php echo json_encode(load());?>;
var x2oMessages = <?php echo json_encode(load_x2o());?>;


</script>



 
<!-- build:js(*.js) application.js -->
<?php if ( is_development_environment() ) { ?>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/common/common.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/xooma/xooma.app.root.ctrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/profile/profile.ctrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/profile/personalinfo.ctrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/profile/measurements.ctrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/products/product.entity.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/products/add/add.products.ctrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/products/products.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/profile/userproductlistctrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/home/homectrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/products/edit/edit.products.ctrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/products/inventory/update.inventory.ctrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/products/history/history.inventory.ctrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/consumption/asperbmi/asperbmi.ctrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/consumption/scheduled/products.schedule.ctrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/history/history.product.ctrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/settings/settings.ctrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/history/history.measurements.ctrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/loading/loading.ctrl.js"></script>
<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/loading/workflow.ctrl.js"></script>

<!-- endbuild -->
<script "text/javascript" src="<?php echo site_url(); ?>/wp-content/themes/twentytwelve/js/tooltip.js"></script>
<script "text/javascript" src="<?php echo site_url(); ?>/wp-content/themes/twentytwelve/js/owl.carousel.min.js"></script>
<script "text/javascript" src="<?php echo site_url(); ?>/wp-content/themes/twentytwelve/js/slick.min.js"></script>   

<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/scripts/app.js"></script>
<?php 
}

?>
<?php if (! is_development_environment() ) {?>

<script "text/javascript" src="<?php echo get_template_directory_uri(); ?>/xoomaapp/dist/appliction.min.js"></script>

<?php }
 
?>


    <!-- Frontpage Demo -->

<script type="text/javascript">
function isWebView(){
    return !(!window.cordova && !window.PhoneGap && !window.phonegap)

}

function removeMsg()
{
  setTimeout(function(){ $('.aj-response-message').removeClass('alert alert-danger');$('.aj-response-message').removeClass('alert alert-success');$('.aj-response-message').text(""); }, 3000);
}
$(window).bind('load',isWebView);
$(window).bind('load',removeMsg)
        
window.ParsleyValidator
  .addValidator('equalTo', function (value, requirement) {
  	return value.length == requirement;
  })
  .addMessage('en', 'equalTo', 'Enter valid 6 digits Xooma ID')
$(document).ready(function() {
$('.single-item').slick({
dots: true,
infinite: true,
speed: 500,
slidesToShow: 1,
slidesToScroll: 1,
 autoplay: true,
  autoplaySpeed: 2000
});
});


 
</script>
<script type="text/javascript">
//plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
jQuery(document).ready(function(){
    // This button will increment the value
    $('.qtyplus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            $('input[name='+fieldName+']').val(currentVal + 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
    // This button will decrement the value till 0
    $(".qtyminus").click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            $('input[name='+fieldName+']').val(currentVal - 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
});

</script>

<?php wp_footer(); ?>
</body>
</html>

 