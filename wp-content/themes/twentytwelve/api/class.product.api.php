<?php 
function im_json_api_default_filters( $server ) {
    
	global $product;

    global $product_api;

    global $product_list;

    $product_api = new Product_API( $server);

    $product = new Product();

    $product_list = new ProductList();
    
	add_filter( 'json_endpoints', array( $product_api, 'register_routes' ) );

}
add_action( 'wp_json_server_before_serve', 'im_json_api_default_filters', 12, 1 );


class Product_API 
{
	public function register_routes( $routes ) {
        $routes['/products'] = array(
            array( array( $this, 'xooma_create_product'), WP_JSON_Server::CREATABLE),
            array( array( $this, 'xooma_get_products'), WP_JSON_Server::READABLE ),
            
        );

        $routes['/products/update'] = array(
            array( array( $this, 'xooma_update_product'), WP_JSON_Server::CREATABLE ),

        );

        



        return $routes;
    }

    public function xooma_create_product(){

    	# get all the data paseed from the browser

    	global $product;

		$data = array();
		$data['name'] 						= $_REQUEST['name'];
		$data['active'] 					= $_REQUEST['active'];
		$data['short_desc'] 				= $_REQUEST['short_desc'];
		$data['product_type'] 				= $_REQUEST['product_type'];
		$data['frequency'] 					= $_REQUEST['frequency'];
		$data['serving_per_day_anytime'] 	= $_REQUEST['serving_per_day_anytime'];
		$data['serving_per_day_scheduled'] 	= $_REQUEST['serving_per_day_scheduled'];
		$data['when'] 						= $_REQUEST['when'];
		$data['serving_size'] 				= $_REQUEST['serving_size'];
		$data['serving_per_container'] 		= $_REQUEST['serving_per_container'];
		$data['attachment_id'] 				= $_REQUEST['attachment_id'];
		$data['active'] 					= $_REQUEST['active'];

    	$response = $product->create_product($data);

    	return $response;
    	


    }

    public function xooma_update_product(){

    	global $product;

    	# get all the data paseed from the browser
		

		$data = array();
		$data['id'] 						= $_REQUEST['id'];
		$data['name'] 						= $_REQUEST['name'];
		$data['active'] 					= $_REQUEST['active'];
		$data['short_desc'] 				= $_REQUEST['short_desc'];
		$data['product_type'] 				= $_REQUEST['product_type'];
		$data['frequency'] 					= $_REQUEST['frequency'];
		$data['serving_per_day_anytime'] 	= $_REQUEST['serving_per_day_anytime'];
		$data['serving_per_day_scheduled'] 	= $_REQUEST['serving_per_day_scheduled'];
		$data['when'] 						= $_REQUEST['when'];
		$data['serving_size'] 				= $_REQUEST['serving_size'];
		$data['serving_per_container'] 		= $_REQUEST['serving_per_container'];
		$data['attachment_id'] 				= $_REQUEST['attachment_id'];
		$data['active'] 					= $_REQUEST['active'];

    	$response = $product->update_product($data);

    	return $response;
    	


    }

    public function xooma_get_products(){

    	global $product_list;

    	#if data of only one term is requested
    	$term_id = ($_REQUEST['term_id'] != 0) ? $_REQUEST['term_id'] :  "" ;

    	$response = $product_list->get_products($term_id);

    	return $response;
    	


    }

}
