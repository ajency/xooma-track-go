<?php

namespace ajency\ScheduleReminder;

/**
 * The Schedule class
 */
class Schedule{


	/**
	 * public api function to add a schedule
	 * @param [type] $schedule_data [description]
	 */
	static function add($schedule_data){

		// if(!current_user_can('edit_schedule'))
		// 	return new \WP_Error('no_permission', __('Sorry, You don\'t have enough permission'));

		return self::_insert_schedule($schedule_data);
	}

	/**
	 * [get_schedule description]
	 * @param  [type] $schedule_id [description]
	 * @return [type]              [description]
	 */
	static function get($schedule_id){
		global $wpdb;

		$table_name = "{$wpdb->prefix}aj_schedules";

		$query = $wpdb->prepare("SELECT * FROM $table_name WHERE id=%d", $schedule_id);

		$schedule = (array)$wpdb->get_row($query);

		if($schedule === null)
			return new \WP_Error('invalid_schedule_id', __('Invalid schedule ID'));

		return apply_filters('aj_schedule_model', $schedule);
	}

	/**
	 * [get_schedule description]
	 * @param  [type] $schedule_id [description]
	 * @return [type]              [description]
	 */
	static function get_schedule_id($object_type, $object_id){
		global $wpdb;

		$table_name = "{$wpdb->prefix}aj_schedules";

		$query = $wpdb->prepare("SELECT id FROM $table_name WHERE object_type=%s AND object_id=%d", $object_type, $object_id);

		$schedule_id = $wpdb->get_var($query);

		
		if($schedule_id === NULL)
			return new \WP_Error('invalid_object_id', __('Invalid object_id and object type'));

		return intval($schedule_id);
	}


	/**
	 * [get description]
	 * @param  [type] $schedule_id [description]
	 * @return [type]              [description]
	 */
	static function get_schedules_for_object($object_id){
		global $wpdb;

		$table_name = "{$wpdb->prefix}aj_schedules";

		$query = $wpdb->prepare("SELECT * FROM $table_name WHERE object_id=%d", $object_id);

		$schedules = $wpdb->get_results($query);

		return (array) $schedules;
	}

	/**
	 * Core function to add a schedule
	 * This function will not perform any capability checks caller function needs to
	 * perform the capability check
	 * @param  [type] $schedule_data [description]
	 * @return [type]                [description]
	 */
	static function _insert_schedule($schedule_data){
		global $wpdb;

		$user_id = get_current_user_id();

		$defaults = array(
					'object_type' => '',
					'object_id' => 0,
					'start_dt' => '',
					'rrule' => '',
					'next_occurrence' => ''
				);

		$schedule_args = wp_parse_args($schedule_data, $defaults);
		
		if(empty($schedule_args['object_type']))
			return new \WP_Error('action_param_missing', __('Action is empty'));

		if(empty($schedule_args['rrule']))
			return new \WP_Error('rrule_param_missing', __('RRule is empty. Provide occurrence rule'));

		if(empty($schedule_args['start_dt']))
			return new \WP_Error('start_dt_param_missing', __('Start datetime is needed'));


		$table_name = "{$wpdb->prefix}aj_schedules";

		$record = $schedule_args;
		
		$wpdb->insert($table_name, $record);

		$schedule_id = $wpdb->insert_id;

		$schedule_args['id'] = $schedule_id;

		do_action('aj_insert_schedule', $schedule_id, $schedule_args);

		return $schedule_id;

	}

	static function update_next_occurrence($schedule){
		
		global $wpdb;

		$r = new \When\When();
		
		$start_time = explode(" ", $schedule['start_dt']);
		
		$start_dt = date('Y-m-d '. $start_time[1]);
		
		$r->startDate(new \DateTime($start_dt))
			->rrule($schedule['rrule'])
		 	->count(5)
		  	->generateOccurrences();

		$occurrences = array();
		
		foreach ( $r->occurrences as $occurrence) {
			$occurrences[] = $occurrence->getTimestamp();

		}
		
		$previous_occurrence = strtotime($schedule['next_occurrence']);

		$next_occurrence_timestamp = self::get_next_occurrence($occurrences, $previous_occurrence);
		
		$next_occurrence = date('Y-m-d H:i:s', $next_occurrence_timestamp);
		
		$table_name = "{$wpdb->prefix}aj_schedules";

		$wpdb->update($table_name, 
					  array( 'next_occurrence' => $next_occurrence ),
					  array( 'id' => $schedule['id'] ));
		
		return $next_occurrence;
	}	

	/**
	 * 
	 */
	static function get_next_occurrence($occurrences, $current_occurrence){
	    
	    //add the current_occurrence to the array
	    $occurrences[] = $current_occurrence;
	  
	    //sort and refind the current_occurrence
	    sort($occurrences);
	    $i = array_search($current_occurrence, $occurrences);
	   	
	    //check if there is a current_occurrence above it
	    if($i !== FALSE  && isset($occurrences[$i+2]))
	    	{
	    		
	    		return $occurrences[$i+2];
	    	} 
	    	

	    //alternatively you could return the current_occurrence itself here, or below it depending on your requirements
	    return false;
	}

}











