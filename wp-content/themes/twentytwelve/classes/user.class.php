<?php 


class User 
{
	public function get_user_details($id){

		//get user meta for the user
        $data = array();
		$user  = get_userdata( $id );
		$user_details = get_user_meta($id,'user_details',true);
		$xooma_member_id = get_user_meta($id,'xooma_member_id',true);
        if($user_details){
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
                'attachment_id'             => $user_details['attachment_id']
				);
			
			return array('status' => 200 ,'response' => $data);
		}
		else
		{
			new WP_Error( 'json_user_details_not_updated', __( 'User details not updated.' ), array( 'status' => 500 ) );
		}


		
	}

	public function update_user_details($args)
	{
		
		//image upload//
        $attachment_id = uploadImage($args['image']);

        if(!(is_array($attachment_id)))
        {
          return array('status' => 404 ,'response' => 'Image could not be uploaded');
        }
        $args['attachment_id'] = $attachment_id['attachid'];

        //image upload//
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
           return array('status' => 404 ,'response' => 'Data sent to the serer is not proper');
        }

		    //update user meta for the user
        $user_meta_value = serialize($args);
        $xooma_member_id = update_user_meta($args['id'],'xooma_member_id',$args['xooma_member_id']);
        $user_details = update_user_meta($args['id'],'user_details',$user_meta_value);
        
        if($user_details && $xooma_member_id){

        	return array('status' => 200 ,'response' => $user_details);
        }
		else
		{
			new WP_Error( 'json_user_details_not_updated', __( 'User details not updated.' ), array( 'status' => 500 ) );

		}

	}

  public function update_user_measurement_details($args){

        global $wpdb;
        $measurements_table = $wpdb->prefix . "measurements";

        //insert measurements entery into post table with 
        $user_meta_value = serialize($args);
        $sql_query = $wpdb->get_results( "SELECT * FROM $measurements_table where `date`='".date('Y-m-d')."' and user_id=".$args['id']."" );
        

        if(count($sql_query) == 0)
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

              if($insert_id){

                return array('status' => 200 ,'response' => $user_details);
              }
              else
              {
                new WP_Error( 'json_user_measurement_details_not_updated', __( 'User Measurement details not updated.' ), array( 'status' => 500 ) );
              }
        }
        else
        {
          return array('status' => 404 ,'response' => 'Data already exists');
        }
        
        



  }


  public function get_user_measurement_details($id){

        global $wpdb;
        $measurements_table = $wpdb->prefix . "measurements";

        $sql_query = $wpdb->get_results( "SELECT * FROM $measurements_table where `date`='".date('Y-m-d')."' and user_id=".$id."" );
        
        echo "SELECT * FROM $measurements_table where `date`='".date('Y-m-d')."' and user_id=".$id."";

        $data = array();
        if(count($sql_query) != 0){
            $user_details =   unserialize($sql_query->value);
            $data = array(
                'id'                        => $id,
                'height'                    => $user_details['height'],
                'weight'                    => $user_details['weight'],
                'neck'                      => $user_details['neck'],
                'check'                     => $user_details['check'],
                'waist'                     => $user_details['waist'],
                'abdomen'                   => $user_details['abdomen'],
                'hips'                      => $user_details['hips'],
                'thigh'                     => $user_details['thigh'],
                'midcalf'                   => $user_details['midcalf'],
                'calf'                      => $user_details['calf']
                );
            
            return array('status' => 200 ,'response' => $data);
        }
        else
        {
            new WP_Error( 'json_user_meausrement_details_not_found', __( 'User Measurement details not found.' ), array( 'status' => 500 ) );
        }


        
    }
}
