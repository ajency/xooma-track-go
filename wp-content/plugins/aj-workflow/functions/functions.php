<?php

function workflow_get_forms($workflow_name){

	
	global $wpdb;
	$workflow_tbl = $wpdb->prefix."workflow";
	$workflow_forms_tbl = $wpdb->prefix."workflow_forms";

	//get workflow id 
	$sql_query = $wpdb->get_row("SELECT * FROM $workflow_tbl WHERE workflow_name LIKE '%$workflow_name%'");

	//fetch all forms
	$sql_forms = $wpdb->get_results("SELECT * FROM $workflow_forms_tbl WHERE workflow_id =".$sql_query->id." order by sequence");
		
	if(is_null($sql_query) || count($sql_forms) == 0){

		return new WP_Error( 'Workflow_was_not_found', __( 'Requested Workflow was not Found.' ), array( 'status' => 500 ) );
	}
	else
	{
		return $sql_forms;
	}


}

function workflow_check_user($form_id,$user_id){

	global $wpdb;
	$workflow_user_tbl = $wpdb->prefix."workflow_user";

	//get form id for auser
	$sql_query = $wpdb->get_row("SELECT * FROM $workflow_user_tbl WHERE form_id=".$form_id." and user_id=".$user_id);

	return $sql_query;



}

function workflow_insert_user($form_id,$user_id){

	global $wpdb;
	$workflow_user_tbl = $wpdb->prefix."workflow_user";

	//get default status set into the workflow table;
	$status = workflow_get_status($form_id);
	
	//insert into workflow user table
	if(!(is_wp_error($status))){

		$insert_id = $wpdb->insert( 
			$workflow_user_tbl, 
			array( 
				'form_id'	=> $form_id, 
				'user_id'	=> $user_id,
				'status'	=> $status['default']		 
			), 
			array( 
				'%d', 
				'%d',
				'%s' 
			) 
		);


	}
	else{

		return new WP_Error( 'Workflow_was_not_found', __( 'Requested Workflow was not Found.' ), array( 'status' => 500 ) );
	}
	



}

function workflow_get_status($form_id){

		global $wpdb;
            
        $workflow_tbl       = $wpdb->prefix."workflow";
        $workflow_forms_tbl = $wpdb->prefix."workflow_forms";

        //get workflow id based on form id
        $sql_form = $wpdb->get_row("SELECT * FROM $workflow_forms_tbl WHERE id =".$form_id);
        
        if(!(is_null($sql_form))){

        	//get workflow status
        	$sql = $wpdb->get_row("SELECT * FROM $workflow_tbl WHERE id =".$sql_form->workflow_id);

        	$status_arr = unserialize($sql->status);

        	return  $status_arr;


        }
        else{

        	return new WP_Error( 'Workflow_was_not_found', __( 'Requested Workflow was not Found.' ), array( 'status' => 500 ) );

        }



}

function workflow_form_id($form){

		global $wpdb;
            
        $workflow_forms_tbl=$wpdb->prefix."workflow_forms";

        $sql_form = $wpdb->get_row("SELECT * FROM $workflow_forms_tbl WHERE form_name LIKE '%$form%'");
        
        if(!(is_null($sql_form))){

        	return $sql_form->id;
        }
        else{

        	return new WP_Error( 'Workflow_was_not_found', __( 'Requested Workflow was not Found.' ), array( 'status' => 500 ) );


        }


}



