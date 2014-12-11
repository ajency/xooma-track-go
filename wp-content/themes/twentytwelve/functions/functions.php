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

    $product_configuration_table = $wpdb->prefix . "product_configuration";

    $product_reminder_table = $wpdb->prefix . "product_reminder";

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

    $meta_id = $wpdb->insert( 
                $product_meta_table, 
                array( 
                  'main_id'                     => $main_id,
                  'frequency_type'              => $data['frequency_type'],
                  'no_of_servings'              => $data['no_of_servings'],
                  'no_of_containers'            => $no_of_containers,
                  'available_count'             => $available_count,
                  'reminder_flag'               => $data['set_reminder']
                ), 
                array( 
                  '%d', 
                  '%s',
                  '%s',
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

