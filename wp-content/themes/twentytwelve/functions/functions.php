<?php


function save_anytime_product_details($id,$data){

		//store default values for the users's product

		global $wpdb;

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
									'value'                       => serialize(array('qty' =>$qty[0],'when' => 1))
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

				
				$user = new User();
				$product = $user->get_user_home_products($id,$data['id']);
				return $product;
				
		}
		else{
				new WP_Error( 'json_user_product_details_not_added', __( 'User Product details not added.' ));
		}
	}
}




function update_anytime_product_details($id,$pid,$data){

		global $wpdb;

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

						//savings reminders
					 $meta_id = $wpdb->insert(
									$product_meta_table,
									array(
										'main_id'                     => $main_id,
										'key'                         => 'reminders',
										'value'                       => serialize(array('time' => $data['reminder_time'.$i]))
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

				for($i=0;$i<$data['reminders_length'];$i++){

						//savings reminders
					 $meta_id = $wpdb->insert(
									$product_meta_table,
									array(
										'main_id'                     => $main_id,
										'key'                         => 'reminders',
										'value'                       => serialize(array('time' => $data['reminder_time'.$i]))
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

		//store schedule

				$schedule = array(
					'main_id'   => $main_id,
					'time_set'  => $data['servings_per_day']

					);
				store_add_schedule($schedule);

			//store schedule
	}


		if($main){
				$user = new User();
				$product = $user->get_user_home_products($id,$pid);
				return $product;

		}
		else{

				

				return new WP_Error( 'json_user_product_details_not_updated', __( 'User Product details not updated.' ));

		}


}



function update_schedule_product_details($id,$pid,$data){

		global $wpdb;

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
					 $meta_id = $wpdb->insert(
									$product_meta_table,
									array(
										'main_id'                     => $main_id,
										'key'                         => 'reminders',
										'value'                       => serialize(array('time' => $data['reminder_time'.$i]))
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

				for($i=0;$i<$data['reminders_length'];$i++){

						//savings reminders
					 $meta_id = $wpdb->insert(
									$product_meta_table,
									array(
										'main_id'                     => $main_id,
										'key'                         => 'reminders',
										'value'                       => serialize(array('time' => $data['reminder_time'.$i]))
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

		 //store schedule

				$schedule = array(
					'main_id'   => $main_id,
					'time_set'  => $data['servings_per_day']

					);
				store_add_schedule($schedule);

			//store schedule
			 
	}


		if($main){
				$user = new User();
				$product = $user->get_user_home_products($id,$pid);
				return $product;

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
		'registered'      => $user['user_registered'],
		'siteurl'         => site_url().'/wp-admin'


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
							'user_id'     => $user_id,
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
		'siteurl'         => site_url().'/wp-admin'


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

//filter to check workflow process
add_filter( 'aj_user_model', 'check_workflow' );

//send emails
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

		$user_model->timezone = $user_data['timezone'];

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

		global $user_ID,  $wp_roles ;
		$user = array();
		$user_info = get_userdata($user_id);
		$usermeta = get_user_meta($user_id);
		$user['status'] = 'true';
		$user['id'] = $user_id;
		$user['user_login'] = $user_info->data->user_login;
		$user['user_email'] = $user_info->data->user_email;
		$user['display_name'] = $usermeta['first_name'][0]." ".$usermeta['last_name'][0];
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
			}
			else
			{


		
				$start_datetime = date("Y-m-d 00:00:00", strtotime($date));
				$end_datetime = date("Y-m-d 23:59:59", strtotime($date));
			}

			$occurrences = \ajency\ScheduleReminder\Occurrence::
			get_occurrences($schedule, $start_datetime, $end_datetime); 
			


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

						date_default_timezone_set("UTC");
						$interval = 24/intval($servings);
						$today = date("H:i:s", strtotime($reminder));
						$start = date("Y-m-d $today ");
						$schedule_data = array(
								'object_type' => 'user_product_reminder',
								'object_id' => $main_id,
								'start_dt'  => $start,
								'rrule' => "FREQ=HOURLY;INTERVAL=".$interval.";WKST=MO"
						);
						
						$id = \ajency\ScheduleReminder\Schedule::add($schedule_data);

					 

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
					$time_set = $value['time_set'];
						if( $time_set == 'asperbmi' ){
							 
										$bmi = $value['bmi'];
										
										foreach ($bmi as $key => $val) {
											
											$original = explode('<', $val['range']);

											$actual = 1 ;

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



			update_schedule($args['main_id']);


				date_default_timezone_set("UTC");
						$interval = 24/intval($args['time_set']);
						$today = strtotime('00:00:00');
					 $start = date("Y-m-d 00:00:00");
						$schedule_data = array(
								'object_type' => 'user_product',
								'object_id' => $args['main_id'],
								'start_dt'  => $start,
								'rrule' => "FREQ=HOURLY;INTERVAL=".$interval.";WKST=MO"
						);
				
				$id = \ajency\ScheduleReminder\Schedule::add($schedule_data);

				

}
function update_schedule($main_id){

	global $wpdb;

	$schedules = $wpdb->prefix . "aj_schedules";

	$occurrence_meta = $wpdb->prefix . "aj_occurrence_meta";

	$sqlquery = $wpdb->get_row("SELECT * from $schedules where object_id=".$main_id);

	$query = $wpdb->query("DELETE from $schedules where object_id=".$main_id);

	if( $sqlquery)
	$query = $wpdb->query("DELETE from $occurrence_meta where schedule_id=".$sqlquery->id);



}
function get_stock_count_user($id,$product_id){

		global $wpdb;

		$transactions = $wpdb->prefix . "transactions";

		$object_id = get_object_id($product_id,$id);
		
		$stock = $wpdb->get_row("SELECT sum(amount) as stock from  $transactions where object_id=".$object_id
			."  and type='stock'");



	 
		$del = $wpdb->get_row("SELECT sum(amount) as del from  $transactions where object_id=".$object_id
			." and type='remove'");



		$amt = $stock->stock == null ? 0 : $stock->stock;
		$remove = $del->del == null ? 0 : $del->del;

		$stock_count  = intval($amt) - intval($remove);

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

			 
	 return $transaction;

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
		date_default_timezone_set("UTC");

		
		$today = date("Y-m-d", strtotime($args['date']));
		$start = date("$today H:i:s ");
		
		
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

				$occurrence = get_occurrence_date($args['pid'],$args['id'],$date="");



				return array('occurrence'=> $occurrence, 'meta_id'=>$meta_id);




}
//generate_dates('2014-01-01','2015-01-01',186,'weight');

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
			
				$previous = $wpdb->get_row("SELECT *, DATE(`date`) as datefield from $table where id < $previous_ro->id LIMIT 1 ");
				
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
					$next = $wpdb->get_row("SELECT *, DATE(`date`) as datefield from $table where id > $next_ro->id LIMIT 1 ");
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

   return $sql_query->date;
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