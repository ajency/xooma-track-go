<?php

add_action( 'wp_ajax_import_csv', 'ajax_call_import_csv' );

add_action( 'wp_ajax_export_csv', 'ajax_call_export_csv' );


function ajax_call_import_csv(){
	$data = array();
 
if(isset($_GET['files']))
{  
	$error = false;
	$files = array();
 
	$uploaddir = './uploads/';
	foreach($_FILES as $file)
	{
		$csvJson = parseCSV($file['tmp_name']);

        $csvjsondecode = get_CSV_Content( $csvJson );

        print_r( $csvJson);
		

	}
}
else
{
	$data = array('success' => 'Form was submitted', 'formData' => $_POST);
}
 
echo json_encode($data);

}
   
function parseCSV( $filepath ) {

    // read the csv file
    $csv = new Coseva\CSV( $filepath );

    // parse the csv
    $csv->parse();

    //Convert parsed csv data to a json string
    $csvJson = $csv->toJSON();

    return $csvJson;
}
function get_CSV_Content( $csvJson ) {

 //    global $wpdb;

 //    $csvData = json_decode( $csvJson );
 //    $i       = 0;

 //    while ( $i < count( $csvData ) ) {
 //        //Take the email_id as $csvEmailId from the ith row
 //        $csvName           		= $csvData[ $i ][ 0 ];
 //        $csvProductType        	= $csvData[ $i ][ 1 ];
 //        $csvFrequency          	= $csvData[ $i ][ 2 ];
 //        $csvModifiedDate  		= $csvData[ $i ][ 3 ];
 //        $csvActive  			= $csvData[ $i ][ 4 ];


 //        $term = wp_insert_term($csvName,'products',array(
 //        		'description' => '',
 //                'slug' => $csvName
 //            ));
		
	// 	#check if insert was successful
	// 	if(is_array($term))
	// 	{
	// 		#add custom fields to the term
	// 		add_term_meta($term['term_id'], 'product_type',$csvProductType);
	// 		add_term_meta($term['term_id'], 'frequency',$csvFrequency);
	// 		// add_term_meta($term['term_id'], 'serving_size',$args['serving_size']);
	// 		// add_term_meta($term['term_id'], 'when',$args['when']);
	// 		// add_term_meta($term['term_id'], 'serving_per_container',$args['serving_per_container']);
	// 		// #for storing anytime/settime and if set time then at what is the time
	// 		// $time_set = !empty($args['serving_per_day_anytime']) ?  $args['serving_per_day_anytime'] :  
	// 		// 			$args['serving_per_day_scheduled'];
	// 		// add_term_meta($term['term_id'], 'time_set',$time_set);
	// 		// #total is calculated and set
	// 		// $total  = intval($args['serving_size']) * intval($args['serving_per_container']);
	// 		// #set the attachment id
	// 		// add_term_meta($term['term_id'], 'attachment_id',$args['attachment_id']);
	// 		add_term_meta($term['term_id'], 'modified_date',$csvModifiedDate);
	// 		add_term_meta($term['term_id'], 'active',$csvActive);
        
 //        $i++;

	// }

}

function ajax_call_export_csv(){

	global $product_list;

	$product_list = new ProductList();

	$response = $product_list->get_products($term_id="");

	$output = "";
	$filename = "products.csv";
	$fp  = fopen($filename, 'w');
	$products = array();
	foreach($response as $value){
		$products[] = array(

			'name'  				=> $value['name'],
			'product_type_name'  	=> $value['product_type_name'],
			'frequency'				=> $value['frequency'],  
			'modified_date'			=> $value['modified_date'],
			'active'				=> $value['active']

			);

	}
	
	foreach ($products as $value) {
		fputcsv($fp, $value);
		

		
		
	}
	fclose($fp);
	// Download the file

	header("Content-Disposition: attachment; filename=$filename");
	header("Content-Length: " . filesize($filename));
	header("Content-Type: application/octet-stream;");
	readfile($filename);
	exit();


}