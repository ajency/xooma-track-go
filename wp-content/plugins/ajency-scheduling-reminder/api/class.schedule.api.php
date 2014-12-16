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

	/**
	 * @api {post} /schedules Create new schedule
	 * @apiName Schedule
	 * @apiGroup Ajency
	 *
	 * @apiParam {schedule_data} Schedule data
	 *
	 * @apiSuccess {array}
	 */
	public function add_schedule($schedule_data){

		$id = \ajency\ScheduleReminder\Schedule::add($schedule_data);

		if(is_wp_error($id )){
			$id->add_data(array('status' => 400));
			return $id;
		}

		$schedule = \ajency\ScheduleReminder\Schedule::get($id);

		$response = new WP_JSON_Response( $schedule );

		$id = $response->get_data();

		$response->header( 'Location', json_url( '/schedules/' . $id ));
		$response->set_status( 201 );

		return $response;
	}
}

/**
 * Register the endpoints
 * @param [type] $server [description]
 */
function add_ajency_schedule_api($server){
	$ajency_schedule_api = new AjencyScheduleAPI( $server );
	add_filter( 'json_endpoints', array( $ajency_schedule_api, 'register_routes'), 0 );
}
add_action( 'wp_json_server_before_serve', 'add_ajency_schedule_api', 10, 1 );
