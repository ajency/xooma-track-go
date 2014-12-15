<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   ajency-workflow
 * @author    Team Ajency <team@ajency.in>
 * @license   GPL-2.0+
 * @link      http://ajency.in
 * @copyright 12-13-2014 Ajency.in
 */

// If uninstall, not called from WordPress, then exit
if (!defined("WP_UNINSTALL_PLUGIN")) {
	exit;
}

// TODO: Define uninstall functionality here

/**
 * Delete database tables
 */
	
	global $table;

	$table = new tables();
	$table->delete_tables();