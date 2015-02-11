<?php

function getvars_add_product_email($recipients_email,$comm_data){

	global $aj_comm;
    
	$template_data['name'] = 'add_product_email'; // [slug] name or slug of a template that exists in the user's mandrill account
	$template_data['subject'] = 'Add Product Ntification';
	$template_data['from_email'] = 'no-reply@ajency.in';
	$template_data['from_name'] = 'Xooma';

	$product_name   = $aj_comm->get_communication_meta($comm_data['id'],'product_name');
	$description   = $aj_comm->get_communication_meta($comm_data['id'],'description');
	$loginurl   = $aj_comm->get_communication_meta($comm_data['id'],'loginurl');
	$img   = $aj_comm->get_communication_meta($comm_data['id'],'img');

	$template_data['global_merge_vars'] = array();
	$template_data['global_merge_vars'][] = array('name' => 'PRODUCT_NAME','content' => $product_name);
	$template_data['global_merge_vars'][] = array('name' => 'DESCRIPTION','content' => $description);
	$template_data['global_merge_vars'][] = array('name' => 'LOGINURL','content' => $loginurl);
	$template_data['global_merge_vars'][] = array('name' => 'IMG','content' => $img);
	return $template_data;

}