<?php

class AjencyScheduleAPI{

	/**
	 * Server object
	 *
	 * @var WP_JSON_ResponseHandler
	 */
	protected $server;

	/**
	 * Constructor
	 *
	 * @param WP_JSON_ResponseHandler $server Server object
	 */
	public function __construct( WP_JSON_ResponseHandler $server ) {
		$this->server = $server;
	}

	public function register_routes( $routes = array()) {
		$auth_routes = array(
			'/schedules' => array(
				array( array( $this, 'add_schedule' ), WP_JSON_Server::CREATABLE )
			)
		);
		return array_merge( $routes, $auth_routes );
	}

	public function add_schedule($schedule_data){

		// if(!current_user_can('edit_schedule')){
		// 	return new WP_Error('no_permission', __('Sorry! You don't have enough permission), array('status' => 400));
		// }
		$response = AjSchedule::add($schedule_data);

		if ( ! ( $response instanceof WP_JSON_ResponseInterface ) ) {
			$response = new WP_JSON_Response( $response );
		}

		$id = $response->get_data();

		$response->header( 'Location', json_url( '/schedules/' . $id ));
		$response->set_status( 201 );

		return $response;

	}

}


add_action('init', function(){
	$schedule_data = array(
			'user_id' => 3,
			'action' => 'product_intake',
			'item_id' => 34,
			'rrule' => 'TEXTADDS:223423'
		);
	$r = AjSchedule::add($schedule_data);
	var_dump($r);
	die;
});
