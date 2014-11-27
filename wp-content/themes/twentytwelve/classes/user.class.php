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
      $images = wp_get_attachment_image_src( $user->attachment_id );
      $image = is_array( $images ) && count( $images ) > 1 ? $images[ 0 ] : get_template_directory_uri() .
          '/img/placeholder.jpg';
			$data = array(
				'id'				        => $user->ID,
				'name'      		    => $user->user_login,
				'email'				      => $user->user_email,
				'xooma_member_id'	  => $xooma_member_id,
				'phone_no'			    => $user_details['phone_no'],
				'gender'			      => $user_details['gender'],
				'birth_date'		    => $user_details['birth_date'],
				'timezone'			    => $user_details['timezone'],
				'weight'			      => $user_details['weight'],
				'height'			      => $user_details['height'],
        'image'             => $image,
        'attachementid'     => $user->attachment_id
				);
			
			return array('status' => 200 ,'response' => $data);
		}
		else
		{
			new WP_Error( 'json_user_details_not_updated', __( 'User details not updated.' ), array( 'status' => 500 ) );
		}


		
	}

	public function update_user_details($id)
	{
		
		//getting all the post parameters
		$putfp = fopen("php://input", "r");

        $putdata = '';
        while($data = fread($putfp, 1024))
            $putdata .= $data;
        $new_array = array();
        $putdata_array = explode('&', $putdata);
        foreach ($putdata_array as $key => $value) {
            $value_arr  = explode('=', $value);
            $new_array[] = array(
                'key'   => $value_arr[0],
                'value' => $value_arr[1]
                );
           
        }
        //getting all the post parameters
    		$data = array();
    		$new_array[0] = array(
                    'key'   => 'email_id',
                    'value' => 'surekha@ajency.in'
                    );
    		$new_array[1] = array(
                    'key'   => 'phone_no',
                    'value' => 1111
                    );
    		$new_array[2] = array(
                    'key'   => 'birth_date',
                    'value' => '20-11-09'
                    );
    		$new_array[3] = array(
                    'key'   => 'name',
                    'value' => 'suru'
                    );
    		$new_array[4] = array(
                    'key'   => 'xooma_member_id',
                    'value' => 123456
                    );
        $new_array[5] = array(
                    'key'   => 'gender',
                    'value' => 'male'
                    );
        $new_array[6] = array(
                    'key'   => 'time_zone',
                    'value' => 'male'
                    );
        # get all the data paseed from the browser
        
      
        foreach ($new_array as $key => $value) {
          //ignoring email id ans name
        	if($value['key'] != 'email_id' && $value['key'] != 'name'){
        		$data[$value['key']] = $value['value'];

        	}
        	
            
        }

        //image upload//
        $attachemnt_id = uploadImage($data['image']);
        if(!(is_array($attachemnt_id)))
        {
          return array('status' => 404 ,'response' => 'Image could not be uploaded');
        }
        $data['attachementid'] = $attachemnt_id['attachid'];

        //image upload//
        //server side valiadation//
        $v = new Valitron\Validator($data);

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

        if($v->validate()) {
            return true;
        } else {
            // Errors
            return array('status' => 404 ,'response' => 'Data sent to the serer is not proper');
        }

		    //update user meta for the user
        $user_meta_value = serialize($data);
        $xooma_member_id = update_user_meta($id,'xooma_member_id',$data['xooma_member_id']);
        $user_details = update_user_meta($id,'user_details',$user_meta_value);

        if($user_details && $xooma_member_id){

        	return array('status' => 200 ,'response' => $user_details);
        }
		else
		{
			new WP_Error( 'json_user_details_not_updated', __( 'User details not updated.' ), array( 'status' => 500 ) );

		}

	}

  public function update_user_measurement_details($id){

      global $wpdb;
      $measurements_table = $wpdb->prefix . "measurements";

        //getting all the post parameters
        $putfp = fopen("php://input", "r");

        $putdata = '';
        while($data = fread($putfp, 1024))
            $putdata .= $data;
        $new_array = array();
        $putdata_array = explode('&', $putdata);
        foreach ($putdata_array as $key => $value) {
            $value_arr  = explode('=', $value);
            $new_array[] = array(
                'key'   => $value_arr[0],
                'value' => $value_arr[1]
                );
           
        }
        $data = array();
        $new_array[0] = array(
                    'key'   => 'weight',
                    'value' => 50
                    );
        $new_array[1] = array( 
                    'key'   => 'abdomen',
                    'value' => 50
                    );
        $new_array[2] = array(
                    'key'   => 'height',
                    'value' => 5
                    );
        $new_array[3] = array(
                    'key'   => 'neck',
                    'value' => 15
                    );
        $new_array[4] = array(
                    'key'   => 'chest',
                    'value' => 12
                    );
        $new_array[5] = array(
                    'key'   => 'upper_arm',
                    'value' => 11
                    );
        

        foreach ($new_array as $key => $value) {
            $data[$value['key']] = $value['value'];

          
        }

        //insert measurements entery into post table with 
        $user_meta_value = serialize($data);
        $sql_query = $wpdb->get_results( "SELECT * FROM $measurements_table where `date`='".date('Y-m-d')."' and user_id=".$id."" );
        

        if(count($sql_query) == 0)
        {
            
              $insert_id = $wpdb->insert( 
                $measurements_table, 
                array( 
                  'user_id' => $id, 
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
                new WP_Error( 'json_user_details_not_updated', __( 'User details not updated.' ), array( 'status' => 500 ) );
              }
        }
        else
        {
          return array('status' => 404 ,'response' => 'Data already exists');
        }
        
        



  }
}
global $user;

$user = new User();

$user->update_user_measurement_details(2);