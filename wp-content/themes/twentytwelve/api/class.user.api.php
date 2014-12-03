<?php

function im_json_api_default_filters_users( $server ) {
    
	
    global $user_api;

    global $user;

    $user = new User();

    $user_api = new User_API( $server);

    
	add_filter( 'json_endpoints', array( $user_api, 'register_routes' ) ); 

}
add_action( 'wp_json_server_before_serve', 'im_json_api_default_filters_users', 12, 1 );


class User_API
{

	public function register_routes( $routes ) {
        $routes['/profiles/(?P<id>\d+)'] = array(
            array( array( $this, 'xooma_get_user_details'), WP_JSON_Server::READABLE),
            array( array( $this, 'xooma_update_user_details'), WP_JSON_Server::CREATABLE ),

            
        );

        $routes['/measurements/(?P<id>\d+)'] = array(
            array( array( $this, 'xooma_get_user_measurement_details'), WP_JSON_Server::READABLE),
            array( array( $this, 'xooma_update_user_measurement_details'), WP_JSON_Server::CREATABLE ),
            
        );
        



        



        return $routes;
    }

    public function xooma_get_user_details($id){

    	//get details of the user id passed
    	global $user;

    	$response = $user->get_user_details($id);

        return $response;

    }

    public function xooma_update_user_details($id)
    {
        //update details of the user id passed
        global $user;

        $data = array();
        $data['id']                         = $id;
        $data['image']                      = $_REQUEST['image'];
        $data['xooma_member_id']            = $_REQUEST['xooma_member_id'];
        $data['phone_no']                   = $_REQUEST['phone_no'];
        $data['birth_date']                 = $_REQUEST['birth_date'];
        $data['gender']                     = $_REQUEST['gender'];
        $data['timezone']                   = $_REQUEST['timezone'];

        $response = $user->update_user_details($data);

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

        return $response;

    }

    public function xooma_get_user_measurement_details($id,$date={}){

        //get measurements details of the user id passed
        global $user;

        $response = $user->get_user_measurement_details($id);

        return $response;

    }
}