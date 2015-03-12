<?php


function save_anytime_product_details($id,$data){

		//store default values for the users's product

		global $wpdb;

		global $user;

		$product_main_table = $wpdb->prefix . "product_main";

		$product_meta_table = $wpdb->prefix . "product_meta";

		$sql_query = $wpdb->get_row("SELECT * FROM $product_main_table WHERE user_id = ".$id." and product_id=".$data['id']." and deleted_flag=0");

		if((is_null($sql_query))){
		$main = $wpdb->insert(
								$product_main_table,
								array(
									'user_id'             => $id,
									'product_id'          => $data['id'],
									'deleted_flag'        => 0
								),
								array(
									'%d',
									'%d',
									'%d'
								)
							);
		$main_id = $wpdb->insert_id;

		//saving quantity per servings
		for($i=0;$i<$data['time_set'];$i++){
				$qty = explode('|', $data['serving_size']);
				$meta_id = $wpdb->insert(
								$product_meta_table,
								array(
									'main_id'                     => $main_id,
									'key'                         => 'qty_per_servings',
									'value'                       => serialize(array('qty' =>1,'when' => 1))
								),
								array(
									'%d',
									'%s',
									'%s'
								)
							);

		}

				//saving no of containers
				$meta_id = $wpdb->insert(
								$product_meta_table,
								array(
									'main_id'                     => $main_id,
									'key'                         => 'no_of_containers',
									'value'                       => serialize(array('no_of_container' => $data['serving_per_container'],
																														'reminder_flag'=>0,
																														'check' => 0))
								),
								array(
									'%d',
									'%s',
									'%s'
								)
							);



		if($main){

			//stroring trasaction to keeptrack of quantity
				$args = array(

						'user_id'     => $id,
						'product_id'  => $data['id'],
						'type'        => 'stock',
						'amount'      =>  $data['total'],
						'consumption_type'  => ''


					);


				store_stock_data($args);

				$args = array(

						'user_id'     => $id,
						'product_id'  => $data['id'],
						'type'        => 'consumption',
						'amount'      =>  0,
						'consumption_type'  => ''


					);
				store_stock_data($args);
			 //stroring trasaction to keeptrack of quantity

				//store schedule

				$schedule = array(
					'main_id'   => $main_id,
					'time_set'  => $data['time_set']

					);
				store_add_schedule($schedule);

			//store schedule

				$date = date('Y-m-d');
				$product = $user->get_user_home_products($id,$data['id'],$date);
				return $product['response'];
				
		}
		else{
				new WP_Error( 'json_user_product_details_not_added', __( 'User Product details not added.' ));
		}
	}
}




function update_anytime_product_details($id,$pid,$data,$homedate){

		global $wpdb;

		global $user;

		$product_main_table = $wpdb->prefix . "product_main";

		$product_meta_table = $wpdb->prefix . "product_meta";
		$sql_query = $wpdb->get_row("SELECT * FROM $product_main_table WHERE user_id = ".$id." and product_id=".$pid." and deleted_flag=0");

		if((is_null($sql_query))){

		$main = $wpdb->insert(
								$product_main_table,
								array(
									'user_id'             => $id,
									'product_id'          => $pid,
									'deleted_flag'        => 0
								),
								array(
									'%d',
									'%d',
									'%d'
								)
							);



		$main_id = $wpdb->insert_id;
		$quantity_arr = array();
		for($i=0;$i<$data['servings_per_day'];$i++){

				//saving quantity per servings
				$meta_id = $wpdb->insert(
								$product_meta_table,
								array(
									'main_id'                     => $main_id,
									'key'                         => 'qty_per_servings',
									'value'                       => serialize(array('qty' => $data['qty_per_servings'.$i],'when' =>1))
								),
								array(
									'%d',
									'%s',
									'%s'
								)
							);

				

						


				}

				for($i=0;$i<$data['reminders_length'];$i++){

					$today = date('Y-m-d');
					$time = date("H:i:s", strtotime($data['reminder_time'.$i]));
					$datee = date("$today $time ");
					
					$today_date = get_timezone_date($id,$datee);
					
					$meta_id = $wpdb->insert(
									$product_meta_table,
									array(
										'main_id'                     => $main_id,
										'key'                         => 'reminders',
										'value'                       => serialize(array('time' => $today_date))
									),
									array(
										'%d',
										'%s',
										'%s'
									)
								);

					 //reminders
					 store_reminders($main_id,$data['servings_per_day'],$data['reminder_time'.$i]);
					 
						}

						


			 

				

				$meta_id = $wpdb->insert(
								$product_meta_table,
								array(
									'main_id'                     => $main_id,
									'key'                         => 'no_of_containers',
									'value'                       => serialize(array('no_of_container' => $data['no_of_container'],
																														'reminder_flag'=>$data['reminder'],
																														'check' => $data['check']))
								),
								array(
									'%d',
									'%s',
									'%s'
								)
							);

				//stroring trasaction to keeptrack of quantity
				$args = array(

						'user_id'     => $id,
						'product_id'  => $pid,
						'type'        => 'stock',
						'amount'      =>  $data['available'],
						'consumption_type'  => ''


					);


				store_stock_data($args);

				$args_del = array(

						'user_id'     => $id,
						'product_id'  => $pid,
						'type'        => 'remove',
						'amount'      =>  $data['subtract'],
						'consumption_type'  => 'sales'


					);
				$args = array(

						'user_id'     => $id,
						'product_id'  => $pid,
						'type'        => 'consumption',
						'amount'      =>  0,
						'consumption_type'  => ''


					);
				store_stock_data($args);
			if($data['subtract'] !=0) 
			store_stock_data($args_del);
			 //stroring trasaction to keeptrack of quantity

				//store schedule

				$schedule = array(
					'main_id'   => $main_id,
					'time_set'  => $data['servings_per_day']

					);
				store_add_schedule($schedule);

			//store schedule
			 
			 




	}
	else
	{
		
		$query = $wpdb->query("DELETE from $product_meta_table where main_id=".$sql_query->id);


		$main_id = $sql_query->id;
		for($i=0;$i<$data['servings_per_day'];$i++){

				//saving quantity per servings
				$main = $wpdb->insert(
								$product_meta_table,
								array(
									'main_id'                     => $main_id,
									'key'                         => 'qty_per_servings',
									'value'                       => serialize(array('qty' => $data['qty_per_servings'.$i],'when' =>1))
								),
								array(
									'%d',
									'%s',
									'%s'
								)
							);

				

						


				}

				//store schedule

				$schedule = array(
					'main_id'   => $main_id,
					'time_set'  => $data['servings_per_day']

					);
				update_schedule($schedule);

			//store schedule

				for($i=0;$i<$data['reminders_length'];$i++){

						//savings reminders


					
					
					$today = date('Y-m-d');
					$time = date("H:i:s", strtotime($data['reminder_time'.$i]));
					$datee = date("$today $time ");

					$today_date = get_timezone_date($id,$datee);
					
					
					

					 $meta_id = $wpdb->insert(
									$product_meta_table,
									array(
										'main_id'                     => $main_id,
										'key'                         => 'reminders',
										'value'                       => serialize(array('time' => $today_date))
									),
									array(
										'%d',
										'%s',
										'%s'
									)
								);

					 //reminders
					 store_reminders($main_id,$data['servings_per_day'],$data['reminder_time'.$i]);
				}

				$meta_id = $wpdb->insert(
								$product_meta_table,
								array(
									'main_id'                     => $main_id,
									'key'                         => 'no_of_containers',
									'value'                       => serialize(array('no_of_container' => $data['no_of_container'],
																														'reminder_flag'=>$data['reminder'],
																														'check' => $data['check']))
								),
								array(
									'%d',
									'%s',
									'%s'
								)
							);


				//stroring trasaction to keeptrack of quantity
				 $args_del = array(

						'user_id'     => $id,
						'product_id'  => $pid,
						'type'        => 'remove',
						'amount'      =>  $data['subtract'],
						'consumption_type'  => 'sales'


					);
			if($data['subtract'] !=0) 
			store_stock_data($args_del);

		
	}


		if($main){

				$date = $homedate;
				$product = $user->get_user_home_products($id,$pid,$date);
				return $product['response'];

		}
		else{

				

				return new WP_Error( 'json_user_product_details_not_updated', __( 'User Product details not updated.' ));

		}


}



