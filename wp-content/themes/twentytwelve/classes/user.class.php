<?php


class User
{
	public function get_user_details($id){

		//get user meta for the user
        $data = array();
		$user  = get_userdata( $id );
		$user_details = get_user_meta($id,'user_details',true);
		$xooma_member_id = get_user_meta($id,'xooma_member_id',true);
        $user_products = get_user_meta($id,'user_products',true);
        if($user){
			$user_details =   unserialize($user_details);
            $data = array(
				'xooma_member_id'	        => $xooma_member_id,
				'phone_no'			        => $user_details['phone_no'],
				'gender'			        => $user_details['gender'],
				'birth_date'		        => $user_details['birth_date'],
				'timezone'			        => $user_details['timezone'],
				'display_name'              => $user->display_name,
                'user_products'             => $user_products
			);

			

			return $data;
		}
		else
		{
			return new WP_Error( 'json_user_details_not_updated', __( 'User details not updated.' ));
		}



	}

	public function update_user_details($args)
	{

		//server side valiadation//
        $v = new Valitron\Validator($args);

        //custom validation rules//
        $v->addRule('fixedLength', function($field, $value, array $params) {
            return strlen($value) == 6;
        },'must contain only 6 digits.');

        $v->addRule('equalTo', function($field, $value, array $params) {
            $gender = array('male','female');
            if(in_array($value, $gender))
            {
              return $value;
            }

        },'is not matching');

        //custom validation rules//

        //all the rules defined//
        $v->rule('required', ['gender', 'xooma_member_id','birth_date']);
        $v->rule('integer', ['phone_no','xooma_member_id']);
        $v->rule('equalTo', 'gender', 'male');
        $v->rule('fixedLength', 'xooma_member_id', 6);
        $v->rule('date', 'birth_date');
        $v->rule('dateFormat','birth_date','Y-m-d');
        //all the rules defined//

        if(!($v->validate())) {
           return new WP_Error( 'json_user_details_not_updated', __( 'User details not updated.' ));
        }

		    //update user meta for the user
        $user_meta_value = maybe_serialize($args);
       
        $xooma_member_id = update_user_meta($args['id'],'xooma_member_id',$args['xooma_member_id']);
        $user_details = update_user_meta($args['id'],'user_details',$user_meta_value);

        $metadata = get_user_meta($args['id'], 'user_details', true);
        if($metadata!=""){

            global $aj_workflow;
            $aj_workflow->workflow_update_user($args['id'],'ProfilePersonalInfo');


        }
        else
        {
           return new WP_Error( 'json_user_details_not_updated', __( 'User details not updated.' ));
 
        }

        return true;
	}

  public function update_user_measurement_details($id,$args,$date){

        global $wpdb;
        $measurements_table = $wpdb->prefix . "measurements";

        //insert measurements entery into post table with

        if($date == ""){

            $date = date('Y-m-d');
        }
        unset($args['date']);
        $user_meta_value = maybe_serialize($args);
       
        $sql_query = $wpdb->get_row( "SELECT * FROM $measurements_table where `date`='".$date."' and user_id=".$id."" );

        if(count($sql_query) == 0 && $sql_query == null)
        {

              $insert_id = $wpdb->insert(
                $measurements_table,
                array(
                  'user_id' => $id,
                  'date' => $date,
                  'value' => $user_meta_value
                ),
                array(
                  '%d',
                  '%s',
                  '%s'
                )
              );

            global $aj_workflow;
            $aj_workflow->workflow_update_user($id,'profileMeasurement');



            add_asperbmi_products($id,$args['weight']);


        }
        else
        {
            $insert_id = $wpdb->query("UPDATE $measurements_table SET value='".$user_meta_value."' where user_id=".$id." and `date`='".$date."'");
            

              
        }
        
        if($insert_id){

                return array('response' => $insert_id);
              }
        else
              {
                new WP_Error( 'json_user_measurement_details_not_updated', __( 'User Measurement details not updated.' ));
              }



  }


  public function get_user_measurement_details($id,$date){

        global $wpdb;
       
        $measurements_table = $wpdb->prefix . "measurements";
       
        if($date == ""){
            $sql_query = $wpdb->get_row( "SELECT * FROM $measurements_table where user_id=".$id." order by DATE(`date`) DESC LIMIT 1" );
       }
        else
        {
            
            $sql_query = $wpdb->get_row( "SELECT * FROM $measurements_table where user_id=".$id." and date='".$date."'" );

        }
        

       
        $data = array();
        if(count($sql_query) != 0 && $sql_query!= null){



            $user_details =   maybe_unserialize($sql_query->value);

          

            
            
            $user_details['date']  = $sql_query->date;


            return array('response' => $user_details);
        }
        if(is_wp_error($sql_query))
        {
            return new WP_Error( 'json_user_meausrement_details_not_found', __( 'User Measurement details not found.' ));

        }
        else
        {
                    
            return $data;
        }



    }

