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
					'next_occurrence' => '',
					'remind_before' => 0
				);

		$schedule_args = wp_parse_args($schedule_data, $defaults);

		if(empty($schedule_args['object_type']))
			return new \WP_Error('action_param_missing', __('Action is empty'));

		if(empty($schedule_args['rrule']))
			return new \WP_Error('rrule_param_missing', __('RRule is empty. Provide occurence rule'));

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

	static function update_next_occurrence($schedule_id){
		$schedule = \ajency\ScheduleReminder\Schedule::get($schedule_id);
		$st = '';
		$r = new \When\When();
		$r->startDate(new \DateTime($schedule['start_dt']))
			->rrule($schedule['rrule'])
		 	->count(10)
		  	->generateOccurrences();
		wp_send_json($r->occurrences);
	}	
}



function find_closest($array, $date)
{
    //$count = 0;
    foreach($array as $day)
    {
        //$interval[$count] = abs(strtotime($date) - strtotime($day));
            $interval[] = abs(strtotime($date) - strtotime($day));
        //$count++;
    }

    asort($interval);
    $closest = key($interval);

    return $array[$closest];

}

add_action('init', function(){
	$dates = array(
    '0'=> "2013-02-18 05:14:54",
    '1'=> "2013-02-12 01:44:03",
    '2'=> "2013-02-05 16:25:07",
    '3'=> "2013-01-29 02:00:15",
    '4'=> "2013-01-27 18:33:45" 
);
	\ajency\ScheduleReminder\Schedule::update_next_occurrence(1);
	// \ajency\ScheduleReminder\Schedule::add(array(
	// 	'object_type' => 'user_product',
	// 	'object_id' => 23,
	// 	'start_dt' => date('Y-12-31 00:00:00'),
	// 	'rrule' => 'FREQ=HOURLY;INTERVAL=8;WKST=MO'
	// ));
	// die;
	//wp_send_json(find_closest($dates, "2013-02-18 05:14:55"));

});











