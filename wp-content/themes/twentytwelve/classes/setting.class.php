<?php


class setting
{
	public function create_setting($args) 
	{
		global $wpdb;

		$defaults = $wpdb->prefix . "defaults";

		
		$data = array(
			'no_of_days'   => $args['no_of_days'],
			'morning_from' => $args['morning_from'],
			'morning_to'   => $args['morning_to']

			);

		$data_value = json_encode((object) $args);
		$insert = $wpdb->replace( 
			$defaults,
			array( 
		        'id' => $args['settings_id'],
				'type' => 'settings', 
				'value' => $data_value 
			), 
			array( 
		        '%d',
				'%s', 
				'%s' 
			) 
		);
		if($insert != false && $insert != 0){

			return array('status' => 201 ,'response' => $insert);
		}
		else
		{
			return new WP_Error( 'json_setting_not_inserted', __( 'Xooma Settings not saved.' ), array( 'status' => 500 ) );

		}


	}

	public function get_settings(){

		global $wpdb;

		$defaults = $wpdb->prefix . "defaults";

		$setting_types = $wpdb->get_row( "SELECT * FROM $defaults where type='settings'" );

		$table = $wpdb->prefix . "product_main";


		$user = $wpdb->get_results("SELECT *,count(user_id) as users from $table where deleted_flag=0 group by user_id ");
       
       	$count = 0 ;
       	foreach ($user as $key => $value) {
       		$include = array($value->user_id);
			$blogusers = get_users(array('include'=>$include));
			
			
			if(count($blogusers)!= 0)
			{
				$count = intval($count) + 1;
			}
       	}

		if($setting_types){

			return array('status' => 200 ,'response' => $setting_types,'users'=>$count);


		}
		else
		{
			return new WP_Error( 'json_setting_not_found', __( 'Xooma Settings not found.' ), array( 'status' => 500 ) );

		}


	}

}



