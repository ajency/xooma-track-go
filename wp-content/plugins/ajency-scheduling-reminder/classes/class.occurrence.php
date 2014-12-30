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
	public static function get_expected_occurrences($schedule_id, $start_dt, $end_dt = false){

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

		return $r->occurrences;
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

		$query = $wpdb->prepare("SELECT * FROM $table_name
								WHERE schedule_id=%d
								AND occurrence BETWEEN %s AND %s
								ORDER BY occurrence ASC", $schedule_id, $start_dt, $end_dt);

		$results = $wpdb->get_results($query);

		$occurrences = $results;

		$arr = array();

		//#_TODO: Move these functions out of this function
		

		if(count($expected_occurrences) >= count($occurrences)){
			$arr = merge_occurrences_into_expected($expected_occurrences, $occurrences, $schedule_id);
		}else{
			$arr = merge_expected_into_occurrences($expected_occurrences, $occurrences, $schedule_id);
		}

		// wp_send_json($arr );

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
					'meta_value' => array()
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
}

function merge_occurrences_into_expected($exp_occ, $occ, $s_id){
			$data = array();
			for($i =0, $len = count($exp_occ); $i < $len; $i++) {
				$occurrence = null;
				if(isset($occ[$i])){
					$occurrence = $occ[$i];
					$occurrence->meta_value = maybe_unserialize( $occ[$i]->meta_value );
					$occurrence->expected = date('Y-m-d H:i:s', $exp_occ[$i]->getTimestamp());
				}
				else{
					$occurrence = new \stdClass;
					$occurrence->meta_value = array();
					$occurrence->schedule_id = $s_id;
					$occurrence->expected = date('Y-m-d H:i:s', $exp_occ[$i]->getTimestamp());
				}
				$data[] = $occurrence;
			}
			return $data;
		}

		function merge_expected_into_occurrences($exp_occ, $occ, $s_id){
			$data = array();
			for($i =0, $len = count($occ); $i < $len; $i++) {
				$occurrence = null;
				if(isset($exp_occ[$i])){
					$occurrence = $occ[$i];
					$occurrence->meta_value = maybe_unserialize( $occ[$i]->meta_value );
					$occurrence->expected = date('Y-m-d H:i:s', $exp_occ[$i]->getTimestamp());
				}
				else{
					$occurrence = new \stdClass;
					$occurrence->meta_value = maybe_unserialize( $occ[$i]->meta_value );
					$occurrence->occurrence = $occ[$i]->occurrence;
					$occurrence->schedule_id = $s_id;
				}
				$data[] = $occurrence;
			}
			return $data;
		}