    public function save_user_product_details($id,$pid){

        global $productList;


        $products_data = $productList->get_products($pid);

       

        //function to save Anytime users details
        

        if($products_data[0]['frequency_value']==2){
            //function to update schedule users details
            $response = save_schedule_product_details($id,$products_data[0]);
        }
        else
        {
            $response = save_anytime_product_details($id,$products_data[0]);
        }

        return $response;


    }

    public function update_user_product_details($id,$pid,$data){

        

        if($data['frequency_type']==2){
            //function to update schedule users details
            $response = update_schedule_product_details($id,$pid,$data);
        }
        else
        {
            //function to update Anytime users details
            $response = update_anytime_product_details($id,$pid,$data);
        }

        return $response;

    }

    public function delete_user_product_details($id,$pid){

        global $wpdb;
        $product_main_table = $wpdb->prefix . "product_main";

        //get stock count of the user//
        $stock_count = get_stock_count_user($id,$pid);

        $updated_id = $wpdb->query("UPDATE $product_main_table SET deleted_flag=1 where user_id=".$id." and product_id='".$pid."'");
            
        //stroring trasaction to keeptrack of quantity
         $args_del = array(

            'user_id'     => $id,
            'product_id'  => $pid,
            'type'        => 'remove',
            'amount'      =>  $stock_count,
            'consumption_type'  => ''


          );
      
      //store_stock_data($args_del);

        if($updated_id){

            return $pid;
        }
        else
        {
            return new WP_Error( 'json_user_not_deleted', __( 'User not deleted.' ) );
        }
    }



    public function get_user_home_products($id,$pid){

        global $wpdb;

        global $user;

        global $productList;

        $user = new User();

        $product_type_table = $wpdb->prefix . "defaults";

        $product_main_table = $wpdb->prefix . "product_main";

        $product_meta_table = $wpdb->prefix . "product_meta";

        if($pid == "")
        {
           $sql_query = $wpdb->get_results("SELECT * FROM $product_main_table WHERE user_id = ".$id." and deleted_flag=0");
 
        }
        else
        {
            $sql_query = $wpdb->get_results("SELECT * FROM $product_main_table WHERE user_id = ".$id." and product_id=".$pid." and deleted_flag=0");
        }
        
        $sub = array();
        $pr_main = array();
       
        
        
        foreach ($sql_query as $key => $term) {

            $val = $productList->get_products($term->product_id);
           
        
            $product_type = $wpdb->get_row("SELECT * FROM $product_type_table WHERE id =".get_term_meta($val[0]['id'], 'product_type', true)." and type='product_type'");
                    
            $sub_query2 = $wpdb->get_results("SELECT * FROM $product_meta_table WHERE `key`='reminders' and main_id = ".$term->id);


                $reminders = array();
                foreach ($sub_query2 as $key => $value) {
                   
                    $data2  = maybe_unserialize($value->value);

                    
                    
                    $reminders[] = array(
                        'time'       => $data2['time']

                        );



                }
                $reminder =  count($reminders) == 0 ? array() : $reminders;
               

            $settings = $wpdb->get_row("SELECT * FROM $product_type_table WHERE type='settings'");
                        
            $settings_data = json_decode($settings->value);
            
            

            
            $user_id = $id;

            $object_id = get_object_id($term->product_id,$user_id);
            
            $object_type = 'user_product_reminder';

    

   



            $start_dt = date('Y-m-d 00:00:00');


        

           

            $end_date = date('Y-m-d 23:59:59');

            $occurrence = get_occurrence_date($term->product_id,$id,$date="");

            $response = $user->get_user_product_details($id,$term->product_id);

            //get stock count of the user//
            $stock_count = get_stock_count_user($id,$term->product_id);

            //get users_timezone

            $occurrences = \ajency\ScheduleReminder\Occurrence::
                    get_upcoming_occurrences($object_type,$end_date,$start_dt,$object_id);



            $next = 0;
            if(count( $occurrences) != 0)
                $next = $occurrences;


            $sub[] = array(
                'id'            => intval($term->product_id),
                'name'          => $val[0]['name'],
                'servings'      => count($response['qty']),
                'qty'          => $response['qty'],
                'product_type'  => $product_type->value,
                'occurrence'    => $occurrence,
                'available'     => $stock_count,
                'total'         =>  $val[0]['total'],
                'reminder'      => $reminder,
                'settings'      => $settings_data->no_of_days,
                'type'          => $val[0]['frequency'],
                'timezone'      => $response['timezone'],
                'upcoming'      => $occurrences


    );


          
     

    } 


    //get graph data 
    $reg_date = get_user_measurement_date($id);
    $graph = generate_dates($reg_date,date('Y-m-d'),$id,'weight');

    $data = USER::get_user_measurement_details($id,$date="");
    
  

    
    
        

       
            

           
                
                // foreach ($sql_query as $key => $term) {

                //     $value = $productList->get_products($term->product_id);
                  
                //     $product_type = $wpdb->get_row("SELECT * FROM $product_type_table WHERE id =".get_term_meta($value[0]['id'], 'product_type', true)." and type='product_type'");
                //     $frequency = (get_term_meta($value[0]['id'], 'frequency', true) == 1) ? 'Anytime' : 'Scheduled';
                //     $time_set = get_term_meta($value[0]['id'], 'time_set', true);
                    

                //     if($frequency == $val && $time_set != 'asperbmi'){
                        
                        
                       
                //         $meta_arr = array();
                //         $user_id = $id;
                        
                //         $occurrence = get_occurrence_date($term->product_id,$user_id,$date="");
                //         $response = $user->get_user_product_details($id,$term->product_id);
                //         //get stock count of the user//
                //         $stock_count = get_stock_count_user($id,$term->product_id);
                //         $sub[] = array(


                //             'id'            => intval($term->product_id),
                //             'name'          => $value[0]['name'],
                //             'qty'           => $response['qty'],
                //             'servings'      => count($response['qty']),
                //             'product_type'  => $product_type->value,
                //             'occurrence'    => $occurrence,
                //             'available'     => $stock_count,
                //             'total'         => $value[0]['total']


                //             );
                        

                //     }
                    

                // }

               

              


   
    return array('response'=>$sub, 'graph'=> $graph,'reg_date' => $reg_date,'weight'=>$data['response']['weight']);
        

    }

