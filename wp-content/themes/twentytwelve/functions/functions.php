<?php
 date_default_timezone_set("UTC");

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

       //stroring trasaction to keeptrack of quantity

        //store schedule

        $schedule = array(
          'main_id'   => $main_id,
          'time_set'  => $data['time_set']

          );
        store_add_schedule($schedule);

      //store schedule

        
        

        return $data['id'];
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

        return $pid;

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

        return $pid;

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

  send_notifications_to_admin($user_id);
  send_notifications_to_user($user_id);
  add_asperbmi_products($user_id);
}
function check_workflow($user_model){




  //workflow plugin code
    global $aj_workflow;
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

    $user_model->state = $state;

    $user_model->products = $products;





    return $user_model;
}

function get_user_products($id){

    global $wpdb;

    $product_main_table = $wpdb->prefix . "product_main";

    $results = $wpdb->get_results("SELECT * FROM $product_main_table WHERE user_id = ".$id);

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


function get_occurrence_date($product_id,$user_id=""){

  if($user_id ==""){
    $user_id = get_current_user_id();
  }
  
  //get object id
  $object_id = get_object_id($product_id,$user_id);

  if(!is_wp_error($object_id)){

    //get schedule id
  $schedule = \ajency\ScheduleReminder\Schedule::get_schedule_id('user_product', $object_id);

    $start_datetime = date('Y-m-d 00:00:00');
    $end_datetime = date('Y-m-d 23:59:59');


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

function add_asperbmi_products($user_id){

  //add asperbmi products

        $productList = new ProductList();

        

        $all_terms = $productList->get_products($term_id="");
        foreach ($all_terms as $key => $value) {
            
           $time_set = get_term_meta($value['id'], 'time_set', true);
            if( $time_set == 'asperbmi' ){
                
                    $value['time_set'] = 1;
                    save_anytime_product_details($user_id,$value);

            }

        }


}

function store_stock_data($args){

  global $wpdb;

 

  $transactions = $wpdb->prefix . "transactions";

  $main = $wpdb->insert(
                $transactions,
                array(
                  'user_id'                        => $args['user_id'],
                  'product_id'                     => $args['product_id'],
                  'type'                           => $args['type'],
                  'amount'                         => $args['amount'],
                  'consumption_type'               => $args['consumption_type'],
                  'datetime'                            => date('y-m-d H:i:s')
                ),
                array(
                  '%d',
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

    
    $stock = $wpdb->get_row("SELECT sum(amount) as stock from  $transactions where user_id=".$id
      ." and product_id=".$product_id." and type='stock'");



   
    $del = $wpdb->get_row("SELECT sum(amount) as del from  $transactions where user_id=".$id
      ." and product_id=".$product_id." and type='remove'");



    $amt = $stock->stock == null ? 0 : $stock->stock;
    $remove = $del->del == null ? 0 : $del->del;

    $stock_count  = intval($amt) - intval($remove);

    return $stock_count;

}

function get_history_user_product($id,$product_id){

    global $wpdb;

    $transactions = $wpdb->prefix . "transactions";

    global $productList;
    $term = $productList->get_products($product_id);

    $results = $wpdb->get_results("SELECT sum(amount) as stock, DATE(datetime) as datefield from $transactions
        where user_id=".$id." and product_id=".$product_id." and type='stock' group by DATE(datetime) DESC");

      $transaction= array();
      foreach ($results as $key => $value) {
       
             $sales = $wpdb->get_row("SELECT sum(amount) as sales from $transactions
              where user_id=".$id." and product_id=".$product_id." and type='remove' and consumption_type='sales'");
             
             $consumption = $wpdb->get_row("SELECT sum(amount) as consumption from $transactions
              where user_id=".$id." and product_id=".$product_id." and type='remove' and consumption_type=''");
             

             $consumed = $consumption->consumption == null ? 0 : $consumption->consumption;
             $sales_data = $sales->sales == null ? 0 : $sales->sales;

             $transaction = array(
              'date'        =>  $value->datefield, 
              'stock'       =>  $value->stock,
              'sales'       =>  $sales_data,
              'consumption'   => $consumed,
              'type'          => $term[0]['product_type_name']


              );
      }

   return $transaction;

}