<?php

/**
 * xooma functions file
 *
 * @package    WordPress
 * @subpackage xooma
 * @since      xooma 0.0.1
 */
#load all the classes
require_once (get_template_directory().'/classes/product.class.php');
require_once (get_template_directory().'/classes/productList.class.php');
#load all the classes

#load all the apis
require_once (get_template_directory().'/api/class.product.api.php');
#load all the apis
require_once (get_template_directory().'/csv/CSV.php');
require_once (get_template_directory().'/csv/csv.export.import.php');
#load csv import class file

#load all the custom scripts

function load_scripts(){
        wp_enqueue_script( "jquery",
                        get_template_directory_uri() . "/js/jquery.js",
                        array(),
                        get_current_version(),
                        TRUE );
        wp_enqueue_script( "validate",
                        get_template_directory_uri() . "/js/jquery.validate.js",
                        array(),
                        get_current_version(),
                        TRUE );
        wp_enqueue_script( "plupload_script",
                        get_template_directory_uri() . "/js/plupload.full.js",
                        array(),
                        get_current_version(),
                        TRUE );
       wp_enqueue_script( "product_script",
                        get_template_directory_uri() . "/js/product.js",
                        array(),
                        get_current_version(),
                        TRUE );

        

}
add_action('init' , load_scripts);

#load all the custom scripts

//formatted echo using pre tags can be used to echo out data for testing purpose

function formatted_echo($data){

    echo "<pre>";

    print_r($data);

    echo "</pre>";

}

function xooma_theme_setup() {

    // load language
    load_theme_textdomain( 'xooma', get_template_directory() . '/languages' );

    // add theme support
    add_theme_support( 'post-formats', array( 'image', 'quote', 'status', 'link' ) );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'menus' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

    // define you image sizes here
    add_image_size( 'xooma-full-width', 1038, 576, TRUE );

    // This theme uses its own gallery styles.
    add_filter( 'use_default_gallery_style', '__return_false' );

}

add_action( 'after_setup_theme', 'xooma_theme_setup' );


function xooma_after_init() {

    show_admin_bar( FALSE );
}

add_action( 'init', 'xooma_after_init' );



function is_development_environment() {

    if ( defined( 'ENV' ) && ENV === "production" )
        return FALSE;

    return TRUE;
}


function get_current_version() {

    global $wp_version;

    if ( defined( 'VERSION' ) )
        return VERSION;

    return $wp_version;

}

if ( is_development_environment() ) {
 
    function xooma_dev_enqueue_scripts() {

             // localized variables

        wp_enqueue_media();
        wp_localize_script(  "product_script", "SITEURL", site_url() );
        wp_localize_script(  "product_script", "AJAXURL", admin_url( "admin-ajax.php" ) );
        wp_localize_script(  "product_script", "ajaxurl", admin_url( "admin-ajax.php" ) );
        wp_localize_script(  "product_script", "UPLOADURL", admin_url( "async-upload.php" ) );
        wp_localize_script(  "product_script", "_WPNONCE", wp_create_nonce( 'media-form' ) );
            

        
       
    }
 
        add_action( 'wp_enqueue_scripts', 'xooma_dev_enqueue_scripts' );
        #action hook into the admin section scripts
        add_action( 'admin_enqueue_scripts', 'xooma_dev_enqueue_scripts' );



   

    
   
}

if (! is_development_environment() ) {

    function xooma_production_enqueue_script() {

            wp_localize_script(  "$module-script", "SITEURL", site_url() );
            wp_localize_script(  "$module-script", "AJAXURL", admin_url( "admin-ajax.php" ) );
            wp_localize_script(  "$module-script", "ajaxurl", admin_url( "admin-ajax.php" ) );
            wp_localize_script(  "$module-script", "UPLOADURL", admin_url( "async-upload.php" ) );
            wp_localize_script(  "$module-script", "_WPNONCE", wp_create_nonce( 'media-form' ) );
                  
    }

       add_action( 'wp_enqueue_scripts', 'xooma_production_enqueue_script' );
       #action hook into the admin section scripts
       add_action( 'admin_enqueue_scripts', 'xooma_production_enqueue_script' );
  
    
    
}
add_action( 'init', 'create_taxonomy_option', 0 );

function create_taxonomy_option() {

    // Project Categories
    register_taxonomy( 'products', array( 'products' ), array(
        'hierarchical'  => TRUE,
        'label'         => 'Products Categories',
        'singular_name' => 'Products Category',
        'show_ui'       => TRUE,
        'query_var'     => TRUE,
        'rewrite'       => array( 'slug' => 'products' )
    ) );
}

function register_menu() {
  add_menu_page( __( 'Add Product' ), __( 'Add Product' ), 
    'manage_options', 'product_settings', 'set_product_settings');
  add_submenu_page( 'product_settings', 'Settings page title', 'Products', 
    'manage_options', 'theme-op-settings', 'show_list_products');
  add_submenu_page( 'product_settings', 'Import', 'Import', 
    'manage_options', 'theme-op-faq', 'import_products');

}
add_action('admin_menu', 'register_menu');


