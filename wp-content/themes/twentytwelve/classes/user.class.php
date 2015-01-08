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

  public function update_user_measurement_details($args,$date=""){

        global $wpdb;
        $measurements_table = $wpdb->prefix . "measurements";

        //insert measurements entery into post table with

        if($date == ""){

            $date = date('Y-m-d');
        }
        $user_meta_value = maybe_serialize($args);
        $sql_query = $wpdb->get_row( "SELECT * FROM $measurements_table where `date`='".$date."' and user_id=".$args['id']."" );

        if(count($sql_query) == 0 && $sql_query == null)
        {

              $insert_id = $wpdb->insert(
                $measurements_table,
                array(
                  'user_id' => $args['id'],
                  'date' => date('Y-m-d'),
                  'value' => $user_meta_value
                ),
                array(
                  '%d',
                  '%s',
                  '%s'
                )
              );

            global $aj_workflow;
            $aj_workflow->workflow_update_user($args['id'],'profileMeasurement');


        }
        else
        {
            $insert_id = $wpdb->query("UPDATE $measurements_table SET value='".$user_meta_value."' where user_id=".$args['id']." and `date`='".$date."'");
            

              
        }
        
        if($insert_id){

                return array('response' => $insert_id);
              }
        else
              {
                new WP_Error( 'json_user_measurement_details_not_updated', __( 'User Measurement details not updated.' ));
              }



  }


  public function get_user_measurement_details($id,$date=""){

        global $wpdb;
        $measurements_table = $wpdb->prefix . "measurements";
       
        if($date == ""){
            $sql_query = $wpdb->get_row( "SELECT * FROM $measurements_table where user_id=".$id." order by DATE(`date`) ASC LIMIT 1" );
       }
        else
        {
            
            $sql_query = $wpdb->get_row( "SELECT * FROM $measurements_table where user_id=".$id." and date=".$date );

        }
        

       
        $data = array();
        if(count($sql_query) != 0 && $sql_query!= null){



            $user_details =   maybe_unserialize($sql_query->value);

            
            $data['height']  = $user_details['height'];
            $data['weight']  = $user_details['weight'];
            $data['neck']  = $user_details['neck'];
            $data['chest']  = $user_details['chest'];
            $data['abdomen']  = $user_details['abdomen'];
            $data['waist']  = $user_details['waist'];
            $data['hips']  = $user_details['hips'];
            $data['thigh']  = $user_details['thigh'];
            $data['midcalf']  = $user_details['midcalf'];
            $data['arm']  = $user_details['arm'];
            $data['date']  = $sql_query->date;


            return array('response' => $data);
        }
        else
        {
            return new WP_Error( 'json_user_meausrement_details_not_found', __( 'User Measurement details not found.' ));
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

        $updated_id = $wpdb->query("UPDATE $product_main_table SET deleted_flag=1 where user_id=".$id." and product_id='".$pid."'");
            
        

        if($updated_id){

            return $pid;
        }
        else
        {
            return new WP_Error( 'json_user_not_deleted', __( 'User not deleted.' ) );
        }
    }


    public function get_user_products($id){

        global $wpdb;

        $product_type_table = $wpdb->prefix . "defaults";

        $product_main_table = $wpdb->prefix . "product_main";
        $sql_query = $wpdb->get_results("SELECT * FROM $product_main_table WHERE user_id = ".$id." and deleted_flag=0");


        $products_arr = array();
        foreach ($sql_query as $key => $value) {
            array_push($products_arr, $value->product_id);
        }
        $pr_main = array();
        $sub = array();
        global $productList;
        $all_terms = $productList->get_products($term_id="");
        foreach ($all_terms as $key => $value) {
            
           $time_set = get_term_meta($value['id'], 'time_set', true);
            if( $time_set == 'asperbmi' ){
                
                    $value['time_set'] = 1;
                    // save_anytime_product_details($id,$value);
                    if(in_array($value['id'], $products_arr)){
                        $product_type = $wpdb->get_row("SELECT * FROM $product_type_table WHERE id =".get_term_meta($value['id'], 'product_type', true)." and type='product_type'");
                        $frequency = (get_term_meta($value['id'], 'frequency', true) == 1) ? 'Anytime' : 'Scheduled';
                       

                            $serving_size = get_term_meta($value['id'], 'serving_size', true);
                            // $time_set = get_term_meta($value['id'], 'time_set', true);
                            // $no_of_servings = $time_set;
                            $time_set = 1 ;
                            $no_of_servings = $time_set;
                            $servings_qty = explode('|', $serving_size);
                            //add chedule by default
                            $user_id = $id;
                            $occurrence = get_occurrence_date($value['id'],$user_id);
                            $qty = intval($servings_qty[0]) + intval($servings_qty[1]);
                            $sub[] = array(
                                'id'            => $value['id'],
                                'name'          => $value['name'],
                                'servings'      => $no_of_servings,
                                'qty1'          => intval($servings_qty[0]),
                                'qty2'          => intval($servings_qty[1]),
                                'product_type'  => $product_type->value,
                                'occurrence'    => $occurrence


                );
            }      
          
        }

    } 
     $pr_main[] = array(

                            'type'      => 'As per BMI',
                            'products'  => $sub

                            );   
        $products = implode(',', $products_arr);

        
            $product_id = get_category_by_slug('product');
            $term = get_categories('parent='.$product_id->term_id.'&include='.$products.'&hide_empty=0');


            $product_type = array('Anytime','Scheduled');

            
            foreach ($product_type as $key => $val) {
                $sub = array();
                foreach ($term as $key => $value) {

                    $product_type = $wpdb->get_row("SELECT * FROM $product_type_table WHERE id =".get_term_meta($value->term_id, 'product_type', true)." and type='product_type'");
                    $frequency = (get_term_meta($value->term_id, 'frequency', true) == 1) ? 'Anytime' : 'Scheduled';
                    $time_set = get_term_meta($value->term_id, 'time_set', true);
                    if($frequency == $val && $time_set != 'asperbmi'){

                        $serving_size = get_term_meta($value->term_id, 'serving_size', true);
                        
                        if($time_set == 'Once')
                            $no_of_servings = 1;
                        else if($time_set == 'Twice')
                            $no_of_servings = 2;
                        else
                            $no_of_servings = $time_set;
                        
                        $servings_qty = explode('|', $serving_size);
                        
                        $qty = intval($servings_qty[0]) + intval($servings_qty[1]); 
                        $meta_arr = array();
                        $sub[] = array(
                            'id'            => $value->term_id,
                            'name'          => $value->name,
                            'servings'      => $no_of_servings,
                            'qty1'          => intval($servings_qty[0]),
                            'qty2'          => intval($servings_qty[1]),
                            'product_type'  => $product_type->value


                            );
                        

                    }
                    

                }

                

                        $pr_main[] = array(

                            'type'      => $val,
                            'products'  => $sub

                            );
            }

       
    return $pr_main;
        


    }

    public function get_user_home_products($id){

        global $wpdb;

        global $user;

        global $productList;

        $user = new User();

        $product_type_table = $wpdb->prefix . "defaults";

        $product_main_table = $wpdb->prefix . "product_main";
        $sql_query = $wpdb->get_results("SELECT * FROM $product_main_table WHERE user_id = ".$id." and deleted_flag=0");

        $sub = array();
        $pr_main = array();
       
        
        
        foreach ($sql_query as $key => $term) {

            $value = $productList->get_products($term->product_id);
            
            $time_set = $value[0]['time_set'];
            if( $time_set == 'asperbmi'){
                    $product_type = $wpdb->get_row("SELECT * FROM $product_type_table WHERE id =".get_term_meta($value[0]['id'], 'product_type', true)." and type='product_type'");
                    $frequency = (get_term_meta($value[0]['id'], 'frequency', true) == 1) ? 'Anytime' : 'Scheduled';
                   

                        $serving_size = get_term_meta($value[0]['id'], 'serving_size', true);
                        $time_set = 1;
                        $no_of_servings = $time_set;


                        
                        $servings_qty = explode('|', $serving_size);
                        
                        $qty = intval($servings_qty[0]) + intval($servings_qty[1]);
                        $user_id = $id;

                        $occurrence = get_occurrence_date($value[0]['id'],$user_id);

                        

                        $sub[] = array(
                            'id'            => $value[0]['id'],
                            'name'          => $value[0]['name'],
                            'servings'      => $no_of_servings,
                            'qty1'          => intval($servings_qty[0]),
                            'qty2'          => intval($servings_qty[1]),
                            'product_type'  => $product_type->value,
                            'occurrence'    => $occurrence


                );
                
          
        }

    } 
     $pr_main[] = array(

                            'type'      => 'As per BMI',
                            'products'  => $sub

                            );   
        

       
            

            $product_type = array('Anytime','Scheduled');

            
            foreach ($product_type as $key => $val) {
                $sub = array();
                foreach ($sql_query as $key => $term) {
                    $value = $productList->get_products($term->product_id);
                    
                    $product_type = $wpdb->get_row("SELECT * FROM $product_type_table WHERE id =".get_term_meta($value[0]['id'], 'product_type', true)." and type='product_type'");
                    $frequency = (get_term_meta($value[0]['id'], 'frequency', true) == 1) ? 'Anytime' : 'Scheduled';
                    $time_set = get_term_meta($value[0]['id'], 'time_set', true);
                    if($frequency == $val && $time_set != 'asperbmi'){
                        
                        $response = $user->get_user_product_details($id,$term->product_id);
                       
                        $meta_arr = array();
                        $user_id = $id;
                        
                        $occurrence = get_occurrence_date($term->product_id,$user_id);
                        
                        $sub[] = array(


                            'id'            => $term->product_id,
                            'name'          => $value[0]['name'],
                            'qty'           => $response['qty'],
                            'product_type'  => $product_type->value,
                            'occurrence'    => $occurrence


                            );
                        

                    }
                    

                }

               

                        $pr_main[] = array(

                            'type'      => $val,
                            'products'  => $sub

                            );
            }


      
    return $pr_main;
        

    }

    public function get_user_product_details($id,$pid){

        global $wpdb;

        global $user;

        $user = new User();


        $product_main_table = $wpdb->prefix . "product_main";

        $product_meta_table = $wpdb->prefix . "product_meta";

        $sql_query = $wpdb->get_row("SELECT * FROM $product_main_table WHERE user_id = ".$id." and product_id=".$pid." and deleted_flag=0");

        $sub_query = $wpdb->get_results("SELECT * FROM $product_meta_table WHERE `key`='qty_per_servings' and main_id = ".$sql_query->id);

        $servings = array();
        foreach ($sub_query as $key => $value) {
           
            $data  = maybe_unserialize($value->value);
            
            $servings[] = array(
                'qty'       => $data['qty'],
                'when'      => $data['when']

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
       
        $response = array(
            'id'                    => $pid,
            'no_of_container'       => $data1['no_of_container'],
            'total'                 => $data1['available'],
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
            'reminders'             => $reminders
                
            


            );



        return $response;
    }
   
}
