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
            array( array( $this, 'xooma_get_user_home_products'), WP_JSON_Server::READABLE),

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

         //inventory
        $routes['/inventory/(?P<id>\d+)/products/(?P<pid>\d+)'] = array(
            array( array( $this, 'xooma_store_inventory'), WP_JSON_Server::CREATABLE),
            array( array( $this, 'xooma_get_history'), WP_JSON_Server::READABLE),
        );

          //consumption
        $routes['/intakes/(?P<id>\d+)/products/(?P<pid>\d+)'] = array(
            array( array( $this, 'xooma_get_consumption_details'), WP_JSON_Server::READABLE),
            array( array( $this, 'xooma_store_consumption_details'), WP_JSON_Server::CREATABLE),
        );

        $routes['/intakesbmi/(?P<id>\d+)/products/(?P<pid>\d+)'] = array(
            array( array( $this, 'xooma_store_x2oconsumption_details'), WP_JSON_Server::CREATABLE),
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

    public function xooma_update_user_measurement_details($id){

        //update measurements details of the user id passed
        global $user;
       
        $date                               = $_REQUEST['date_field'];


        $response = $user->update_user_measurement_details($id,$_POST,$date);

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
        $servings = $_REQUEST['servings_per_day'];
        $data['servings_per_day'] = $_REQUEST['servings_per_day'];
        if($_REQUEST['timeset'] =="Once" || $_REQUEST['timeset'] =="Twice")
        {
           $servings = $_REQUEST['timeset'] == 'Once' ? 1 : 2 ;
           $data['servings_per_day'] = $servings;
           for($i=0;$i<$servings;$i++)
                {
                    
                    $data['qty_per_servings'.$i]  = $_REQUEST['qty_per_servings'.$i];
                    $data['when'.$i]              = $_REQUEST['when'.$i];
                                
                }

        }
        else if ($_REQUEST['timeset'] =="asperbmi")
        {
            $servings = $_REQUEST['x2o'];
            $data['servings_per_day'] = $_REQUEST['x2o'];
            for($i=0;$i<$servings;$i++)
            {
                $data['qty_per_servings'.$i]  = 1;
                $data['when'.$i]              = 1;
                
            }
        }
        else 
        {
            
            for($i=0;$i<$servings;$i++)
                {
                    $qty = $_REQUEST['check'] == 1 ? $_REQUEST['qty_per_servings'.$i] : $_REQUEST['qty_per_servings0'];
                    $data['qty_per_servings'.$i]  = $qty;
                    $data['when'.$i]              = 1;
                        
                }
        }
        
            
       
        
        

        $data['no_of_container']    = $_REQUEST['no_of_container'];
        $data['available']          = $_REQUEST['available'];
        $reminder = $_REQUEST['reminder'] == "" ? 0 : $_REQUEST['reminder'];
        $data['reminder']           = $reminder;
        $data['check']              = $_REQUEST['check'];
        $data['subtract']              = $_REQUEST['subtract'];

        $data['reminders_length'] = 0;
        if($_REQUEST['reminder'] == 1)
        {
            for($j=0;$j<$servings;$j++)
            {
                    
                $data['reminder_time'.$j]  = $_REQUEST['reminder_time'.$j];
            }
             $data['reminders_length'] = $servings ;
        }


        


        $response = $user->update_user_product_details($id,$pid,$data);

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

    public function xooma_remove_user_product_details($id,$pid){

        // removeuser product details
        global $user;

        

        $response = $user->delete_user_product_details($id,$pid);

        if(empty($response)){
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

    public function xooma_get_user_product_details($id,$pid)
    {

         global $user;

        

        $response = $user->get_user_product_details($id,$pid);

        if(empty($response)){
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

    public function xooma_store_inventory($id,$pid){

        $subtract = $_REQUEST['subtract'];
        $containers = $_REQUEST['containers'];
        $total = $_REQUEST['total'];
        //stroring trasaction to keeptrack of quantity
       


       

        if($containers !="") 
        {

            $stock = intval($total) * intval($containers);
             $args = array(

            'user_id'     => $id,
            'product_id'  => $pid,
            'type'        => 'stock',
            'amount'      =>  $stock,
            'consumption_type'  => ''


          );

          $response = store_stock_data($args);

      }

        //stroring trasaction to keeptrack of quantity\

          $args_del = array(

            'user_id'     => $id,
            'product_id'  => $pid,
            'type'        => 'remove',
            'amount'      =>  $subtract,
            'consumption_type'  => 'sales'


          );
          if($subtract !=0) 
          $response = store_stock_data($args_del);


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

    public function xooma_get_history($id,$pid){

        $response = get_history_user_product($id,$pid);

        if (is_wp_error($response)){
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

    public function xooma_get_consumption_details($id,$pid){


        $date = $_REQUEST['date'];

        $response = get_consumption_details($id,$pid,$date="");

        if (is_wp_error($response)){
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

    public function xooma_store_consumption_details($id,$pid){

        $qty = $_REQUEST['qty'];

        $meta_id = $_REQUEST['meta_id'];

        $args = array(

            'id'            => $id,
            'pid'           => $pid,
            'meta_id'       => $meta_id,
            'meta_value'    => array(
                'date'      => date('Y-m-d H:i:s'),
                'qty'       => $qty

                )


            );




        $response = store_consumption_details($args);

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

    public function  xooma_store_x2oconsumption_details($id,$pid){

        $qty = $_REQUEST['qty'];

        $meta_id = $_REQUEST['meta_id'];

        $args = array(

            'id'            => $id,
            'pid'           => $pid,
            'meta_id'       => $meta_id,
            'meta_value'    => array(
                'date'      => date('Y-m-d H:i:s'),
                'qty'       => $qty

                )


            );




        $response = store_x20consumption_details($args);

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
