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
        $routes['/users'] = array(
            array( array( $this, 'xooma_get_user_details'), WP_JSON_Server::READABLE),
            array( array( $this, 'xooma_update_user_details'), WP_JSON_Server::EDITABLE ),
            
        );
        



        



        return $routes;
    }

    public function xooma_get_user_details($id){

    	//get details of the user id passed
    	global $user;

    	$response = $user->get_user_details($id);

    }

    public function xooma_update_user_details($id)
    {
        //update details of the user id passed
        global $user;

        $response = $user->update_user_details($id);

    }
}