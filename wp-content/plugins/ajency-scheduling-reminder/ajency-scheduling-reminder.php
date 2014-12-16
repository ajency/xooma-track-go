<?php
/**
 * Ajency Scheduling Reminder
 *
 * A sample description
 *
 * @package   ajency-scheduling-reminder
 * @author    Team Ajency <team@ajency.in>
 * @license   GPL-2.0+
 * @link      http://ajency.in
 * @copyright 12-15-2014 Ajency.in
 *
 * @wp-plugin
 * Plugin Name: Ajency Scheduling Reminder
 * Plugin URI:  http://ajency.in
 * Description: A sample description
 * Version:     0.1.0
 * Author:      Team Ajency
 * Author URI:  http://ajency.in
 * Text Domain: ajency-scheduling-reminder-locale
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if (!defined("WPINC")) {
	die;
}

//libraries
require_once(plugin_dir_path(__FILE__). "/bower_components/When/src/When/Valid.php");
require_once(plugin_dir_path(__FILE__). "/bower_components/When/src/When/When.php");

//classes
require_once(plugin_dir_path(__FILE__) . "classes/class.schedule.php");
require_once(plugin_dir_path(__FILE__) . "classes/class.occurrence.php");

//api
require_once(plugin_dir_path(__FILE__) . "api/class.schedule.api.php");
require_once(plugin_dir_path(__FILE__) . "api/class.occurrence.api.php");

require_once(plugin_dir_path(__FILE__) . "AjencySchedulingReminder.php");

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook(__FILE__, array("AjencySchedulingReminder", "activate"));
register_deactivation_hook(__FILE__, array("AjencySchedulingReminder", "deactivate"));

AjencySchedulingReminder::get_instance();
