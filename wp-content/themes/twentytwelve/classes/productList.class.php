<?php
// add_action( 'wp_ajax_get_products', 'ajax_call_get_products' );

// function ajax_call_get_products(){

// 		global $product_list;

// 		$product_list = new ProductList();

// 		$term_id = ($_REQUEST['term_id'] != 0) ? $_REQUEST['term_id'] :  "" ;


// 		$response = $product_list->get_products($term_id);
//     	wp_send_json($response);
// }

class ProductList
{
	public function get_products($term_id){

		//TODO: remove dummy response



		global $wpdb;

    	$product_type_table = $wpdb->prefix . "defaults";
    	$product_type_option = "";

		#get all the terms/products


    	// get the product category id
		$product_id = get_category_by_slug('product');
		$term = get_categories('parent='.$product_id->term_id.'&hide_empty=0');


		#check if term_id is blank
		if(isset($term_id) && $term_id !="")
		{
			$terms_array = array();
			$terms_array = get_term_by( 'id', $term_id, 'category');
			$term = array();
			$term[0] = $terms_array;
			// form a dropdown for product type
	    	global $wpdb;
		    $product_type_table = $wpdb->prefix . "defaults";
		    #get the values from product_type table
		    $product_types = $wpdb->get_results( "SELECT * FROM $product_type_table where type='product_type'");
		    foreach ( $product_types as $product_type )
		    {
		    	$selected = get_term_meta($terms_array->term_id, 'product_type', true) == $product_type->id ? 'selected': "";

		        $product_type_option .= "<option value='".$product_type->id."' ".$selected.">".$product_type->value."</option>";
		    }




		}

		$terms_array = array();

		#term data in an array
		foreach ($term as $term_data) {
			$single = true;
			get_term_meta($term_data->term_id, 'attachment_id', $single);
			$attachment_id = get_term_meta($term_data->term_id, 'attachment_id', $single);
			$images = wp_get_attachment_image_src( $attachment_id );
    		$image = is_array( $images ) && count( $images ) > 1 ? $images[ 0 ] : get_template_directory_uri() .
        	'/img/placeholder.jpg';
        	$product_type_name= "";
        	if(get_term_meta($term_data->term_id, 'product_type', true) !="" && get_term_meta($term_data->term_id, 'product_type', true) != null)
        		{
        			$product_type = $wpdb->get_row("SELECT * FROM $product_type_table WHERE id =".get_term_meta($term_data->term_id, 'product_type', true)." and type='product_type'");
        			$product_type_name  = $product_type->value;
        		}
        	$frequency = (get_term_meta($term_data->term_id, 'frequency', true) == 1) ? 'Anytime' : 'Scheduled';
        	$active = (get_term_meta($term_data->term_id, 'active', true) == 1) ? 'Yes' : 'No';
        	#total is calculated and set
        	$size_original = 0;
	        $size_new = 0;
        	if(get_term_meta($term_data->term_id, 'serving_size', true) !="" && get_term_meta($term_data->term_id, 'serving_size', true) != null)
        		{
        			$size = explode('|', get_term_meta($term_data->term_id, 'serving_size', true));
	        		$size_original = $size[0];
	        		$size_new = $size[1];
	        	}
			$total  = (intval($size_original) + intval($size_new)) *
					intval(get_term_meta($term_data->term_id, 'serving_per_container', true));
			$terms_array[] =array(
				'id'        			=> $term_data->term_id,
				'name'					=> $term_data->name,
				'description'			=> $term_data->description,
				'product_type_name'		=> $product_type_name,
				'frequency'				=> $frequency,
				'frequency_value'		=> get_term_meta($term_data->term_id, 'frequency', true),
				'serving_size'			=> get_term_meta($term_data->term_id, 'serving_size', true),
				'when'					=> get_term_meta($term_data->term_id, 'when', true),
				'serving_per_container'	=> get_term_meta($term_data->term_id, 'serving_per_container', true),
				'time_set'				=> get_term_meta($term_data->term_id, 'time_set', true),
				'attachment_id'			=> get_term_meta($term_data->term_id, 'attachment_id', true),
				'image'					=> $image,
				'modified_date'			=> get_term_meta($term_data->term_id, 'modified_date', true),
				'active'				=> $active,
				'active_value'			=> get_term_meta($term_data->term_id, 'active', true),
				'total'					=> $total,
				'product_type'			=> $product_type_option,
				'total_products'		=> count($term),
				'bmi'					=> get_term_meta($term_data->term_id, 'BMI', true)

				);
		}
		if($terms_array){

			return $terms_array;
		}
		else
		{

			new WP_Error( 'json_taxonomy_terms_not_found', __( 'Xooma Products not found.' ));
		

			
		}



	}
}