function update_schedule_product_details($id,$pid,$data,$homedate){

		global $wpdb;

		global $user;

		$product_main_table = $wpdb->prefix . "product_main";

		$product_meta_table = $wpdb->prefix . "product_meta";

		$sql_query = $wpdb->get_row("SELECT * FROM $product_main_table WHERE user_id = ".$id." and product_id=".$pid." and deleted_flag=0");
 
		if((is_null($sql_query))){

		$main = $wpdb->insert(
								$product_main_table,
								array(
									'user_id'             => $id,
									'product_id'          => $pid,
									'deleted_flag'        => 0
								),
								array(
									'%d',
									'%d',
									'%d'
								)
							);



		$main_id = $wpdb->insert_id;
		$quantity_arr = array();
		for($i=0;$i<$data['servings_per_day'];$i++){

				//saving quantity per servings
				$meta_id = $wpdb->insert(
								$product_meta_table,
								array(
									'main_id'                     => $main_id,
									'key'                         => 'qty_per_servings',
									'value'                       => serialize(array('qty' => $data['qty_per_servings'.$i],'when' =>$data['when'.$i]))
								),
								array(
									'%d',
									'%s',
									'%s'
								)
							);

				 
						


				}

				for($i=0;$i<$data['reminders_length'];$i++){

						//savings reminders
					$today = date('Y-m-d');
					$time = date("H:i:s", strtotime($data['reminder_time'.$i]));
					$datee = date("$today $time ");
					
					$today_date = get_timezone_date($id,$datee);

					$meta_id = $wpdb->insert(
									$product_meta_table,
									array(
										'main_id'                     => $main_id,
										'key'                         => 'reminders',
										'value'                       => serialize(array('time' => $today_date))
									),
									array(
										'%d',
										'%s',
										'%s'
									)
								);

					 //reminders
					 store_reminders($main_id,$data['servings_per_day'],$data['reminder_time'.$i]);
				}


				$meta_id = $wpdb->insert(
								$product_meta_table,
								array(
									'main_id'                     => $main_id,
									'key'                         => 'no_of_containers',
									'value'                       => serialize(array('no_of_container' => $data['no_of_container'],
																														'reminder_flag'=>$data['reminder'],
																														'check' => $data['check']))
								),
								array(
									'%d',
									'%s',
									'%s'
								)
							);

				//stroring trasaction to keeptrack of quantity
				$args = array(

						'user_id'     => $id,
						'product_id'  => $pid,
						'type'        => 'stock',
						'amount'      =>  $data['available'],
						'consumption_type'  => ''


					);


				store_stock_data($args);
				$args = array(

						'user_id'     => $id,
						'product_id'  => $pid,
						'type'        => 'consumption',
						'amount'      =>  0,
						'consumption_type'  => ''


					);
				store_stock_data($args);

				$args_del = array(

						'user_id'     => $id,
						'product_id'  => $pid,
						'type'        => 'remove',
						'amount'      =>  $data['subtract'],
						'consumption_type'  => 'sales'


					);
			if($data['subtract'] !=0) 
			store_stock_data($args_del);
			 //stroring trasaction to keeptrack of quantity

		//store schedule

				$schedule = array(
					'main_id'   => $main_id,
					'time_set'  => $data['servings_per_day']

					);
				store_add_schedule($schedule);

			//store schedule




	}
	else
	{
		$query = $wpdb->query("DELETE from $product_meta_table where main_id=".$sql_query->id);


		$main_id = $sql_query->id;
		for($i=0;$i<$data['servings_per_day'];$i++){

				//saving quantity per servings
				$main = $wpdb->insert(
								$product_meta_table,
								array(
									'main_id'                     => $main_id,
									'key'                         => 'qty_per_servings',
									'value'                       => serialize(array('qty' => $data['qty_per_servings'.$i],'when' =>$data['when'.$i]))
								),
								array(
									'%d',
									'%s',
									'%s'
								)
							);

				
						


				}

				//store schedule

				$schedule = array(
					'main_id'   => $main_id,
					'time_set'  => $data['servings_per_day']

					);
				update_schedule($schedule);

			//store schedule

				for($i=0;$i<$data['reminders_length'];$i++){

						//savings reminders
					$today = date('Y-m-d');
					$time = date("H:i:s", strtotime($data['reminder_time'.$i]));
					$datee = date("$today $time ");
					
					$today_date = get_timezone_date($id,$datee);

					 $meta_id = $wpdb->insert(
									$product_meta_table,
									array(
										'main_id'                     => $main_id,
										'key'                         => 'reminders',
										'value'                       => serialize(array('time' => $today_date))
									),
									array(
										'%d',
										'%s',
										'%s'
									)
								);

					 //reminders
					 store_reminders($main_id,$data['servings_per_day'],$data['reminder_time'.$i]);
				}

				$meta_id = $wpdb->insert(
								$product_meta_table,
								array(
									'main_id'                     => $main_id,
									'key'                         => 'no_of_containers',
									'value'                       => serialize(array('no_of_container' => $data['no_of_container'],
																														'reminder_flag'=>$data['reminder'],
																														'check' => $data['check']))
								),
								array(
									'%d',
									'%s',
									'%s'
								)
							);

				//stroring trasaction to keeptrack of quantity
				 $args_del = array(

						'user_id'     => $id,
						'product_id'  => $pid,
						'type'        => 'remove',
						'amount'      =>  $data['subtract'],
						'consumption_type'  => 'sales'


					);
			if($data['subtract'] !=0) 
			store_stock_data($args_del);

		 
			 
	}


		if($main){
				$date = $homedate;
				$product = $user->get_user_home_products($id,$pid,$date);
				return $product['response'];

		}
		else{

				

				return new WP_Error( 'json_user_product_details_not_updated', __( 'User Product details not updated.' ));

		}


}