    public function get_user_product_details($id,$pid){

        global $wpdb;

        global $user;

        $user = new User();

        $user_data = $user->get_user_details($id);
        
        $product_main_table = $wpdb->prefix . "product_main";

        $product_meta_table = $wpdb->prefix . "product_meta";
        $response = array();
        
        $sql_query = $wpdb->get_row("SELECT * FROM $product_main_table WHERE user_id = ".$id." and product_id=".$pid." and deleted_flag=0");
        if($sql_query)
        {
        $sub_query = $wpdb->get_results("SELECT * FROM $product_meta_table WHERE `key`='qty_per_servings' and main_id = ".$sql_query->id);
        $servings = array();
        
        foreach ($sub_query as $key => $value) {
           
            $data  = maybe_unserialize($value->value);
            
            $servings[] = array(
                'qty'           => $data['qty'],
                'when'          => $data['when']
                

                );



        }
       

        $sub_query1 = $wpdb->get_row("SELECT * FROM $product_meta_table WHERE `key`='no_of_containers' and main_id = ".$sql_query->id);

        $data1 = maybe_unserialize($sub_query1->value);

        $sub_query2 = $wpdb->get_results("SELECT * FROM $product_meta_table WHERE `key`='reminders' and main_id = ".$sql_query->id);


        $reminders = array();
        foreach ($sub_query2 as $key => $value) {
           
            $data2  = maybe_unserialize($value->value);

            
            
            $reminders[] = array(
                'time'       => $data2['time']

                );



        }
        $reminder =  count($reminders) == 0 ? array(array('time' => ""),array('time' => "")) : $reminders;
       
        global $productList;
        $all_terms = $productList->get_products($pid);
        

        $count = count($servings);
        if($all_terms[0]['time_set'] == 'asperbmi')
        {
             $count = 'asperbmi';
        }
        

        if($all_terms[0]['frequency_value'] == 2)
        {
            $count = count($servings) == 1 ? 'Once' : 'Twice';
        }
        $stock_count = get_stock_count_user($id,$pid);
        $response = array(
            'id'                    => $pid,
            'no_of_container'       => $data1['no_of_container'],
            'total'                 => $stock_count,
            'reminder_flag'         => $data1['reminder_flag'],
            'check'                 => $data1['check'],
            'qty'                   => $servings,
            'name'                  => $all_terms[0]['name'],
            'description'           => $all_terms[0]['description'],
            'product_type_name'     => $all_terms[0]['product_type_name'],
            'frequency'             => $all_terms[0]['frequency'],
            'frequency_value'       => $all_terms[0]['frequency_value'],
            'image'                 => $all_terms[0]['image'],
            'time_set'              => $count,
            'reminders'             => $reminder,
            'timezone'              => $user_data['timezone'],
            'bmi'                   => get_term_meta($all_terms[0]['id'], 'BMI', true)
                
            


            );



        return $response;
    }


else
{
    return $response;
}
   
}
}
