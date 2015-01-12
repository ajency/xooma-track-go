<?php
/**
 * ajency-workflow
 *
 * A simple workflow management plugin for wordpress
 *
 * @package   ajency-workflow
 * @author    Team Ajency <team@ajency.in>
 * @license   GPL-2.0+
 * @link      http://ajency.in
 * @copyright 12-13-2014 Ajency.in
 *
 * @wp-plugin
 * Plugin Name: ajency-workflow
 * Plugin URI:  http://ajency.in
 * Description: A simple workflow management plugin for wordpress
 * Version:     0.1.0
 * Author:      Team Ajency
 * Author URI:  http://ajency.in
 * Text Domain: ajency-workflow-locale
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if (!defined("WPINC")) {
	die;
}

//load the class file for tables
require_once(plugin_dir_path(__FILE__) . "/classes/tables.class.php");

//load functions.php
require_once(plugin_dir_path(__FILE__) . "/functions/functions.php");

require_once(plugin_dir_path(__FILE__) . "ajencyWorkflow.php");


// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook(__FILE__, array("ajencyWorkflow", "activate"));
register_deactivation_hook(__FILE__, array("ajencyWorkflow", "deactivate"));



function aj_workflow() {
	return ajencyWorkflow::get_instance();
}
function aj_workflow_tables() {
	return new tables();
}
// add workflow instance to globals
$GLOBALS['aj_workflow'] = aj_workflow();
$GLOBALS['table'] = aj_workflow_tables();