function send_notifications_to_admin($user_id){


	global $aj_comm;

	$args = array(
		'component'             => 'xooma_users',
		'communication_type'    => 'xooma_admin_email',
		'user_id'               => $user_id

		);
	// user data
	$user = login_response($user_id);
	
	$meta = array(
		'username'        => $user['display_name'],
		'email'           => $user['user_email'],
		'xoomaid'         => get_user_meta($user_id,'xooma_member_id',true),
		'registered'      => date('Y-m-d' ,strtotime($user['user_registered'])),
		'siteurl'         => site_url().'/wp-admin',
		'loginurl'		  => site_url().'/xooma-app/#login',
		'img'			  => get_template_directory_uri().'/xoomaapp/images/logo.png'


		);

	//get all the admins
	$arguments = array(
				'role' => 'Administrator',
				'orderby' => 'ID',
				'order' => 'ASC',
				'offset' => 0,
				'number' => 0
		);
	$admins = get_users($arguments);

	foreach ((array) $admins as $value) {

		$recipients_args = array(
							array(
							'user_id'     => $value->ID,
							'type'        => 'email',
							'value'       => $value->user_email

						)

			);

		$aj_comm->create_communication($args,$meta,$recipients_args);

		}
		




	return true;


}


function send_notifications_to_user($user_id){


	global $aj_comm;

	$args = array(
		'component'             => 'xooma_users',
		'communication_type'    => 'xooma_user_email',
		'user_id'               => $user_id

		);
	// user data
	$user = login_response($user_id);

	$meta = array(
		'username'        => $user['display_name'],
		'email'           => $user['user_email'],
		'xoomaid'         => get_user_meta($user_id,'xooma_member_id',true),
		'registered'      => date('Y-m-d' ,strtotime($user['user_registered'])),
		'siteurl'         => site_url().'/xooma-app/#profile/personal-info',
		'loginurl'		  => site_url().'/xooma-app/#login',
		'img'			  => get_template_directory_uri().'/xoomaapp/images/logo.png'


		);

	$recipients_args = array(
												array(
													'user_id'     => $user_id,
													'type'        => 'email',
													'value'       =>  $user['user_email']

												)

										);

	$aj_comm->create_communication($args,$meta,$recipients_args);

	


	return true;


}

function get_all_timezones(){

		$country_id = get_category_by_slug('country');
		$term = get_categories('parent='.$country_id->term_id.'&hide_empty=0');
		foreach ($term as $term_data) {

			$country_code = geoip_country_code_by_name($term_data->name);

			$temp_arr = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY,$country_code );



		}
}


add_filter( 'aj_user_model', 'check_workflow' );

add_action( 'user_register', 'send_emails', 10, 1 );

function send_emails($user_id){

	$user_notis = update_user_meta($user_id,'notification',1);
	$user_emails = update_user_meta($user_id,'emails',0);
		
	send_notifications_to_admin($user_id);
	send_notifications_to_user($user_id);
	
}
function check_workflow($user_model){




	//workflow plugin code
		global $aj_workflow;
		$user = new User();
		$args = array(
				'name'    => 'login',

		);
		$status = array(
				'default'   => 'incomplete',
				'complete'  => 'complete'


			);
		$aj_workflow->workflow_insert_main($args,$status);

		//call workflow function

		$state = $aj_workflow->workflow_needed($user_model->ID);

		//call workflow function
		//workflow plugin code
		$products = get_user_products($user_model->ID);

		$user_data = $user->get_user_details($user_model->ID);

		$user_model->state = $state;

		$user_model->products = $products;

		
		$t = "";
		$timezone  = "America/New_York";
		if($user_data['timezone']!="" && $user_data['timezone']!=null)
        {
			$dateTimeZoneTaipei = new DateTimeZone($user_data['timezone']);
			$dateTimeTaipei = new DateTime("now", $dateTimeZoneTaipei);
			$timeOffset = $dateTimeZoneTaipei->getOffset($dateTimeTaipei)/ 3600;
			$t =  $dateTimeTaipei->format('P');
			$timezone  = $user_data['timezone'];
			

		}
		else
		{
			$dateTimeZoneTaipei = new DateTimeZone($timezone);
			$dateTimeTaipei = new DateTime("now", $dateTimeZoneTaipei);
			$timeOffset = $dateTimeZoneTaipei->getOffset($dateTimeTaipei)/ 3600;
			$t =  $dateTimeTaipei->format('P');
			
		}
 
		

  		$user_model->timezone = $timezone;


		$user_model->offset = $t;

		$user_model->notification = get_user_meta($user_model->ID,'notification',true);

		$user_model->emails = get_user_meta($user_model->ID,'emails',true);

		





		return $user_model;
}

function get_user_products($id){

		global $wpdb;

		$product_main_table = $wpdb->prefix . "product_main";

		$results = $wpdb->get_results("SELECT * FROM $product_main_table WHERE user_id = ".$id." and deleted_flag=0");

		$product_arr = array();
		foreach ($results as $key => $value) {


			array_push($product_arr, intval($value->product_id));
		}

		return $product_arr;
}

function login_response($user_id){

		
		$user = array();
		$user_info = get_userdata($user_id);

		
		

		
		$user['status'] = 'true';
		$user['id'] = $user_id;
		$user['user_login'] = $user_info->data->user_login;
		$user['user_email'] = $user_info->data->user_email;
		$user['display_name'] = $user_info->data->display_name;
		$user['user_registered'] = $user_info->data->user_registered;

		return  $user;
}


function get_occurrence_date($product_id,$user_id,$date){

	if($user_id ==""){
		$user_id = get_current_user_id();
	}
	
	//get object id
	$object_id = get_object_id($product_id,$user_id);

		if(!is_wp_error($object_id)){

			//get schedule id
			$schedule = \ajency\ScheduleReminder\Schedule::get_schedule_id('user_product', $object_id);

			if($date=="")
			{
				$start_datetime = date('Y-m-d 00:00:00');
				$end_datetime = date('Y-m-d 23:59:59');
				// $end_datetime = date('Y-m-d H:i:s',strtotime($enddatetime . "+1 days"));
			}
			else
			{


		
				$start_datetime = date("Y-m-d 00:00:00", strtotime($date));
				$end_datetime = date('Y-m-d 23:59:59', strtotime($date));
				// $end_datetime = date('Y-m-d H:i:s',strtotime($enddatetime . "+1 days"));
			}
			
			$occurrences = \ajency\ScheduleReminder\Occurrence::
			get_occurrences($schedule, $start_datetime, $end_datetime); 
			
			// $occurrences = arsort($occurrences);

			return $occurrences;

		
	}

}


