<?php

namespace ajency\ScheduleReminder;

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
			return new \WP_Error('no_permission', __('Sorry, You don\'t have enough permission'));

		$id = self::_insert_occurrence($occurrence_data);

		return $id;
	}

	/**
	 * [get_expected_occurrences description]
	 * @param  [type] $schedule_id [description]
	 * @param  [type] $start_dt    [description]
	 * @return [type]              [description]
	 */
	public static function get_expected_occurrences($schedule_id, $start_dt, $end_dt){

		global $wpdb;

		if($end_dt === false)
			$end_dt = $start_dt;

		$table_name = "{$wpdb->prefix}aj_occurrence_meta";

		$schedule = Schedule::get($schedule_id);

		$rrule = $schedule['rrule'];

		$r = new \When\When();
		$r->startDate(new \DateTime($start_dt))
		  ->until(new \DateTime($end_dt))
		  ->rrule($rrule)
		  ->generateOccurrences();

		$grouped_expected_occurrences = array();
		foreach ($r->occurrences as $occurrence) {
			$date = date('Y-m-d', $occurrence->getTimestamp());
			$dateTime = date('Y-m-d H:i:s', $occurrence->getTimestamp());
			$grouped_expected_occurrences[$date][] = array(
										'expected' => $dateTime,
										'schedule_id' => $schedule_id,
										'meta_value' => array()
									);
		}

		return $grouped_expected_occurrences;
	}

	/**
	 * [get_expected_occurrences description]
	 * @param  [type] $schedule_id [description]
	 * @param  [type] $start_dt    [description]
	 * @return [type]              [description]
	 */
	public static function get_occurrences($schedule_id, $start_dt, $end_dt){

		$expected_occurrences = Occurrence::get_expected_occurrences($schedule_id, $start_dt, $end_dt);
		
		global $wpdb;

		$table_name = "{$wpdb->prefix}aj_occurrence_meta";

		$query = $wpdb->prepare("SELECT * FROM $table_name WHERE schedule_id=%d AND (occurrence BETWEEN %s AND %s) ORDER BY occurrence ASC", $schedule_id, $start_dt, $end_dt);

		$results = $wpdb->get_results($query);

		$occurrences = $results;

		$grouped_occurrences = array();
		foreach ($occurrences as $occurrence) {
			$occurrence->meta_value = maybe_unserialize($occurrence->meta_value);
			$grouped_occurrences[date('Y-m-d', strtotime($occurrence->occurrence))][] = $occurrence;
		}
		
		$arr = array();
		foreach ($expected_occurrences as $date => $occurrences) {
			$i = 0;
			$arr1 = array();
			$arr2 = array();

			if(!isset($grouped_occurrences[$date]))
				$grouped_occurrences[$date] = array();

			if(count($grouped_occurrences[$date]) >= count($occurrences)){
			 	$arr1 = $grouped_occurrences[$date];
			 	$arr2 = $expected_occurrences[$date];
			}
			else{
				$arr1 = $expected_occurrences[$date];
				$arr2 = $grouped_occurrences[$date];
			}

			foreach ($arr1 as $occ) {
				if(isset($arr2[$i]))	
					$arr[] = array_merge((array)$occ, (array)$arr2[$i]);
				else
					$arr[] = array_merge((array)$occ, array());
				$i++;
			}
			
		}

		return $arr;
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
					'meta_value' => array(),
					'meta_id'    => 0
				);

		$occurrence_args = wp_parse_args($occurrence_data, $defaults);

		if(empty($occurrence_args['schedule_id']))
			return new \WP_Error('schedule_id_param_missing', __('schedule_id cannot be empty'));

		if(empty($occurrence_args['occurrence']))
			return new \WP_Error('occurrence', __('occurrence must be a valid date time'));

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

		$occurrence = (array)$wpdb->get_row($query);

		if($occurrence === null)
			return new \WP_Error('invalid_schedule_id', __('Invalid occurrence ID'));

		$occurrence['meta_value'] = maybe_unserialize($occurrence['meta_value']);

		if(is_array($occurrence['meta_value'])){
			$occurrence = array_merge($occurrence, $occurrence['meta_value']);
		}

		return apply_filters('aj_occurrence_model', $occurrence);
	}

	/**
	 * Returns the latest upcoming events and updates the next expected occurence
	 */ 
	public static function get_upcoming_occurrences($object_type, $end_dt,  $start_dt = '', $object_id = 0){

		global $wpdb;

		$table_name = "{$wpdb->prefix}aj_schedules";

		$object_id_query = '';

		if($object_id !== 0)
			$object_id_query = $wpdb->prepare(' AND object_id=%d', $object_id);

		if($start_dt === ''){
			$start_dt = current_time('mysql');
		}

		if(strtotime($start_dt) > strtotime($end_dt) )
			return new \WP_Error('invalid_start_end_date_time', __('Invalid start and end date time'));

		$query = $wpdb->prepare("SELECT * FROM $table_name 
								 WHERE object_type=%s $object_id_query 
								 AND next_occurrence BETWEEN %s AND %s", $object_type, $start_dt, $end_dt);

		$schedules = (array)$wpdb->get_results($query);

		foreach ($schedules as $schedule) {
			$next_occurrence = \ajency\ScheduleReminder\Schedule::update_next_occurrence($schedule);
			$schedule->next_occurrence = $next_occurrence;
		}

		do_action('aj_upcoming_occurrences', $schedules);

		return $schedules;
		
	}


	public static function _update_occurrence($occurrence_data){
		global $wpdb;

		$user_id = get_current_user_id();

		$defaults = array(
					'schedule_id' => 0,
					'occurrence' => false,
					'meta_value' => array(),
					'meta_id'    => 0
				);

		$occurrence_args = wp_parse_args($occurrence_data, $defaults);

		if(empty($occurrence_args['schedule_id']))
			return new \WP_Error('schedule_id_param_missing', __('schedule_id cannot be empty'));

		if(empty($occurrence_args['occurrence']))
			return new \WP_Error('occurrence', __('occurrence must be a valid date time'));

		$table_name = "{$wpdb->prefix}aj_occurrence_meta";
		$record = $occurrence_args;

		$record['meta_value'] = maybe_serialize($record['meta_value']);

		echo "UPDATE $table_name SET occurrence='".date('Y-m-d H:i:s')."'

			and meta_value='".$record['meta_value']."' where meta_id=".$record['meta_id'];

		$sql_query = $wpdb->query("UPDATE $table_name SET occurrence='".date('Y-m-d H:i:s')."'

			and meta_value='".$record['meta_value']."' where meta_id=".$record['meta_id']);


		

		return $record['meta_id'];


	}
}

