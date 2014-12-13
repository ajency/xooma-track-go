<?php

	function uploadImage($url){

    $upload_dir = wp_upload_dir(); // Set upload folder

    $image_data = file_get_contents( $url ); // Get image data

    $filename = basename( $url ); // Create image file name
    // Check folder permission and define file location

    if ( wp_mkdir_p( $upload_dir[ 'path' ] ) ) {

        $file = $upload_dir[ 'path' ] . '/' . $filename;
    } else {

        $file = $upload_dir[ 'basedir' ] . '/' . $filename;
    }


    // Create the image  file on the server

    file_put_contents( $file, $image_data );


    // Check image file type

    $wp_filetype = wp_check_filetype( $filename, null );


    // Set attachment data

    $attachment = array(
        'post_mime_type' => $wp_filetype[ 'type' ],
        'post_title'     => sanitize_file_name( $filename ),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );


    // Create the attachment

    $attach_id = wp_insert_attachment($attachment, $file);


    $image_array = array( 'attachid' => $attach_id, 'file' => $file );

    return $image_array;
}


function save_anytime_product_details($id,$data){

    //store default values for the users's product  

    global $wpdb;
   
    $product_main_table = $wpdb->prefix . "product_main";

    $product_meta_table = $wpdb->prefix . "product_meta";

    $main_id = $wpdb->insert( 
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
        //saving quantity per servings
    for($i=0;$i<$data['time_set'];$i++){

        $meta_id = $wpdb->insert( 
                $product_meta_table, 
                array( 
                  'main_id'                     => $main_id,
                  'key'                         => 'qty_per_servings',
                  'value'                       => serialize(array('qty' => $data['serving_size'],'when' => 1))
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
                  'value'                       => serialize(array('no_of_containers' => $data['serving_size']))
                ), 
                array( 
                  '%d', 
                  '%s',
                  '%s'
                ) 
              );

        

    if($main_id && $meta_id ){

        return array('status' => 200 ,'response' => $main_id);

    }
    else{

        $user = $wpdb->get_row("SELECT * FROM $product_main_table WHERE user_id = ".$id);
        if($user !=null){
            $wpdb->delete( $product_main_table, array( 'user_id' => $id ), array( '%d' ) );
            $wpdb->delete( $product_meta_table, array( 'main_id' => $user->id ), array( '%d' ) );
            
        }
        
        new WP_Error( 'json_user_product_details_not_added', __( 'User Product details not added.' ), array( 'status' => 500 ) );

    }

}

function save_schedule_product_details($id,$data){

    //store default values for the users's product  

    global $wpdb;
   
    $product_main_table = $wpdb->prefix . "product_main";

    $product_meta_table = $wpdb->prefix . "product_meta";

    $main_id = $wpdb->insert( 
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
    //saving quantity per servings
    $meta_id = $wpdb->insert( 
                $product_meta_table, 
                array( 
                  'main_id'                     => $main_id,
                  'key'                         => 'qty_per_servings',
                  'value'                       => serialize(array(
                                                    'qty'  => $data['serving_size'],
                                                    'when' => $data['when']

                                                ))
                ), 
                array( 
                  '%d', 
                  '%s',
                  '%s' 
                ) 
            );
    if($data['serving_size_clone'] != "" && $data['when_clone'] != ""){
        $meta_id = $wpdb->insert( 
                    $product_meta_table, 
                    array( 
                      'main_id'                     => $main_id,
                      'key'                         => 'qty_per_servings',
                      'value'                       => serialize(array(
                                                        'qty'  => $data['serving_size_clone'],
                                                        'when' => $data['when_clone']

                                                    ))
                    ), 
                    array( 
                      '%d', 
                      '%s',
                      '%s' 
                    ) 
                );
    }
    
    
    
    if($main_id && $meta_id){

        return array('status' => 200 ,'response' => $main_id);

    }
    else{

        $user = $wpdb->get_row("SELECT * FROM $product_main_table WHERE user_id = ".$id);
        if($user !=null){
            $wpdb->delete( $product_main_table, array( 'user_id' => $id ), array( '%d' ) );
            $wpdb->delete( $product_meta_table, array( 'main_id' => $user->id ), array( '%d' ) );
            

        }
        
        new WP_Error( 'json_user_product_details_not_added', __( 'User Product details not added.' ), array( 'status' => 500 ) );

    }

}


function update_anytime_product_details($id,$pid,$data){

    global $wpdb;
   
    $product_main_table = $wpdb->prefix . "product_main";

    $product_meta_table = $wpdb->prefix . "product_meta";

    $main_id = $wpdb->insert( 
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

    

       
    $quantity_arr = array();
    for($i=0;$i<$data['servings_count'];$i++){

        //saving quantity per servings
        $meta_id = $wpdb->insert( 
                $product_meta_table, 
                array( 
                  'main_id'                     => $main_id,
                  'key'                         => 'qty_per_servings',
                  'value'                       => serialize(array('qty' => $data['serving_size'],'when' => 1))
                ), 
                array( 
                  '%d', 
                  '%s',
                  '%s'
                ) 
              );

            $time = $data['hour'.$i].':'.$data['min'.$i].':'.$data['period'.$i];
            $time_format   = date('H:i:s', strtotime($time));
            $reminder_id = $wpdb->insert( 
                    $product_reminder_table, 
                    array( 
                      'main_id'                         => $main_id,
                      'key'                             => 'reminder_flag',
                      'value'                           => serialize(array('time_set' => $time_format,'period' => $data['period'.$i]))
                      
                    ), 
                    array( 
                      '%d', 
                      '%s',
                      '%s'
                    ) 
                  );


        }

    
        

        
   

    if($main_id && $meta_id && $config_id && $reminder_id){

        return array('status' => 200 ,'response' => $main_id);

    }
    else{

        $user = $wpdb->get_row("SELECT * FROM $product_main_table WHERE user_id = ".$id);
        if($user !=null){
            $wpdb->delete( $product_main_table, array( 'user_id' => $id ), array( '%d' ) );
            $wpdb->delete( $product_meta_table, array( 'main_id' => $user->id ), array( '%d' ) );
            $wpdb->delete( $product_configuration_table, array( 'main_id' => $user->id ), array( '%d' ) );
            $wpdb->delete( $product_reminder_table, array( 'main_id' => $user->id ), array( '%d' ) );

        }
        
        new WP_Error( 'json_user_product_details_not_updated', __( 'User Product details not updated.' ), array( 'status' => 500 ) );

    }


}



function update_schedule_product_details($id,$pid,$data){

    global $wpdb;
   
    $product_main_table = $wpdb->prefix . "product_main";

    $product_meta_table = $wpdb->prefix . "product_meta";

    $main_id = $wpdb->insert( 
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


    for($i=0;$i<$data['servings_count'];$i++){

            $config_id = $wpdb->insert( 
                    $product_configuration_table, 
                    array( 
                      'main_id'                         => $main_id,
                      'meta_id'                         => $meta_id,
                      'qty_per_servings'                => $data['quantity_per_servings'.$i],
                      'when'                            => $data['when'.$i],
                      
                    ), 
                    array( 
                      '%d', 
                      '%d',
                      '%s',
                      '%s'
                    ) 
            );

            $time = $data['hour'.$i].':'.$data['min'.$i].':'.$data['period'.$i];
            $time_format   = date('H:i:s', strtotime($time));
            $reminder_id = $wpdb->insert( 
                    $product_reminder_table, 
                    array( 
                      'main_id'                         => $main_id,
                      'meta_id'                         => $meta_id,
                      'time_set'                        => $time_format,
                      'period'                          => $data['period'.$i],
                      
                    ), 
                    array( 
                      '%d', 
                      '%d',
                      '%s',
                      '%s'
                    ) 
                  );


    }
        

        
   

    if($main_id && $meta_id ){

        return array('status' => 200 ,'response' => $main_id);

    }
    else{

        $user = $wpdb->get_row("SELECT * FROM $product_main_table WHERE user_id = ".$id);
        if($user !=null){
            $wpdb->delete( $product_main_table, array( 'user_id' => $id ), array( '%d' ) );
            $wpdb->delete( $product_meta_table, array( 'main_id' => $user->id ), array( '%d' ) );
            

        }
        
        new WP_Error( 'json_user_product_details_not_updated', __( 'User Product details not updated.' ), array( 'status' => 500 ) );

    }


}

function get_fblogin_status($data){

        $user_newid = 'FB_'.$data['id'];
     
        $user_name = username_exists( $user_newid );

        //register the user if not exist
        if ( !$user_name && email_exists($data->email) == false ) {
            $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
            $user_name = wp_create_user( $user_newid, $random_password, $data['email'] );
        }

        $user = get_user_by('email', $data['email'] );

       

        //set user data
        $userprofiledata = array(
                        'ID' => $user->ID,
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'display_name' => $data['first_name'],
                        'user_nicename' => sanitize_title($user->user_login),
                        'user_url' => $data['url']
            );

        wp_update_user( $userprofiledata );



        $avatar_url = $data['url'];

        //Update user meta
        update_user_meta( $user->ID, 'facebook_uid', $data['id'] );
        update_user_meta( $user->ID, 'facebook_avatar_full', $avatar_url );
        update_user_meta( $user->ID, 'facebook_avatar_thumb', $avatar_url );
        update_user_meta( $user->ID, 'first_name', $data['first_name'] );
        update_user_meta( $user->ID, 'last_name', $data['last_name']);
        update_user_meta( $user->ID, 'display_name', $data['first_name'] );
        
    

        if ( !is_wp_error( $user ) )
                {
                    wp_clear_auth_cookie();
                    wp_set_current_user ( $user->ID );
                    
            //get the user id
                   $user_id = $user->ID;

                    $response = login_response($user_id);

                }


           else{
                $response = array('status'=>false);
            }


    return $response;

}

function login_response($user_id){
 
    global $user_ID,  $wp_roles ;
    $user = array();
    $user_info = get_userdata($user_id);
    $usermeta = get_user_meta($user_id);
    $attchid = $usermeta['avatar_attachment'][0];
    $facebook_avatar = $usermeta['facebook_avatar_full'][0];
    $avatar_url = wp_get_attachment_image_src($attchid, 'thumbnail' )[0]; 
    $user['status'] = 'true';
    $user['id'] = $user_id;
    $user['user_login'] = $user_info->data->user_login;
    $user['user_email'] = $user_info->data->user_email; 
    $user['display_name'] = $usermeta['first_name'][0]." ".$usermeta['last_name'][0]; 
    $user['role'] =  key($user_info->caps) ;
    $user['display_role'] = $wp_roles->role_names[key($user_info->caps)] ;
    if($facebook_avatar){
       $user['avatar_url'] = $facebook_avatar; 
   }else{
        $user['avatar_url'] = $avatar_url;
   }
   
    
    return  $user;
}

