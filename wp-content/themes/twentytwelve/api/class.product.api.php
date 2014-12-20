<?php 
function im_json_api_default_filters( $server ) {
    
	global $product;

    global $product_api;

    global $product_list;

    global $setting;

    $product_api = new Product_API( $server);

    $product = new Product();

    $product_list = new ProductList();

    $setting = new setting();
    
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
        
        $routes['/products/(?P<id>\d+)'] = array(
            array( array( $this, 'xooma_update_product'), WP_JSON_Server::EDITABLE ),
            array( array( $this, 'xooma_get_product'), WP_JSON_Server::READABLE ),

        );

        $routes['/settings'] = array(
            array( array( $this, 'xooma_create_product_settings'), WP_JSON_Server::CREATABLE),
            array( array( $this, 'xooma_get_product_settings'), WP_JSON_Server::READABLE ),
            
        );

        $routes['/profiles/(?P<id>\d+)'] = array(
            array( array( $this, 'xooma_get_user_details'), WP_JSON_Server::READABLE),
            array( array( $this, 'xooma_update_user_details'), WP_JSON_Server::CREATABLE ),

            
        );



        



        return $routes;
    }

    public function xooma_create_product(){

    	# get all the data paseed from the browser

    	global $product;

        //getting all the BMI values
        $bmi = array();
        $count = $_REQUEST['count'];
        for ($i=0; $i <= $count; $i++) { 
            if($_REQUEST['hide'.$i] == 0 && isset($_REQUEST['hide'.$i]))
            {
                $from           = $_REQUEST['weight_from'.$i];
                $to             = $_REQUEST['weight_to'.$i];
                $quantity       = $_REQUEST['quantity'.$i];
                $patten         = $from.'<'.$to;
                $bmi[]          = array(
                    'range'     => $patten,
                    'quantity'   => $quantity

                    );
            }


            
        }
        
        $data = array();
		$data['name'] 						= $_REQUEST['name'];
		$data['active'] 					= $_REQUEST['active'];
		$data['short_desc'] 				= $_REQUEST['short_desc'];
		$data['product_type'] 				= $_REQUEST['product_type'];
		$data['frequency'] 					= $_REQUEST['frequency'];
		$data['serving_per_day_anytime'] 	= $_REQUEST['serving_per_day_anytime'];
		$data['serving_per_day_scheduled'] 	= $_REQUEST['serving_per_day_scheduled'];
		$data['when'] 						= $_REQUEST['when'];
        $data['when_clone']                 = $_REQUEST['when_clone'];
		$data['serving_size'] 				= $_REQUEST['serving_size'];
        $data['serving_size_clone']         = $_REQUEST['serving_size_clone'];
		$data['serving_per_container'] 		= $_REQUEST['serving_per_container'];
		$data['attachment_id'] 				= $_REQUEST['attachment_id'];
		$data['active'] 					= $_REQUEST['active'];
        $data['bmi']                        =  $bmi;

        
    	$response = $product->create_product($data);

        if ( ! ( $response instanceof WP_JSON_ResponseInterface ) ) {
            $response = new WP_JSON_Response( $response );
        }

        $response->set_status( 201 );

        return $response;

    }

    public function xooma_update_product($id){

    	global $product;

        
        $putfp = fopen("php://input", "r");

        $putdata = '';
        while($data = fread($putfp, 1024))
            $putdata .= $data;
        
        $new_array = array();
        $putdata_array = explode('&', $putdata);
        foreach ($putdata_array as $key => $value) {
            $value_arr  = explode('=', $value);
            $new_array[] = array(
                'key'   => $value_arr[0],
                'value' => $value_arr[1]
                );
           
        }
        
        $data = array();
        # get all the data paseed from the browser
        foreach ($new_array as $key => $value) {
            $data[$value['key']] = $value['value'];
            # code...
        }
        //getting all the BMI values
        $bmi = array();
        $count = $data['count'];

        for ($i=0; $i <= $count; $i++) { 
            if($data['hide'.$i] == 0 && isset($data['hide'.$i])) 
            {
                $from           = $data['weight_from'.$i];
                $to             = $data['weight_to'.$i];
                $quantity       = $data['quantity'.$i];
                $patten         = $from.'<'.$to;
                $bmi[]          = array(
                    'range'     => $patten,
                    'quantity'   => $quantity

                    );
                
            }


            
        }
        
		$data['bmi'] = $bmi;
        
        
    	$response = $product->update_product($data);

    	return $response;
    	


    }

    public function xooma_get_products(){

    	global $product_list;

    	#if data of only one term is requested
    	$term_id =  "" ;

    	$response = $product_list->get_products($term_id);

    	return $response;
    	


    }

    public function xooma_get_product($id){

        global $product_list;

        

        $response = $product_list->get_products($id);

        return $response;
        


    }

    public function xooma_create_product_settings(){

        global $setting;

        $data = array();

        $data['no_of_days'] = $_REQUEST['no_of_days'];

        $data['morning_from'] = $_REQUEST['morning_from'];
        $data['morning_to'] = $_REQUEST['morning_to'];
        $data['evening_from'] = $_REQUEST['evening_from'];
        $data['evening_to'] = $_REQUEST['evening_to'];
        $data['settings_id'] = $_REQUEST['settings_id'];

        $response = $setting->create_setting($data);

        return $response;


    }

    public function xooma_get_product_settings(){

        global $setting;

        $response = $setting->get_settings();

        return $response;

    }

}
