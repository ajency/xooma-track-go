<?php 

class User
{
	public function get_user_details($id){

		//get user meta for the user

		$user_details = get_user_meta($id,'user_details',true);
		print_r($user_details);


		
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
		// $data = array();
		// $new_array[0] = array(
  //               'key'   => 'email_id',
  //               'value' => 'surekha@ajency.in'
  //               );
		// $new_array[1] = array(
  //               'key'   => 'phone_no',
  //               'value' => 12344
  //               );
		// $new_array[2] = array(
  //               'key'   => 'birthe_date',
  //               'value' => '2014-11-09'
  //               );
		// $new_array[3] = array(
  //               'key'   => 'name',
  //               'value' => 'suru'
  //               );
        # get all the data paseed from the browser
        $flag = 0;
        foreach ($new_array as $key => $value) {
        	//validation check//
        	if($value['key'] != 'email_id' && $value['key'] != 'name'){
        		$flag = $value['value'] == ""  ? intval($flag) + 1 : 0;
        		$data[$value['key']] = $value['value'];

        	}
        	
            
        }

        //if flag is set to 1, error is sent back and details are not updated 
        if(intval($flag) > 0)
        {
        	return array('status' => 404 ,'response' => 'Data sent to the serer is not in the required format');
        	

        }
		//update user meta for the user
        $user_meta_value = serialize($data);
        $user_details = update_user_meta($id,'user_details',$user_meta_value);

        if($user_details){

        	return array('status' => 200 ,'response' => 'User details updated successfully');
        }
		else
		{
			new WP_Error( 'json_user_details_not_updated', __( 'User details not updated.' ), array( 'status' => 500 ) );

		}

	}
}