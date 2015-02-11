<?php


class Product
{
	public function create_product($args) 
	{
		
		// get the product category id
		$product_id = get_category_by_slug('product');
		
		#wordpress function to create a term/product
		$term = wp_insert_term(urldecode($args['name']),'category',array(
        		'description' => urldecode($args['short_desc']),
                'slug' =>urldecode($args['name']),
                'parent'=> $product_id->term_id
            ));
		
		#check if insert was successful
		if(!(is_wp_error($term)))
		{
			#add custom fields to the term
			add_term_meta($term['term_id'], 'product_type',$args['product_type']);
			add_term_meta($term['term_id'], 'frequency',$args['frequency']);
			$clone_serving = isset($args['serving_size_clone']) ? $args['serving_size_clone'] : 0 ;
			$clone_when = isset($args['when_clone']) ? $args['when_clone'] : 0 ;
			add_term_meta($term['term_id'], 'serving_size',$args['serving_size'].'|'.$clone_serving);
			add_term_meta($term['term_id'], 'when',$args['when'].'|'.$clone_when );
			add_term_meta($term['term_id'], 'serving_per_container',$args['serving_per_container']);
			#for storing anytime/settime and if set time then at what is the time
			$time_set = !empty($args['serving_per_day_anytime']) ?  $args['serving_per_day_anytime'] :  
						$args['serving_per_day_scheduled'];
			add_term_meta($term['term_id'], 'time_set',$time_set);
			#total is calculated and set
			$total  = (intval($args['serving_size']) + intval($clone_serving)) * intval($args['serving_per_container']);
			#set the attachment id
			add_term_meta($term['term_id'], 'attachment_id',$args['attachment_id']);
			add_term_meta($term['term_id'], 'modified_date',date('y-m-d'));
			add_term_meta($term['term_id'], 'active',$args['active']);
			add_term_meta($term['term_id'], 'BMI',$args['bmi']);
			

			notifications_add_product($term['term_id'],urldecode($args['name']),urldecode($args['short_desc']));
			$response =  array('status' => 201 ,'response' => $term);
			
		} 
		else
		{
			$response =  new WP_Error( 'json_taxonomy_term_not_created', __( 'Xooma Product not created.' ), array( 'status' => 500 ) );
		}
		
		return $response;



	}

	public function update_product($args) 
	{
		// get the product category id
		$product_id = get_category_by_slug('product');

		
		#wordpress function to update a term/product
		$term = wp_update_term($args['id'],'category',array(
				'name' => urldecode($args['name']),
        		'description' =>urldecode($args['short_desc']),
                'parent'=> $product_id->term_id
            ));
		
		#check if insert was successful
		if(!(is_wp_error($term)))
		{
			#update custom fields to the term
			update_term_meta($term['term_id'], 'product_type',$args['product_type']);
			update_term_meta($term['term_id'], 'frequency',$args['frequency']);
			$clone_serving = isset($args['serving_size_clone']) ? $args['serving_size_clone'] : 0 ;
			$clone_when = isset($args['when_clone']) ? $args['when_clone'] : 0 ;
			
			update_term_meta($term['term_id'], 'serving_size',$args['serving_size'].'|'.$clone_serving);
			update_term_meta($term['term_id'], 'when',$args['when'].'|'.$clone_when);
			update_term_meta($term['term_id'], 'serving_per_container',$args['serving_per_container']);
			#for storing anytime/settime and if set time then at what is the time
			$time_set = !empty($args['serving_per_day_anytime']) ?  $args['serving_per_day_anytime'] :  
						$args['serving_per_day_scheduled'];
			update_term_meta($term['term_id'], 'time_set',$time_set);
			#total is calculated and set
			$total  = (intval($args['serving_size']) + intval($clone_serving)) * intval($args['serving_per_container']);
			#set the attachment id
			update_term_meta($term['term_id'], 'attachment_id',$args['attachment_id']);
			update_term_meta($term['term_id'], 'modified_date',date('y-m-d'));
			update_term_meta($term['term_id'], 'active',$args['active']);
			delete_term_meta($term['term_id'], 'BMI',$args['bmi']);
			update_term_meta($term['term_id'], 'BMI',$args['bmi']);
			

			$response =  array('status' => 200 ,'response' => $term);

			// $t = get_term_meta($term['term_id'], 'time_set', true);
			// $s = explode('|',get_term_meta($term['term_id'], 'serving_size', true));
			// $w = explode('|',get_term_meta($term['term_id'], 'when', true));

			// if($time_set != $t || $s[0] != $args['serving_size'] || $s[1] != $clone_serving || $w[0] != $args['when'] || $w[1] != $clone_when  )
			// {
			// 	notifications_update_product($term['term_id'],$term['name'],$term['description'],$time_set);
			// }
			
			
		} 
		else
		{
			$response = new WP_Error( 'json_taxonomy_term_not_updated', __( 'Xooma Product not updated.' ), array( 'status' => 500 ) );

		}
		
		
		return $response;


	}

	





}

