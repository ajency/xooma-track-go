<?php
// add_action( 'wp_ajax_create_product', 'ajax_call_create_product' );

// add_action( 'wp_ajax_update_product', 'ajax_call_update_product' );

// function ajax_call_create_product(){

// 		global $product;

// 		$product = new Product();

// 		$data = array();
// 		$data['name'] 						= $_REQUEST['name'];
// 		$data['active'] 					= $_REQUEST['active'];
// 		$data['short_desc'] 				= $_REQUEST['short_desc'];
// 		$data['product_type'] 				= $_REQUEST['product_type'];
// 		$data['frequency'] 					= $_REQUEST['frequency'];
// 		$data['serving_per_day_anytime'] 	= $_REQUEST['serving_per_day_anytime'];
// 		$data['serving_per_day_scheduled'] 	= $_REQUEST['serving_per_day_scheduled'];
// 		$data['when'] 						= $_REQUEST['when'];
// 		$data['serving_size'] 				= $_REQUEST['serving_size'];
// 		$data['serving_per_container'] 		= $_REQUEST['serving_per_container'];
// 		$data['attachment_id'] 				= $_REQUEST['attachment_id'];
// 		$data['active'] 					= $_REQUEST['active'];
// 		$response = $product->create_product($data);
// }

// function ajax_call_update_product(){

// 		global $product;

// 		$product = new Product();

// 		$data = array();
// 		$data['id'] 						= $_REQUEST['id'];
// 		$data['name'] 						= $_REQUEST['name'];
// 		$data['active'] 					= $_REQUEST['active'];
// 		$data['short_desc'] 				= $_REQUEST['short_desc'];
// 		$data['product_type'] 				= $_REQUEST['product_type'];
// 		$data['frequency'] 					= $_REQUEST['frequency'];
// 		$data['serving_per_day_anytime'] 	= $_REQUEST['serving_per_day_anytime'];
// 		$data['serving_per_day_scheduled'] 	= $_REQUEST['serving_per_day_scheduled'];
// 		$data['when'] 						= $_REQUEST['when'];
// 		$data['serving_size'] 				= $_REQUEST['serving_size'];
// 		$data['serving_per_container'] 		= $_REQUEST['serving_per_container'];
// 		$data['attachment_id'] 				= $_REQUEST['attachment_id'];
// 		$data['active'] 					= $_REQUEST['active'];
// 		$response = $product->update_product($data);
// }

class Product
{
	public function create_product($args) 
	{
		

		#wordpress function to create a term/product

		$term = wp_insert_term($args['name'],'category',array(
        		'description' => $args['short_desc'],
                'slug' => $args['name']
            ));
		
		#check if insert was successful
		if(is_array($term))
		{
			#add custom fields to the term
			add_term_meta($term['term_id'], 'product_type',$args['product_type']);
			add_term_meta($term['term_id'], 'frequency',$args['frequency']);
			add_term_meta($term['term_id'], 'serving_size',$args['serving_size']);
			add_term_meta($term['term_id'], 'when',$args['when']);
			add_term_meta($term['term_id'], 'serving_per_container',$args['serving_per_container']);
			#for storing anytime/settime and if set time then at what is the time
			$time_set = !empty($args['serving_per_day_anytime']) ?  $args['serving_per_day_anytime'] :  
						$args['serving_per_day_scheduled'];
			add_term_meta($term['term_id'], 'time_set',$time_set);
			#total is calculated and set
			$total  = intval($args['serving_size']) * intval($args['serving_per_container']);
			#set the attachment id
			add_term_meta($term['term_id'], 'attachment_id',$args['attachment_id']);
			add_term_meta($term['term_id'], 'modified_date',date('y-m-d'));
			add_term_meta($term['term_id'], 'active',$args['active']);
			


			$response =  array('stauts' => 201 ,'response' => $term);
			
		} 
		else
		{
			$response =  new WP_Error( 'json_taxonomy_term_not_created', __( 'Xooma Product not created.' ), array( 'status' => 500 ) );
		}
		
		return $response;



	}

	public function update_product($args) 
	{
		

		#wordpress function to update a term/product
		$term = wp_update_term($args['id'],'category',array(
				'name' => $args['name'],
        		'description' => $args['short_desc']
            ));

		#check if insert was successful
		if(is_array($term))
		{
			#update custom fields to the term
			update_term_meta($term['term_id'], 'product_type',$args['product_type']);
			update_term_meta($term['term_id'], 'frequency',$args['frequency']);
			update_term_meta($term['term_id'], 'serving_size',$args['serving_size']);
			update_term_meta($term['term_id'], 'when',$args['when']);
			update_term_meta($term['term_id'], 'serving_per_container',$args['serving_per_container']);
			#for storing anytime/settime and if set time then at what is the time
			$time_set = !empty($args['serving_per_day_anytime']) ?  $args['serving_per_day_anytime'] :  
						$args['serving_per_day_scheduled'];
			update_term_meta($term['term_id'], 'time_set',$time_set);
			#total is calculated and set
			$total  = intval($args['serving_size']) * intval($args['serving_per_container']);
			#set the attachment id
			update_term_meta($term['term_id'], 'attachment_id',$args['attachment_id']);
			update_term_meta($term['term_id'], 'modified_date',date('y-m-d'));
			update_term_meta($term['term_id'], 'active',$args['active']);
			

			return $term;
			
			
		} 
		else
		{
			return new WP_Error( 'json_taxonomy_term_not_updated', __( 'Xooma Product not updated.' ), array( 'status' => 500 ) );

		}
		
		



	}





}

