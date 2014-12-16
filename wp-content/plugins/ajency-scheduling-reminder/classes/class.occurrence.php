<?php

namespace ajency;

/**
 * The Schedule class
 */
class Occurrence{

	/**
	 * [add description]
	 * @param [type] $occurrence_data [description]
	 */
	public static function add($occurrence_data){

		if(!current_user_can('edit_occurrence'))
			return new WP_Error('no_permission', __('Sorry, You don\'t have enough permission'));

		$id = occurrence::_insert_occurrence($occurrence_data);

		return $id;
	}

	/**
	 * [_insert_occurrence description]
	 * @param  [type] $occurrence_data [description]
	 * @return [type]                 [description]
	 */
	public static function _insert_occurrence($occurrence_data){
		global $wpdb;

		$user_id = get_current_user_id();

		$defaults = array(
					'schedule_id' => 0,
					'occurrence' => false,
					'meta_value' => array()
				);

		$occurrence_args = wp_parse_args($occurrence_data, $defaults);

		if(empty($occurrence_args['schedule_id']))
			return new WP_Error('schedule_id_param_missing', __('schedule_id cannot be empty'));

		if(empty($occurrence_args['occurrence']))
			return new WP_Error('occurrence', __('occurrence must be a valid date time'));

		$table_name = "{$wpdb->prefix}aj_occurrence_meta";
		$record = $occurrence_args;

		$record['meta_value'] = maybe_serialize($record['meta_value']);

		$wpdb->insert($table_name, $record);

		$occurrence_id = $wpdb->insert_id;

		$occurrence_args['meta_id'] = $occurrence_id;

		do_action('aj_insert_occurrence', $occurrence_id, $occurrence_args);

		return $occurrence_id;
	}

	/**
	 * [get description]
	 * @param  [type] $occurrence_id [description]
	 * @return [type]               [description]
	 */
	public static function get($occurrence_id){
		global $wpdb;

		$table_name = "{$wpdb->prefix}aj_occurrence_meta";

		$query = $wpdb->prepare("SELECT * FROM $table_name WHERE meta_id=%d", $occurrence_id);

		$occurrence = $wpdb->get_row($query);

		if($occurrence === null)
			return WP_Error('invalid_schedule_id', __('Invalid occurrence ID'));

		$occurrence['meta_value'] = maybe_unserialize($occurrence['meta_value']);

		if(is_array($occurrence['meta_value']){
			$occurrence = array_merge($occurrence, $occurrence['meta_value']);
		}

		return apply_filters('aj_schedule_model', $occurrence);
	}

}