function get_object_id($product_id,$user_id){

	global $wpdb;

	$product_main_table = $wpdb->prefix . "product_main";
	$object = $wpdb->get_row("SELECT * FROM $product_main_table WHERE user_id = ".$user_id." 
		and product_id=".$product_id." and deleted_flag=0");

	if(!(is_null($object)))
	{

		return $object->id;

	}
	else
	{
		return new WP_Error( 'object_id_not_found', __( 'Object ID not found.' ));
	}

	

}

function update_status($id){

			global $aj_workflow;
			$response = $aj_workflow->workflow_update_user($id,'UserProductList');

			if (is_wp_error($response)){

				return new WP_Error( 'status_not_updated', __( 'Status not updated.' ));

			}
			else
			{
				return true;
			}
}

function store_reminders($main_id,$servings,$reminder){

					global $wpdb;

					$table = $wpdb->prefix . "product_main";

					$user = $wpdb->get_row("SELECT * from $table where id=".$main_id);


					$today = date("H:i:s", strtotime($reminder));
					$start = date("Y-m-d $today ");
						
					$today_date = get_timezone_date($user->user_id,$start);

					$interval = 24;
					$schedule_data = array(
								'object_type' => 'user_product_reminder',
								'object_id' => $main_id,
								'start_dt'  => $today_date,
								'rrule' => "FREQ=HOURLY;INTERVAL=".$interval.";WKST=MO"
						);
						
						$id = \ajency\ScheduleReminder\Schedule::add($schedule_data);

						$schedule = \ajency\ScheduleReminder\Schedule::get($id);


						$scheduleobj = (object)$schedule;

						$table_name = "{$wpdb->prefix}aj_schedules";

						$wpdb->update($table_name, 
									  array( 'next_occurrence' => $today_date ),
									  array( 'id' => $scheduleobj->id ));

						// $update_next = \ajency\ScheduleReminder\Schedule::update_next_occurrence($scheduleobj);

		return  $id;
					 

}

function add_asperbmi_products($user_id,$weight){

	//add asperbmi products

				$productList = new ProductList();

				global $wpdb;

				global $aj_workflow;

				$product_main_table = $wpdb->prefix . "product_main";
				
				$state = $aj_workflow->workflow_needed($user_id);

			

				$all_terms = $productList->get_products($term_id="");


				foreach ($all_terms as $key => $value) {

				 

					$object = $wpdb->get_row("SELECT * FROM $product_main_table WHERE user_id = ".$user_id." 
					and product_id=".$value['id']." and deleted_flag=0");

					if($state != '/home' && is_null($object)) 
					{
						$actual = 1 ;
					$time_set = $value['time_set'];
						if( $time_set == 'asperbmi' ){
							 
										$bmi = $value['bmi'];
										
										foreach ($bmi as $key => $val) {
											
											$original = explode('<', $val['range']);

											

											if(intval($original[0]) <= intval($weight) && intval($weight) <= intval($original[1]) )
												$actual = $val['quantity'];

										}
										$value['time_set'] = $actual;
										
										save_anytime_product_details($user_id,$value);

						}
					}

				}


}

function store_stock_data($args){

	global $wpdb;

 	$object_id = get_object_id($args['product_id'],$args['user_id']);

	$transactions = $wpdb->prefix . "transactions";

	$main = $wpdb->insert(
								$transactions,
								array(
									'object_id'                        => $object_id,
									'type'                             => $args['type'],
									'amount'                           => $args['amount'],
									'consumption_type'                 => $args['consumption_type'],
									'datetime'                            => date('y-m-d H:i:s')
								),
								array(
									'%d',
									'%s',
									'%d',
									'%s',
									'%s'
								)
							);

		if($main){
			return true;
		}
		else
		{
			return new WP_Error( 'stock_not_updated', __( 'Stock not updated.' ));
		}

}

function store_add_schedule($args){



			global $wpdb;

					$table = $wpdb->prefix . "product_main";

					$user = $wpdb->get_row("SELECT * from $table where id=".$args['main_id']);


					$today = strtotime('00:00:00');
					$start = date("Y-m-d 00:00:00");
						
					$today_date = get_timezone_date($user->user_id,$start);


				
						$interval = 24/intval($args['time_set']);
						
						$schedule_data = array(
								'object_type' => 'user_product',
								'object_id' => $args['main_id'],
								'start_dt'  => $today_date,
								'rrule' => "FREQ=HOURLY;INTERVAL=".$interval.";WKST=MO"
						);
				
				$id = \ajency\ScheduleReminder\Schedule::add($schedule_data);

				$schedule = \ajency\ScheduleReminder\Schedule::get($id);
				
				$scheduleobj = (object)$schedule;
				$update_next = \ajency\ScheduleReminder\Schedule::update_next_occurrence($scheduleobj);

	return $id;

				

}
function update_schedule($args){

	$main_id = $args['main_id'];
	global $wpdb;

	$table = $wpdb->prefix . "product_main";

	$user = $wpdb->get_row("SELECT * from $table where id=".$args['main_id']);


	$today = strtotime('00:00:00');
	$start = date("Y-m-d 00:00:00");
		
	$today_date = get_timezone_date($user->user_id,$start);


				
	$interval = 24/intval($args['time_set']);

	$rrule = "FREQ=HOURLY;INTERVAL=".$interval.";WKST=MO";
						
	$schedules = $wpdb->prefix . "aj_schedules";

	$occurrence_meta = $wpdb->prefix . "aj_occurrence_meta";
				
				
				
	//echo "UPDATE $schedules SET rrule='".$rrule."' and start_dt='".$today_date."' where object_id=".$main_id." and object_type='user_product'";
	
	
	
	$sqlquery = $wpdb->get_row("SELECT * from $schedules where object_id=".$main_id." and object_type='user_product'");

	//$query = $wpdb->query("UPDATE $schedules SET rrule='".$rrule."' and start_dt='".$today_date."' where object_id=".$main_id." and object_type='user_product'");

	$wpdb->update($schedules, 
					  array( 'rrule' => "FREQ=HOURLY;INTERVAL=".$interval.";WKST=MO",
					  		 'start_dt'=> $today_date,
					   ),
					  array( 'id' => $sqlquery->id ));
	// if( $sqlquery)
	$query = $wpdb->query("DELETE from $schedules where object_id=".$main_id." and object_type='user_product_reminder'");

	$schedule = \ajency\ScheduleReminder\Schedule::get($sqlquery->id);
				
	$scheduleobj = (object)$schedule;
	$update_next = \ajency\ScheduleReminder\Schedule::update_next_occurrence($scheduleobj);



	return $main_id;

}
function get_stock_count_user($id,$product_id){

		global $wpdb;

		$transactions = $wpdb->prefix . "transactions";

		$object_id = get_object_id($product_id,$id);
		
		$stock = $wpdb->get_row("SELECT sum(amount) as stock from  $transactions where object_id=".$object_id
			."  and type='stock'");



	 
		$del = $wpdb->get_row("SELECT sum(amount) as del from  $transactions where object_id=".$object_id
			." and type='remove'");

		$conume = $wpdb->get_row("SELECT sum(amount) as conume from  $transactions where object_id=".$object_id
			." and type='consumption'");



		$amt = $stock->stock == null ? 0 : $stock->stock;
		$remove = $del->del == null ? 0 : $del->del;
		$conume = $conume->conume == null ? 0 : $conume->conume;
		$stock_count  = intval($amt) - intval($remove) - intval($conume);

		return $stock_count;

}

function get_history_user_product($id,$product_id){

		global $wpdb;

		$transactions = $wpdb->prefix . "transactions";


		$table_name = $wpdb->prefix ."aj_occurrence_meta";


		$object_id = get_object_id($product_id,$id);

		global $productList;
		$term = $productList->get_products($product_id);
		$results = $wpdb->get_results("SELECT *,DATE(datetime) as datefield from $transactions
				where object_id=".$object_id."");

			$transaction_dates= array();
			$transaction= array();
			foreach ($results as $key => $value) {
			 			
			 			array_push($transaction_dates, $value->datefield);

			}

			$schedule = \ajency\ScheduleReminder\Schedule::get_schedule_id('user_product', $object_id);

			$occurrences = $wpdb->get_results("SELECT *,DATE(occurrence) as datefield from $table_name where schedule_id=".$schedule);

			foreach ($occurrences as $key => $value) {
			 	array_push($transaction_dates, $value->datefield);
			 } 

			 $transaction_data = array_unique($transaction_dates);
			 arsort($transaction_data);
			 $i = 0 ;
			 
			 foreach ($transaction_data as $value) {

			 	$stock = $wpdb->get_row("SELECT sum(amount) as stock from $transactions
							where object_id=".$object_id." and type='stock'  and DATE(`datetime`)='".$value."'");
				

			 	$sales = $wpdb->get_row("SELECT sum(amount) as sales from $transactions
							where object_id=".$object_id." and type='remove' and consumption_type='sales' and DATE(`datetime`)='".$value."'");
				$sql =  $wpdb->get_results("SELECT *,DATE(occurrence) as datefield from $table_name where DATE(occurrence)='".$value."' and schedule_id=".$schedule);
				
				$qty = 0;
				foreach ($sql as $key => $val) {


						$data = maybe_unserialize($val->meta_value);
						

						
						if(!isset($data[0]))
						{
							$qty = floatval($qty) + floatval($data['qty']);
						}
						else
						{
							foreach ($data as $key => $key_value) {

							
							
							if(isset($key_value[$key]))
							{
								
								foreach ($key_value as $key => $val1) {

									if(isset($val1[$key]))
									{
										foreach ($val1 as $key => $val2) {
											$qty = floatval($qty) + floatval($val2['qty']);
										}
									}
									else
									{
										
										$qty = floatval($qty) + floatval($val1['qty']);
									}
								}
							}
							else
							{
								
								if(is_array($key_value))
								{

									$qty = floatval($qty) + floatval($key_value['qty']);
								}
								else
								{
									$res = maybe_unserialize($val->meta_value);
									
									$qty = floatval($qty) + floatval($res['qty']);
								}
								
							}
						}
						}
						
							
						
			
					

					

					

					


				}

				$i++;
			 	$sales_data = $sales->sales == null ? 0 : $sales->sales;
			 	$stock_data = $stock->stock == null ? 0 : $stock->stock;
				$transaction[] = array(
							'id'			=> $i,
							'date'          =>  $value, 
							'stock'         =>  $stock_data,
							'sales'         =>  $sales_data,
							'consumption'   => $qty,
							'product_type'	=> $term[0]['product_type_name']


							);		 
			 }

			 
	 return array('ID'=>$term[0]['id'], 'response' =>$transaction);

}

function get_consumption_details($id,$pid,$date)
{

				global $wpdb;

				$user = new User();

				$product_meta_table = $wpdb->prefix . "product_meta";

				$product_main_table = $wpdb->prefix . "product_main";


				$response = $user->get_user_product_details($id,$pid);



				$occurrences = get_occurrence_date($pid,$id,$date);

				$response['occurrences']  = $occurrences;

				$response['date'] = $date ; 

				return $response;

				
}

function store_consumption_details($args){

		$object_id = get_object_id($args['pid'],$args['id']);

		if(!is_wp_error($object_id)){

			//get schedule id
			$schedule = \ajency\ScheduleReminder\Schedule::get_schedule_id('user_product', $object_id);

		}
		$id = $args['id'];

		$today = $args['date'];
		$time = date("H:i:s", strtotime($args['time']));
        $start = date("$today $time");
		
						
		$today_date = get_timezone_date($id,$start);

		
	
		
		$occurrence_data = array(
						'schedule_id' =>  $schedule,
						'occurrence' => $start,
						'meta_value' => $args['meta_value'],
						'meta_id'     => $args['meta_id']
					);

				if($args['meta_id'] == 0)
				{
					$occurrences = \ajency\ScheduleReminder\Occurrence::
					_insert_occurrence($occurrence_data); 

					update_consumption($object_id,$args['qty']);

					$meta_id = $occurrences;
				}
				else
				{

					//for x2o , getting the quantity///
					$occ = \ajency\ScheduleReminder\Occurrence::get($args['meta_id']);

					$arr = [];
					$object = (object)$occ['meta_value'];
				 
					$total = count((array)$object);

					if($total == 2)
					{
							$arr[] = $occ['meta_value'];
					}
					else
					{
							foreach ($object  as $value) {
									
									 $arr[] = array(
										'date'    => $value['date'],
										'qty'     => $value['qty']
										); 
							}

					}

					$arr[] = $args['meta_value'];

					
					$occurrence_data['meta_value'] = $arr;

					//for x2o , getting the quantity///
					$occurrences = \ajency\ScheduleReminder\Occurrence::
					_update_occurrence($occurrence_data);

					update_consumption($object_id,$args['qty']);
					$meta_id = $args['meta_id'];
				}

				$user = new USer();
				$product = $user->get_user_home_products($args['id'],$args['pid'],$args['date']);

				$scheduledata = \ajency\ScheduleReminder\Schedule::get($schedule);


				$scheduleobj = (object)$scheduledata;

				$update_next = \ajency\ScheduleReminder\Schedule::update_next_occurrence($scheduleobj);

				return array('occurrence'=> $product['response'], 'meta_id'=>$meta_id);




}

function generate_dates($start_dt,$end_dt,$user_id,$parameter){



$start = microtime(true);
		global $wpdb;

		$table = $wpdb->prefix . "measurements";

		$graph_arr = array();

		$temp_arr = array();

		$start_datetime = date("Y-m-d 00:00:00", strtotime($start_dt));
		$end_datetime = date("Y-m-d 23:59:59", strtotime($end_dt));
		$begin = new DateTime($start_datetime);
		$end = new DateTime($end_datetime);
		

		$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);


		
		foreach($daterange as $date){

			$date = $date->format('Y-m-d');
		   	$graph_arr[] = array(
									'date'		=> $date,
									'weight'	=> ''

							);
		}

		if(count($graph_arr)==1)
		{
			$graph_arr[] = array(
									'date'		=> date('Y-m-d'),
									'weight'	=> ''

							);
		}		
		$sqlquery = $wpdb->get_results("SELECT * , DATE(`date`) as datefield from $table where `date` BETWEEN 
			'".$start_dt."' and '".$end_dt."' and user_id=".$user_id);

		//get previous record 
		$pre_date = get_previous_record($start_dt,$user_id,$parameter);
		
		//get previous record 

		//get next record
		$next_date = get_next_record($end_dt,$user_id,$parameter);
		
		//get next record
		

		foreach ($graph_arr as $key => $value) {
			
				foreach ($sqlquery as $key1 => $val) {
					
						if($val->datefield == $value['date'] )
						{
							
							$measurements_data = maybe_unserialize($val->value);

							$graph_arr[$key]['weight'] =  $measurements_data[$parameter];
									
					
						}
						
				}
		}


		$response = generate_graph($graph_arr,$pre_date,$next_date);

		$end = microtime(true);

		$sec = ($end-$start)*1000;
		return $response;


}

function get_previous_record($start_dt,$user_id,$parameter){

			global $wpdb;

			$table = $wpdb->prefix . "measurements";

		  $previous_ro = $wpdb->get_row("SELECT * from $table where `date`='".$start_dt."' and user_id=".$user_id);
			$pre_date = array('previous_date' => $start_dt , 'param' => 0 ) ; 
			
			if(!(is_null($previous_ro)))
			{

				$previous_data = maybe_unserialize($previous_ro->value);
				$pre_date = array('previous_date' => $start_dt , 'param' => $previous_data[$parameter] ) ; 
			
				$previous = $wpdb->get_row("SELECT *, DATE(`date`) as datefield from $table where user_id=".$user_id." and  id < $previous_ro->id LIMIT 1 ");
				
				if(is_null($previous))
				{
					$previousdata = '';
					$pre_date = array('previous_date' => $start_dt , 'param' => $previousdata) ;
				}
					 

				else
				{
					$previous_data = maybe_unserialize($previous->value);

					$previousdata = $previous_data[$parameter];
					$pre_date = array('previous_date' => $pre_date , 'param' => $previousdata ) ; 
				}
					

				
			
			}
	return $pre_date;

}

function get_next_record($end_dt,$user_id,$parameter){

				global $wpdb;

			  $table = $wpdb->prefix . "measurements";

				$next_ro = $wpdb->get_row("SELECT * from $table where `date`='".$end_dt."' and user_id=".$user_id);
				$next_date = array('next_date' => $end_dt , 'param' => 0) ; 
				if(!(is_null($next_ro)))
				{

					$next_data = maybe_unserialize($next_ro->value);
					$next_date = array('next_date' => $end_dt , 'param' => $next_data[$parameter] ) ; 
					$next = $wpdb->get_row("SELECT *, DATE(`date`) as datefield from $table where user_id=".$user_id." and id > $next_ro->id LIMIT 1 ");
					if(is_null($next))
					{
						$nextdata = '';
						$next_date = array('next_date' => $end_dt , 'param' => $nextdata) ; 
					}
						
					else
					{
						$next_data = maybe_unserialize($next->value);
						$nextdata = $next_data[$parameter];
						$next_date = array('next_date' => $next->datefield , 'param' => $nextdata ) ; 
					}
						

					

					
				}
		return $next_date;

}

function generate_graph($graph,$pre_date,$next_date)
{
		$count = 0;
		$record = 0;
		$track = array();
		
		
		foreach ($graph as $key => $value) {
				$count = intval($count) + 1;	
				if( $value['weight'] == "" && $count == 1 && $pre_date['param'] != "")
				{
						$value['weight']	= $pre_date['param'];
				}
				else if($value['weight'] != "" )
				{
						array_push($track, $key);
						$cnt = count($track) ;
						$total = intval($value['weight']) + intval($record) ;
						$divide = $total/ $cnt;
						array_pop($track);
						$minus = $total ; 
						for ($i = count($track) - 1 ; $i >= 0 ; $i--) { 
								$minus = intval($minus) - intval($divide);
								$graph[$track[$i]]['weight'] = $minus;
						}
						$record = $value['weight'];
						$track = array();
				} 
				else if($value['weight'] == "" && $count == count($graph) && $next_date['param']!="")	
				{
						array_push($track, $key);
						
						$cnt = count($track) ;
						$total = intval($next_date['param']) + intval($record) ;
						$divide = $total/ $cnt;
						$divide = round($divide, 2);
						$minus = $total ; 
						for ($i= 0   ; $i <= count($track) - 1 ; $i++) { 
								$minus = intval($minus) - intval($divide);
								$graph[$track[$i]]['weight'] = $minus;
						}
						$record = $value['weight'];
						
				}
				else if($value['weight'] == "" && $count == count($graph) && $next_date['param']=="")	
				{
						array_push($track, $key);
						
						$cnt = count($track) ;
						$total = intval($record) ;
						$divide = $total/ $cnt;
						$divide = round($divide, 2);
						$minus = $total ; 
						for ($i= 0   ; $i <= count($track) - 1 ; $i++) { 
								$minus = intval($minus) - intval($divide);
								$graph[$track[$i]]['weight'] = $total;
						}
						$record = $value['weight'];
						
				}
				else
				{
							array_push($track, $key);
							continue;

				}
					
		
	
		}
		
		$dates = array();
		$param = array();
		
		foreach ($graph as $key => $value) {
				if($value['weight'] != ""){

					array_push($param, $value['weight']);
					array_push($dates, $value['date']);
					//unset($graph[$key]);
				}
		}

		
		return array('dates'=>$dates,'param'=>$param);
}

function get_user_measurement_date($id){

	global $wpdb;
    $measurements_table = $wpdb->prefix . "measurements";

   $sql_query = $wpdb->get_row( "SELECT * FROM $measurements_table where user_id=".$id." order by DATE(`date`) ASC LIMIT 1" );

   if(!is_string($sql_query))
   	return $sql_query->date;
  else
  	return false;
}

function generate_bmi($start_date,$end_date,$id,$param){

	global $wpdb;

    $measurements_table = $wpdb->prefix . "measurements";

    $sql_query = $wpdb->get_row( "SELECT * FROM $measurements_table where user_id=".$id." order by DATE(`date`) ASC LIMIT 1" );

    if(!is_null($sql_query)){

    	$start_date = $sql_query->date;

    	$start_data = maybe_unserialize($sql_query->value);


    }
    
    $sqlquery = $wpdb->get_row( "SELECT * FROM $measurements_table where user_id=".$id." order by DATE(`date`) DESC LIMIT 1" );

    if(!is_null($sql_query)){

    	$end_date = $sqlquery->date;

    	$end_data = maybe_unserialize($sqlquery->value);

    }
    else
    {
    	$end_date = date('Y-m-d');
    	$end_data = maybe_unserialize($sql_query->value);

    }
    

    return array('st_weight'    => $start_data['weight'] , 
    				'st_height' => $start_data['height'],
    				'et_weight' => $end_data['weight'],
    				'et_height' => $end_data['height'],
    				'st_date'   => $start_date,
    				'et_date'   => $end_date);

}

function update_consumption($object_id,$qty){

	global $wpdb;

 	$transactions = $wpdb->prefix . "transactions";

 	$qty = intval($qty);

 	$sql = $wpdb->query("UPDATE $transactions SET amount= amount + ".$qty." where 
 		object_id=".$object_id." and type='consumption'");

}

function store_notification($id,$notification)
{
	$user_details = update_user_meta($id,'notification',$notification);

	if($user_details)
	{
		return array('notification'=>$notification);
	}
	else
	{
		return new WP_Error( 'json_notification_not_updated', __( 'Notification not updated.' ));
	}

}

function store_emails($id,$emails)
{
	$user_details = update_user_meta($id,'emails',$emails);

	if($user_details)
	{
		return array('emails'=>$emails);
	}
	else
	{
		return new WP_Error( 'json_emails_not_updated', __( 'Email not updated.' ));
	}

}


function cron_job_reminders()
{

	global $wpdb;
	$table = $wpdb->prefix . "product_main";

	$object_type = 'user_product_reminder';

	$last_cron = get_option( 'last_cron_job', strtotime(date('Y-m-d H:i:s') ));

	$results = $wpdb->get_results("SELECT * from $table where deleted_flag=0");

	






	
	
	

	foreach ($results as $key => $val) {

	$include = array($val->user_id);
	$blogusers = get_users(array('include'=>$include));
	
	
	if(count($blogusers)!= 0)
		{

	
			$start_dt = date('Y-m-d H:i:s', $last_cron);

			$current_date = strtotime($start_dt);

			$nextdate = date("Y-m-d H:i:s", strtotime('+30 minutes', $current_date));

			$end_date = date('Y-m-d H:i:s',strtotime($nextdate));

			$occurrences = \ajency\ScheduleReminder\Occurrence::
							get_upcoming_occurrences($object_type,$end_date,$start_dt,$val->id);


	
			if(count($occurrences) == 0){


	




		

				$occurrences = \ajency\ScheduleReminder\Occurrence::
					get_upcoming_occurrences($object_type,$end_date,$start_dt,$val->id);

				$table_name = "{$wpdb->prefix}aj_schedules";


				$query = $wpdb->prepare("SELECT id FROM $table_name WHERE object_type=%s AND object_id=%d",'user_product_reminder', $val->id);

				$schedule = (array)$wpdb->get_results($query);
				
				if(!is_wp_error($schedule))

				{
					foreach ($schedule as $key => $value) {
						# code...
				
						$schedule = \ajency\ScheduleReminder\Schedule::get($value->id);
						$scheduleobj = (object)$schedule;
						
						$update_next = \ajency\ScheduleReminder\Schedule::update_next_occurrence($scheduleobj);
						

					}
				}


			}
	
			$usersToBeNotified = array();
	
			foreach ($occurrences as $key => $value) {

				$next_occurrence = strtotime($value->next_occurrence);


				
				if($next_occurrence < $current_date)
				{
					update_occurrence($value);
				}
				if( $next_occurrence > $current_date)
				{
					
					$user = $wpdb->get_row("SELECT * from $table where id=".$value->object_id);

					$include = array($user->user_id);
					$blogusers = get_users(array('include'=>$include));
		
		
					if(count($blogusers)!= 0)
					{
						$stock = get_stock_count_user($user->user_id,$user->product_id);
						$ProductList = new ProductList();
						$product = $ProductList->get_products($user->product_id);
						$user_details = get_user_meta($user->user_id,'user_details',true);
						$details = maybe_unserialize($user_details);
						$userdata  = get_userdata( $user->user_id );
						$name = $userdata->display_name;
						$d = date("Y-m-d H:i:s", strtotime($value->next_occurrence));




						
					
						$utc = new Carbon\Carbon($d);
						$warsaw = $utc->timezone($details['timezone']);


				$utc = new Carbon\Carbon($d);
				$warsaw = $utc->timezone($details['timezone']);

      
        		$today_date = $warsaw->format("Y-m-d H:i:s");
        		$time = date('h:i A',strtotime($today_date));

				$product_name = $product[0]['name'];
				$msg = send_message($user->user_id,$user->product_id,'reminder',$next_occurrence);
				trim($msg, "'");
				eval("\$msg = \"$msg\";");

							
		        		$today_date = $warsaw->format("Y-m-d H:i:s");
		        		$time = date('h:i A',strtotime($today_date));

						$product_name = $product[0]['name'];
						$msg = send_message($user->user_id,$user->product_id,'reminder',$next_occurrence);
						trim($msg, "'");
						eval("\$msg = \"$msg\";");


						$notifications_flag = get_user_meta($user->user_id,'notification' , true);
						//build push array 
						if (intval($stock) != 0 && $notifications_flag == 1)
						{
							$usersToBeNotified[] = array(

									'ID' 			=> $user->user_id,
									'message' 		=> $msg,
									'product' 		=> $product[0]['name'],
									'product_id'	=> $user->product_id,
									'type'			=> 'consume'
								);

						}
				
			}
		

	}

	
	
		
		
	$result = Parse\ParseCloud::run('sendPushByUserId', ['usersToBeNotified' => $usersToBeNotified] );
}
}

}

	
	update_option('last_cron_job' , strtotime(date('Y-m-d H:i:s')));

}


function update_occurrence($schedule){


		$update_next = \ajency\ScheduleReminder\Schedule::update_next_occurrence($schedule);

 }
 	
	

function send_message($user_id,$product_id,$type,$time=0)
{

	


	$path = get_path($type);

	$file = file($path);

	
	$temp = "";

	$msg = "";

	foreach ($file as $key => $value) {

		$arr = array();
		
		$temp = explode('=>', $value);


		array_push($arr, intval($temp[0]));
		array_push($arr, $temp[1]);

		

		if(in_array(intval($product_id), $arr))
		{
			
			$msg = $arr[1];
			break;
		}

		

		
		
	}

	$msg;
	
	return $msg;
	
	
}

function get_path($type){

		$path = "";

		switch($type){

		case 'reminder':
		$path = get_template_directory_uri().'/xoomaapp/json/php/reminder.txt';
		break;

		case 'stock_low':
		$path = get_template_directory_uri().'/xoomaapp/json/php/stock_low.txt';
		break;

		case 'stock_over':
		$path = get_template_directory_uri().'/xoomaapp/json/php/stock_over.txt';
		break;

		case 'add_product':
		$path = get_template_directory_uri().'/xoomaapp/json/php/add_product.txt';
		break;

	}

	return $path;

}

function send_stock_reminders_over(){

	global $wpdb;

	global $user;

	$usersToBeNotified = array();

	$productList = new ProductList();
	
	$table = $wpdb->prefix . "product_main";

	$defaults = $wpdb->prefix . "defaults";

	$results = $wpdb->get_results("SELECT * from $table where deleted_flag=0");

	$settings = $wpdb->get_row("SELECT * from $defaults where type='settings'");

	
	
	
	


	foreach ($results as $key => $value) {
		//available count of the user//
		$available = get_stock_count_user($value->user_id,$value->product_id);
		$include = array($value->user_id);
		$blogusers = get_users(array('include'=>$include));
		
		
		if(count($blogusers)!= 0)
		{
		
			
		

		$data  = $productList->get_products($value->product_id);
	
		
		
		$userdata  = get_userdata( $value->user_id );

		
		$name = $userdata->display_name;
		$product_name = $data[0]['name'];

		$msg = send_message($value->user_id,$value->product_id,'stock_over',$time=0);
		trim($msg, "'");
		eval("\$msg = \"$msg\";");
		$notifications_flag = get_user_meta($value->user_id,'notification' , true);
		$email_flag = get_user_meta($value->user_id,'emails' , true);
		$check_email_sent = check_email_sent('stock_over_email',$value->user_id,$value->product_id);

		if(intval($available) == 0 && intval($check_email_sent) == 1 )
		{
				if($email_flag == 1)
				notifications_low_stock($value->user_id,$product_name,$available,'stock_over_email',$value->product_id);
				
				if($notifications_flag == 1)
				$usersToBeNotified[] = array(
						'ID' 			=> $value->user_id,
						'message' 		=> $msg,
						'product' 		=> $product_name,
						'product_id'	=> $value->product_id,
						'type'			=> 'inventory'

					);

		}
		
	}

}
	$result = Parse\ParseCloud::run('sendPushByUserId', ['usersToBeNotified' => $usersToBeNotified] );

	
}



function send_stock_reminders()
{

	global $wpdb;

	global $user;

	$user = new User();

	$usersToBeNotified = array();

	$productList = new ProductList();
	
	$table = $wpdb->prefix . "product_main";

	$defaults = $wpdb->prefix . "defaults";

	$results = $wpdb->get_results("SELECT * from $table where deleted_flag=0");

	$settings = $wpdb->get_row("SELECT * from $defaults where type='settings'");

	
	$object = json_decode($settings->value);
	
	


	foreach ($results as $key => $value) {
		//available count of the user//
		$available = get_stock_count_user($value->user_id,$value->product_id);
		$include = array($value->user_id);
		$blogusers = get_users(array('include'=>$include));
		
		
		if(count($blogusers)!= 0)
		{
		
			
		

		$data  = $user->get_user_home_products($value->user_id,$value->product_id,$date="");
		
		$servings_left = $object->no_of_days;

		$servings_low = intval($data['response'][0]['total']) * intval($servings_left);
		
		$userdata  = get_userdata( $value->user_id );
		$servings = count($data['response'][0]['qty']);
		$qty_size = 0;
		
		foreach ($data['response'][0]['qty'] as $key => $val) {
			$qty_size = $qty_size + $val['qty'];
		}
		if(intval($qty_size) == 0)
			$qty_size = 1;
		$serv = round(intval($available) * intval($servings)/intval($qty_size));
		$name = $userdata->display_name;
		$product_name = $data['response'][0]['name'];

		$msg = send_message($value->user_id,$value->product_id,'stock_low',$time=0);
		trim($msg, "'");
		eval("\$msg = \"$msg\";");
		$notifications_flag = get_user_meta($value->user_id,'notification' , true);
		$email_flag = get_user_meta($value->user_id,'emails' , true);
		
		$check_email_sent = check_email_sent('stock_low_email',$value->user_id,$value->product_id);
		if(intval($serv) <= intval($servings_low) && intval($check_email_sent) == 1 )
		{
				if($email_flag == 1)
				notifications_low_stock($value->user_id,$product_name,$serv,'stock_low_email',$value->product_id);
				
				if($notifications_flag == 1)
				$usersToBeNotified[] = array(
						'ID' 			=> $value->user_id,
						'message' 		=> $msg,
						'product' 		=> $product_name,
						'product_id'	=> $value->product_id,
						'type'			=> 'inventory'

				);

		}
		
	}

}
	$result = Parse\ParseCloud::run('sendPushByUserId', ['usersToBeNotified' => $usersToBeNotified] );


	
}


function check_email_sent($object_type,$user_id,$product_id){


	global $wpdb;

	$communication = $wpdb->prefix . "ajcm_communications";
	$communication_meta = $wpdb->prefix . "ajcm_communication_meta";
	$results = $wpdb->get_results("SELECT * from $communication where communication_type=
		'".$object_type."' and user_id=".$user_id."");

	$comm_id = 0;
	$date = date('Y-m-d H:i:s') ;
	$pro_date = date('Y-m-d H:i:s') ;
	foreach ($results as $key => $value) {
		$row = $wpdb->get_row("SELECT * from $communication_meta where meta_key=
		'product_id' and communication_id=".$value->id." and meta_value=".$product_id."");

		if(!is_null($row))
		{
			$comm_id = $row->communication_id;
			$pro_date =  date('Y-m-d H:i:s',$value->processed );
			break;
		}

		
	}
	
	$last_seven = strtotime( '-7 days' , strtotime ( $date ) );
	$new = strtotime($pro_date);
	$res = "";
	if( intval($new) >= intval($last_seven) && intval($comm_id) == 0)
		 $res =  1;
	else
		 $res = 0;


	return $res;


}
function notifications_low_stock($user_id,$product_name,$available,$type,$product_id){

	
	global $aj_comm;

	$args = array(
		'component'             => 'stock_emails',
		'communication_type'    => $type,
		'user_id'               => $user_id

		);
	// user data
	$user  = login_response( $user_id );

	$meta = array(
		'username'        => $user['display_name'],
		'product_name'    => $product_name,
		'available'       => $available,
		'loginurl'		  => site_url().'/xooma-app/#login',
		'img'			  => get_template_directory_uri().'/xoomaapp/images/logo.png',
		'siteurl'		  => site_url(),
		'product_id'	  => $product_id


		);

	

	$recipients_args = array(
			array(
				'user_id'     => $user_id,
				'type'        => 'email',
				'value'       =>  $user['user_email']

			)

	);

	

	$aj_comm->create_communication($args,$meta,$recipients_args);

	$aj_comm->cron_process_communication_queue("stock_emails",$type);


	return true;


}

function notifications_add_product($product_id,$product_name,$description){

	
	global $aj_comm;

	$args = array(
		'component'             => 'admin_config_emails',
		'communication_type'    => 'add_product_email',
		'user_id'               => $product_id

		);
	// user data
	

	$meta = array(
		'product_name'    => $product_name,
		'description'       => $description,
		'loginurl'		  => site_url().'/xooma-app/#login',
		'img'			  => get_template_directory_uri().'/xoomaapp/images/logo.png',
		'siteurl'			  => site_url()


		);

	

	
	//get all the admins
	$arguments = array(
				'role' => 'Subscriber',
				'orderby' => 'ID',
				'order' => 'ASC',
				'offset' => 0,
				'number' => 0
		);
	$admins = get_users($arguments);

	foreach ((array) $admins as $value) {

		$recipients_args = array(
							array(
							'user_id'     =>  $value->ID,
							'type'        => 'email',
							'value'       => $value->user_email

						)

			);
		$email_flag = get_user_meta($value->ID,'emails' , true);
		if($email_flag == 1)
		$aj_comm->create_communication($args,$meta,$recipients_args);

		}
	
	//send_add_product_notification($admins,$product_id,$product_name,$description);

	

	$aj_comm->cron_process_communication_queue("admin_config_emails",'add_product_email');


	return true;


}

function send_add_product_notification($users,$product_id,$product_name,$description){

	$usersToBeNotified = array();
	foreach ($users as $key => $value) {
		$name = $value->display_name;
		$product_name = $product_name;

		$msg = send_message($value->ID,$product_id,'add_product',$time=0);
		trim($msg, "'");
		eval("\$msg = \"$msg\";");
		$notifications_flag = get_user_meta($value->ID,'notification' , true);
	
		if($notifications_flag == 1)	
		$usersToBeNotified[] = array(
						'ID' 			=> $value->ID,
						'message' 		=> $msg,
						'product' 		=> $product_name,
						'product_id'	=> $product_id,
						'type'			=> 'New Prodcut'

					);
	}
	$result = Parse\ParseCloud::run('sendPushByUserId', ['usersToBeNotified' => $usersToBeNotified] );


	
}

function get_next_occurrence($object_id)
{
	
	global $wpdb;

	$aj_schedules = $wpdb->prefix . "aj_schedules";
	$aj_occurrence_meta = $wpdb->prefix . "aj_occurrence_meta";

	$query = $wpdb->get_results("SELECT * from $aj_schedules where object_id=".$object_id." 
		and object_type='user_product_reminder'");

	
	$occurrences = [];
	if($query)
		foreach ($query as $key => $value) {

			//$squery = $wpdb->get_row("SELECT * from $aj_occurrence_meta where schedule_id=".$value->id."");
			
			// if(is_null($squery)) 
			// {
			// 	$occurrences[] = array(
			// 	'next' => $value->next_occurrence,
			// 	);
			// 	break;
			// }

			$occurrences[] = array(
				'next' => $value->next_occurrence,
			 	);
			
		}

	return $occurrences;
	
}

function get_timezone_date($id,$date)
{
	$user_details = get_user_meta($id,'user_details',true);

	$details = maybe_unserialize($user_details);

	$d = date('Y-m-d H:i:s', strtotime($date));

    $date1 = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $d, $details['timezone']);
    $date1->setTimezone('UTC');
    $today_date = $date1->format("Y-m-d H:i:s");
        
	// date_default_timezone_set($details['timezone']);
	// $datestring = $date;  //Pulled in from somewhere
	// //date("Y-m-d\TH:i:s.000\Z", strtotime($datestring . ' UTC'));
	// $today_date = date("Y-m-d\TH:i:s", strtotime($datestring));
	

	return $today_date;
}

function my_logout(){
  

    

    wp_redirect(site_url().'/xooma/#login');
    die();
}
