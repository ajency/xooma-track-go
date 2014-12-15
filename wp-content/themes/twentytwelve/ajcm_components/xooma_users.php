<?php


function getvars_xooma_admin_email($recipients_email,$comm_data){

	global $aj_comm;
    
	$template_data['name'] = 'xooma_admin_email'; // [slug] name or slug of a template that exists in the user's mandrill account
	$template_data['subject'] = 'User Registeration Notification';
	$template_data['from_email'] = 'no-reply@ajency.in';
	$template_data['from_name'] = 'Xooma';

	$username   = $aj_comm->get_communication_meta($comm_data['id'],'username');
	$email   = $aj_comm->get_communication_meta($comm_data['id'],'email');
	$xoomaid   = $aj_comm->get_communication_meta($comm_data['id'],'xoomaid');
	$registered   = $aj_comm->get_communication_meta($comm_data['id'],'registered');
	$siteurl   = $aj_comm->get_communication_meta($comm_data['id'],'siteurl');



	$template_data['global_merge_vars'] = array();
	$template_data['global_merge_vars'][] = array('name' => 'USERNAME','content' => $username);
	$template_data['global_merge_vars'][] = array('name' => 'EMAIL','content' => $email);
	$template_data['global_merge_vars'][] = array('name' => 'XOOMAID','content' => $xoomaid);
	$template_data['global_merge_vars'][] = array('name' => 'REGISTERED','content' => $registered);
	$template_data['global_merge_vars'][] = array('name' => 'SITEURL','content' => $siteurl);

	return $template_data;

}



function getvars_xooma_user_email($recipients_email,$comm_data){

	global $aj_comm;
    
	$template_data['name'] = 'xooma_admin_email'; // [slug] name or slug of a template that exists in the user's mandrill account
	$template_data['subject'] = 'User Registration Notification';
	$template_data['from_email'] = 'no-reply@ajency.in';
	$template_data['from_name'] = 'Xooma';

	$siteurl   = $aj_comm->get_communication_meta($comm_data['id'],'siteurl');

	$template_data['global_merge_vars'] = array();
	$template_data['global_merge_vars'][] = array('name' => 'SITEURL','content' => $siteurl);

	return $template_data;

}
