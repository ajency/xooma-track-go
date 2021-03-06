<?php

function getvars_stock_low_email($recipients_email,$comm_data){

	global $aj_comm;
    
	$template_data['name'] = 'stock_low_email'; // [slug] name or slug of a template that exists in the user's mandrill account
	$template_data['subject'] = 'Stock Low Notification';
	$template_data['from_email'] = 'noreply@xooma.com';
	$template_data['from_name'] = 'Xooma';

	$username   = $aj_comm->get_communication_meta($comm_data['id'],'username');
	$product_name   = $aj_comm->get_communication_meta($comm_data['id'],'product_name');
	$available   = $aj_comm->get_communication_meta($comm_data['id'],'available');
	$loginurl   = $aj_comm->get_communication_meta($comm_data['id'],'loginurl');
	$img   = $aj_comm->get_communication_meta($comm_data['id'],'img');
	$siteurl   = $aj_comm->get_communication_meta($comm_data['id'],'siteurl');
	$siteurl   = $aj_comm->get_communication_meta($comm_data['id'],'siteurl');

	$template_data['global_merge_vars'] = array();
	$template_data['global_merge_vars'][] = array('name' => 'USERNAME','content' => $username);
	$template_data['global_merge_vars'][] = array('name' => 'PRODUCT_NAME','content' => $product_name);
	$template_data['global_merge_vars'][] = array('name' => 'AVAILABLE','content' => $available);
	$template_data['global_merge_vars'][] = array('name' => 'LOGINURL','content' => $loginurl);
	$template_data['global_merge_vars'][] = array('name' => 'SITEURL','content' => $siteurl);
	return $template_data;

}

function getvars_stock_over_email($recipients_email,$comm_data){

	global $aj_comm;
    
	$template_data['name'] = 'stock_over_email'; // [slug] name or slug of a template that exists in the user's mandrill account
	$template_data['subject'] = 'Stock Over Notification';
	$template_data['from_email'] = 'noreply@xooma.com';
	$template_data['from_name'] = 'Xooma';

	$username   = $aj_comm->get_communication_meta($comm_data['id'],'username');
	$product_name   = $aj_comm->get_communication_meta($comm_data['id'],'product_name');
	$available   = $aj_comm->get_communication_meta($comm_data['id'],'available');
	$loginurl   = $aj_comm->get_communication_meta($comm_data['id'],'loginurl');
	$img   = $aj_comm->get_communication_meta($comm_data['id'],'img');
	$siteurl   = $aj_comm->get_communication_meta($comm_data['id'],'siteurl');
	$siteurl   = $aj_comm->get_communication_meta($comm_data['id'],'siteurl');

	$template_data['global_merge_vars'] = array();
	$template_data['global_merge_vars'][] = array('name' => 'USERNAME','content' => $username);
	$template_data['global_merge_vars'][] = array('name' => 'PRODUCT_NAME','content' => $product_name);
	$template_data['global_merge_vars'][] = array('name' => 'AVAILABLE','content' => $available);
	$template_data['global_merge_vars'][] = array('name' => 'LOGINURL','content' => $loginurl);
	$template_data['global_merge_vars'][] = array('name' => 'SITEURL','content' => $siteurl);
	return $template_data;

}