function set_product_settings(){

    global $wpdb;
    $product_type_table = $wpdb->prefix . "product_type";
    $product_type_option = "";
    #get the values from product_type table
    $product_types = $wpdb->get_results( "SELECT id, name FROM $product_type_table" );
    foreach ( $product_types as $product_type ) 
    {
        $product_type_option .= "<option value='".$product_type->id."'>".$product_type->name."</option>";
    }

?> 

<html>
<h2>Add Product</h2>
<label id="response_msg" class="alert"></label>
<form id="add_product_form" enctype="multipart/form-data" method="POST">
<table class="widefat">
    <tbody>
        <tr>
            <td class="row-title"><label for="tablecell">Name</label></td>
            <td><input name="name" id="name" required type="text" value="" class="regular-text" /></td>
        </tr>
        <tr >
            <td class="row-title"><label for="tablecell">Active</label></td>
            <td><input name="active" type="checkbox" id="active" value="1"  checked /></td>
            <td>
                <a href="#" class="custom_media_upload">Upload</a>
                <img class="custom_media_image" src="" />
                <input class="custom_media_url" type="hidden" name="attachment_url" value="">
                <input class="custom_media_id" type="hidden" name="attachment_id" value=""></td>
        </tr>
        <tr>
            <td class="row-title"><label for="tablecell">Short Description</label></td>
            <td><?php echo wp_editor( "", "short_desc");?><!--<textarea id="short_desc" required name="short_desc" cols="80" rows="10"></textarea>--></td>
        </tr>
        <tr >
            <td class="row-title"><label for="tablecell">Product Type</label></td>
            <td><select required  id="product_type" name="product_type">
                <option value=""></option>
                <?php echo $product_type_option ;?>
            </select></td>
        </tr>
        <tr >
            <td class="row-title"><label for="tablecell">Frequncy</label></td>
            <td><select required id="frequency" name="frequency">
                <option value=""></option>
                <option  value="1" >Anytime</option>
                <option value="2" >Scheduled</option>
            </select></td>
        </tr>
        <tr >
            <td class="row-title"><label for="serving_per_day">Serving per day</label></td>
            <td><select required id="serving_per_day_anytime" name="serving_per_day_anytime">
                <option value=""></option>
                <option  value="1" >1</option>
                <option value="2" >2</option>
                <option value="3" >3</option>
                <option value="4" >4</option>
                <option value="5" >5</option>
                <option value="6" >6</option>
                <option value="7" >7</option>
                <option value="8" >8</option>
                <option value="9" >9</option>
                <option value="10" >10</option>
            </select>
            <select required id="serving_per_day_scheduled" name="serving_per_day_scheduled" style="display:none" >
                <option value=""></option>
                <option  value="1">Once</option>
                <option value="2">Twice</option>
                </select></td>
        </tr>
        <tr id="row_when" style="display:none">
            <td class="row-title"><label for="when">When</label></td>
            <td><select required id="when" name="when">
                <option value=""></option>
                <option  value="1" >Morning before Meal</option>
                <option value="2" >Morning with Meal</option>
                <option value="3" >Evening before Meal</option>
                <option value="4" >Evening with Meal</option>
                
            </select></td>
        </tr>
        <tr>
            <td class="row-title"><label for="serving_size">Serving Size</label></td>
            <td><input type="text" required id="serving_size" name="serving_size" value="" class="small-text" /></td>
        </tr>
        <tr>
            <td class="row-title"><label for="serving_per_container">Serving per Container</label></td>
            <td><input type="text" required id="serving_per_container" name="serving_per_container" value="" class="small-text" /></td>
        </tr>
        <tr>
            <td class="row-title"><label for="total">Total</label></td>
            <td><label id="total"></label></td>
        </tr>    
    </tbody>
    
</table>

<br/>
<input class="button-primary" type="submit" name="save" id="save" value="Save" /> 
<input class="button-primary" type="button" name="cancel" id="cancel" value="Cancel" /> 
</form>
</html>

<?php
}

function show_list_products(){

?>

<html>
<div id="form_data">
<h2>Products</h2>
<form id="show_product_form" enctype="multipart/form-data" method="POST">
<div style="position:relative;float:left"><label>Total Number : </label><label id="total_products"></label></div>
<div style="position:relative;float:right">
<a class="button-secondary" href="#" name="export" id="export" title="<?php _e( 'Export' ); ?>"><?php _e( 'Export' ); ?></a></div>
<table id="prodcts_table" class="widefat">
    <thead>
        <tr>
            <th class="row-title">Product Name</th>
            <th class="row-title">Product Type</th>
            <th class="row-title">Frequency</th>
            <th class="row-title">Modified Date</th>
            <th class="row-title">Active</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
    
</table>


</form>
</div>
</html>



<?php
}
//function to show import button
function import_products(){

?>
<html>
<h2>Import</h2></br/>
<form id="import_products_form" enctype="multipart/form-data" action="" method="post">
<div>
<input name="fileUpload" id="fileUpload" type="file"></br></br>
<input class="button-primary" id="import" type="submit" name="import" value="<?php _e( 'Import' ); ?>" />    
</div>
</form>
</html>


<?php
}
