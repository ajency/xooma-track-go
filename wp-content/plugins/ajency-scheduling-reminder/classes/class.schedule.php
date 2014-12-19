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

		if(!current_user_can('edit_schedule'))
			return new \WP_Error('no_permission', __('Sorry, You don\'t have enough permission'));

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
	 * [get description]
	 * @param  [type] $schedule_id [description]
	 * @return [type]              [description]
	 */
	static function get_schedules($user_id){
		global $wpdb;

		$table_name = "{$wpdb->prefix}aj_schedules";

		$query = $wpdb->prepare("SELECT * FROM $table_name WHERE user_id=%d", $user_id);

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
					'rrule' => '',
				);

		$schedule_args = wp_parse_args($schedule_data, $defaults);

		if(empty($schedule_args['action']))
			return new WP_Error('action_param_missing', __('Action is empty'));

		if(empty($schedule_args['rrule']))
			return new WP_Error('rrule_param_missing', __('RRule is empty. Provide occurence rule'));

		$table_name = "{$wpdb->prefix}aj_schedules";

		$record = $schedule_args;

		$wpdb->insert($table_name, $record);

		$schedule_id = $wpdb->insert_id;

		$schedule_args['id'] = $schedule_id;

		do_action('aj_insert_schedule', $schedule_id, $schedule_args);

		return $schedule_id;

	}
}
















