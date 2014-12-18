<?php

class AjencyOccurrenceAPI{

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
		$occurrence_routes = array(
			'/occurrences' => array(
				array( array( $this, 'add_occurrence' ), WP_JSON_Server::CREATABLE )
			)
		);
		return array_merge( $routes, $occurrence_routes );
	}

	/**
	 * @api {post} /occurrences Create new occurrence
	 * @apiName occurrence
	 * @apiGroup Ajency
	 *
	 * @apiParam {occurrence_data} occurrence data
	 *
	 * @apiSuccess {array}
	 */
	public function add_occurrence($occurrence_data){

		$id = \ajency\Occurrence::add($occurrence_data);

		if(is_wp_error($id )){
			$id->add_data(array('status' => 400));
			return $id;
		}

		$occurrence = \ajency\Occurrence::get($id);

		$response = new WP_JSON_Response( $occurrence );

		$occurrence = $response->get_data();

		$response->header( 'Location', json_url( '/occurrences/' . $occurrence->meta_id ));
		$response->set_status( 201 );

		return $response;

	}
}

/**
 * Register the endpoints
 * @param [type] $server [description]
 */
function add_ajency_occurrence_api($server){
	$ajency_occurrence_api = new AjencyOccurrenceAPI( $server );
	add_filter( 'json_endpoints', array( $ajency_occurrence_api, 'register_routes'), 0 );
}
add_action( 'wp_json_server_before_serve', 'add_ajency_occurrence_api', 10, 1 );
