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
            $images = wp_get_attachment_image_src($user_details['attachment_id'] );
            $image = is_array( $images ) && count( $images ) > 1 ? $images[ 0 ] : get_template_directory_uri() .
              '/img/placeholder.jpg';
			$data = array(
				'id'				        => $user->ID,
				'name'      		        => $user->user_login,
				'email'				        => $user->user_email,
				'xooma_member_id'	        => $xooma_member_id,
				'phone_no'			        => $user_details['phone_no'],
				'gender'			        => $user_details['gender'],
				'birth_date'		        => $user_details['birth_date'],
				'timezone'			        => $user_details['timezone'],
				'image'                     => $image,
                'display_name'              => $user->display_name,
                'user_products'             => $user_products
				);
			
			return array('response' => $data);
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
        $user_meta_value = serialize($args);
        $xooma_member_id = update_user_meta($args['id'],'xooma_member_id',$args['xooma_member_id']);
        $user_details = update_user_meta($args['id'],'user_details',$user_meta_value);

        $metadata = get_user_meta($args['id'], 'user_details', true);
        if($metadata!=""){

            global $aj_workflow;
            $aj_workflow->workflow_update_user($args['id'],'ProfilePersonalInfo');

        }

        if($user_details){
            

            return array('reponse'=>$user_details);
            
        }
		else
		{
			return new WP_Error( 'json_user_details_not_updated', __( 'User details not updated.' ));

		}

	}

  public function update_user_measurement_details($args){

        global $wpdb;
        $measurements_table = $wpdb->prefix . "measurements";

        //insert measurements entery into post table with 
        $user_meta_value = maybe_serialize($args);
        $sql_query = $wpdb->get_row( "SELECT * FROM $measurements_table where `date`='".date('Y-m-d')."' and user_id=".$args['id']."" );
        
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
              $insert_id = $wpdb->update( 
                    $measurements_table, 
                    array( 
                      'user_id' => $args['id'], 
                      'date' => date('Y-m-d'),
                      'value' => $user_meta_value 
                    ), 
                    array( 'ID' => $sql_query->id ), 
                    array( 
                      '%d', 
                      '%s', 
                      '%s' 
                    ),
                    array( '%d' ) 
                  );
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

        if($date != ""){
            $date = $date;
        } 
        else
        {
            $date = date('Y-m-d');
        }
        $sql_query = $wpdb->get_row( "SELECT * FROM $measurements_table where user_id=".$id."" );
        
        

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
            
            
            return array('response' => $data);
        }
        else
        {
            return new WP_Error( 'json_user_meausrement_details_not_found', __( 'User Measurement details not found.' ));
        }


        
    }

    public function save_user_product_details($id,$pid){

        global $ProductList;


        $products_data = $ProductList->get_products($pid);

        

        
        //function to save Anytime users details
        $response = save_anytime_product_details($id,$products_data['response']);

        if($products_data['response']['frequency_value']==2){
            //function to update schedule users details
            $response = save_schedule_product_details($id,$products_data['response']);
        }




    }

    public function update_user_product_details($id,$pid,$data){

        //function to update Anytime users details
        $response = update_anytime_product_details($id,$pid,$products_data['response']);

        if($data['frequency_type']==2){
            //function to update schedule users details
            $response = update_schedule_product_details($id,$pid,$products_data['response']);
        }

    }

    public function delete_user_product_details($id,$pid){

        global $wpdb;
        $product_main_table = $wpdb->prefix . "product_main";

        $updated_id = $wpdb->update( 
            $product_main_table, 
            array( 
                'deleted_flag' => 1
            ), 
            array( 'user_id'        => $id,
                   'product_id'     => $pid    
            ), 
            array( '%d'), 
            array( '%d',
                   '%d'
            ) 
        );

        if($updated_id){

            return array('status'=>200,'response'=>$updated_id);
        }
        else
        {
            return new WP_Error( 'json_user_not_deleted', __( 'User not deleted.' ), array( 'status' => 500 ) );
        }
    }
}
