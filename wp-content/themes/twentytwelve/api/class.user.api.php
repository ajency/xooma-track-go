<?php

function im_json_api_default_filters_users( $server ) {


    global $user_api;

    global $user;

    global $productList;

    $user = new User();

    $productList = new ProductList();

    $user_api = new User_API( $server);


	add_filter( 'json_endpoints', array( $user_api, 'register_routes' ) );

}
add_action( 'wp_json_server_before_serve', 'im_json_api_default_filters_users', 12, 1 );


class User_API
{

	public function register_routes( $routes ) {
        //measurements
        $routes['/users/(?P<id>\d+)/measurements'] = array(
            array( array( $this, 'xooma_get_user_measurement_details'), WP_JSON_Server::READABLE),
            array( array( $this, 'xooma_update_user_measurement_details'), WP_JSON_Server::CREATABLE ),

        );
        $routes['/users/(?P<id>\d+)/profile'] = array(
            array( array( $this, 'xooma_get_user_profile_details'), WP_JSON_Server::READABLE),
            array( array( $this, 'xooma_update_user_profile_details'), WP_JSON_Server::EDITABLE | WP_JSON_Server::ACCEPT_JSON ),

        );
        //users
        $routes['/users/(?P<id>\d+)/products'] = array(
            array( array( $this, 'xooma_save_user_product_details'), WP_JSON_Server::CREATABLE),
            array( array( $this, 'xooma_get_user_products'), WP_JSON_Server::READABLE),

        );
        //update user's product
        $routes['/trackers/(?P<id>\d+)/products/(?P<pid>\d+)'] = array(
            array( array( $this, 'xooma_update_user_product_details'), WP_JSON_Server::CREATABLE),
            array( array( $this, 'xooma_get_user_product_details'), WP_JSON_Server::READABLE),
            array( array( $this, 'xooma_remove_user_product_details'), WP_JSON_Server::DELETABLE),

        );
        //get home products
        $routes['/records/(?P<id>\d+)'] = array(
            array( array( $this, 'xooma_get_user_home_products'), WP_JSON_Server::READABLE),
            array( array( $this, 'xooma_update_status'), WP_JSON_Server::CREATABLE),
        );







        return $routes;
    }

    public function xooma_get_user_profile_details($id){

    	//get details of the user id passed
    	global $user;

    	$response = $user->get_user_details($id);



        if(is_wp_error($response)){
        	$response = new WP_JSON_Response( $response );
            $response->set_status(404);

        }
        else
        {
            if ( ! ( $response instanceof WP_JSON_ResponseInterface ) ) {
           	 $response = new WP_JSON_Response( $response );
            }
            $response->set_status( 200 );
        }


        return $response;

    }

    public function xooma_update_user_profile_details($id, $data){
        //update details of the user id passed
        global $user;
        $data['id'] = $id;

        $response = $user->update_user_details($data);
        if(is_wp_error($response)){
        	return $response;
        }

        return $response;

    }

    public function xooma_update_user_measurement_details($id){

        //update measurements details of the user id passed
        global $user;
        
        $data = array();
        $data['id']                         = $id;
        $data['height']                     = $_REQUEST['height'];
        $data['weight']                     = $_REQUEST['weight'];
        $data['neck']                       = $_REQUEST['neck'];
        $data['chest']                      = $_REQUEST['chest'];
        $data['waist']                      = $_REQUEST['waist'];
        $data['abdomen']                    = $_REQUEST['abdomen'];
        $data['hips']                       = $_REQUEST['hips'];
        $data['thigh']                      = $_REQUEST['thigh'];
        $data['midcalf']                    = $_REQUEST['midcalf'];
        $data['calf']                       = $_REQUEST['calf'];


        $response = $user->update_user_measurement_details($data);

        if(is_wp_error($response)){
            $response = new WP_JSON_Response( $response );
            $response->set_status(404);
        }
        else
        {
            if ( ! ( $response instanceof WP_JSON_ResponseInterface ) ) {
            $response = new WP_JSON_Response( $response );
            }
            $response->set_status( 201 );

        }

        return $response;

    }

    public function xooma_get_user_measurement_details($id){

        //get measurements details of the user id passed
        global $user;

        $response = $user->get_user_measurement_details($id,$date="");

        if(is_wp_error($response)){
            $response = new WP_JSON_Response( $response );
            $response->set_status(404);
        }
        else
        {
            if ( ! ( $response instanceof WP_JSON_ResponseInterface ) ) {
            $response = new WP_JSON_Response( $response );
            }
            $response->set_status( 200 );

        }

        return $response;

    }

    public function xooma_save_user_product_details($id){

        // save user product details
        global $user;

        $pid = $_REQUEST['productId'];

        $response = $user->save_user_product_details($id,$pid);

        if(empty($response)){
            $response = new WP_JSON_Response( $response );
            $response->set_status(404);
        }
        else
        {
            if ( ! ( $response instanceof WP_JSON_ResponseInterface ) ) {
            $response = new WP_JSON_Response( $response );
            }
            $response->set_status( 201 );

        }

        return $response;

    }

    public function xooma_update_user_product_details($id,$pid){

        // update user product details
        global $user;

        $data = array();
        $data['frequency_type'] = $_REQUEST['frequency_type'];
        $data['servings_count'] = $_REQUEST['servings_count'];
        $data['servings_per_day'] = $_REQUEST['servings_per_day'];

        for($i=0;$i<$data['servings_count'];$i++)
        {
            $data['quantity_per_servings']  = $_REQUEST['quantity_per_servings'.$i];
            $data['when']                   = $_REQUEST['when'.$i];
            $data['hour']                   = $_REQUEST['hour'.$i];
            $data['min']                    = $_REQUEST['min'.$i];
            $data['period']                 = $_REQUEST['period'.$i];
        }

        $data['no_of_containers']   = $_REQUEST['no_of_containers'];
        $data['set_reminder']       = $_REQUEST['set_reminder'];





        $response = $user->update_user_product_details($id,$pid,$data);

        return $response;
    }

    public function xooma_remove_user_product_details($is,$pid){

        // removeuser product details
        global $user;

        $response = $user->delete_user_product_details($id,$pid);

        return $response;
    }

    public function xooma_get_user_products($id){

        global $user;

        $response = $user->get_user_products($id);

        if(count($response) == 0){
            $response = new WP_JSON_Response( $response );
            $response->set_status(404);
        }
        else
        {
            if ( ! ( $response instanceof WP_JSON_ResponseInterface ) ) {
            $response = new WP_JSON_Response( $response );
            }
            $response->set_status( 200 );

        }

        return $response;

    }

    public function xooma_get_user_home_products($id){

        global $user;

        $response = $user->get_user_home_products($id);

        if(count($response) == 0){
            $response = new WP_JSON_Response( $response );
            $response->set_status(404);
        }
        else
        {
            if ( ! ( $response instanceof WP_JSON_ResponseInterface ) ) {
            $response = new WP_JSON_Response( $response );
            }
            $response->set_status( 200 );

        }

        return $response;

    }

    public function xooma_update_status($id){

        $response = update_status($id);

        if (is_wp_error($response)){
            $response = new WP_JSON_Response( $response );
            $response->set_status(404);
        }
        else
        {
            if ( ! ( $response instanceof WP_JSON_ResponseInterface ) ) {
            $response = new WP_JSON_Response( $response );
            }
            $response->set_status( 201 );

        }

         return $response;
    }
}
