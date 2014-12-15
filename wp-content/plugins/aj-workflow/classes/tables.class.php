<?php

class tables{

	public function create_tables(){

		global $wpdb;
            
        //create tables on plugin activation
        $workflow_tbl 		=  	$wpdb->prefix."workflow";
        $workflow_forms_tbl = 	$wpdb->prefix."workflow_forms";
        $workflow_user_tbl  =	$wpdb->prefix."workflow_user";

        $workflow_sql = "CREATE TABLE IF NOT EXISTS $workflow_tbl (
                               id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,           
                               workflow_name varchar(75) NOT NULL,
                               status varchar(75) NOT NULL,
                               );";

		$workflow_forms_sql = "CREATE TABLE IF NOT EXISTS $workflow_forms_tbl (
                               id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,  
                               workflow_id int(100) NOT NULL,       
                               form_name varchar(75) NOT NULL,
                               sequence int(50) NOT NULL,
                               );";

		$workflow_user_sql = "CREATE TABLE IF NOT EXISTS $workflow_user_tbl (
                               id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,  
                               form_id int(100) NOT NULL,  
                               user_id int(200) NOT NULL,       
                               status varchar(75) NOT NULL
                               );";

		
		//reference to upgrade.php file
        //uses WP dbDelta function inorder to handle addition of new table columns 
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
        dbDelta($workflow_sql);
        dbDelta($workflow_forms_sql);
        dbDelta($workflow_user_sql);

	}

	public function delete_tables() {
	
	    global $wpdb;  
	        
		$sql = "DROP TABLE ". $wpdb->prefix."workflow";
		$wpdb->query($sql);
	        
		$sql = "DROP TABLE ". $wpdb->prefix."workflow_forms";
		$wpdb->query($sql);
	        
		$sql = "DROP TABLE ". $wpdb->prefix."workflow_user";
		$wpdb->query($sql);
        
	
	}
}