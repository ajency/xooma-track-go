<?php
/**
 * ajency-workflow
 *
 * @package   ajency-workflow
 * @author    Team Ajency <team@ajency.in>
 * @license   GPL-2.0+
 * @link      http://ajency.in
 * @copyright 12-13-2014 Ajency.in
 */

/**
 * ajency-workflow class.
 *
 * @package ajencyWorkflow
 * @author  Team Ajency <team@ajency.in>
 */

//#_TODO: Please maintain proper indentation and formatiing for code.

class ajencyWorkflow{
	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   0.1.0
	 *
	 * @var     string
	 */
	protected $version = "0.1.0";

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    0.1.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = "ajency-workflow";

	/**
	 * Instance of this class.
	 *
	 * @since    0.1.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    0.1.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     0.1.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action("init", array($this, "load_plugin_textdomain"));

		// Add the options page and menu item.
		add_action("admin_menu", array($this, "add_plugin_admin_menu"));

		// Load admin style sheet and JavaScript.
		add_action("admin_enqueue_scripts", array($this, "enqueue_admin_styles"));
		add_action("admin_enqueue_scripts", array($this, "enqueue_admin_scripts"));

		// Load public-facing style sheet and JavaScript.
		add_action("wp_enqueue_scripts", array($this, "enqueue_styles"));
		add_action("wp_enqueue_scripts", array($this, "enqueue_scripts"));

		// Define custom functionality. Read more about actions and filters: http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		add_action("TODO", array($this, "action_method_name"));
		add_filter("TODO", array($this, "filter_method_name"));

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     0.1.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn"t been set, set it now.
		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    0.1.0
	 *
	 * @param    boolean $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate($network_wide) {
		//#_TODO: globals for everything is a bad idea. Initialize the table class here and run the function
		global $table;

		$table->create_tables();


	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    0.1.0
	 *
	 * @param    boolean $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate($network_wide) {
		// TODO: Define deactivation functionality here


	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters("plugin_locale", get_locale(), $domain);

		load_textdomain($domain, WP_LANG_DIR . "/" . $domain . "/" . $domain . "-" . $locale . ".mo");
		load_plugin_textdomain($domain, false, dirname(plugin_basename(__FILE__)) . "/lang/");
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     0.1.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if (!isset($this->plugin_screen_hook_suffix)) {
			return;
		}

		$screen = get_current_screen();
		if ($screen->id == $this->plugin_screen_hook_suffix) {
			wp_enqueue_style($this->plugin_slug . "-admin-styles", plugins_url("css/admin.css", __FILE__), array(),
				$this->version);
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     0.1.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if (!isset($this->plugin_screen_hook_suffix)) {
			return;
		}

		$screen = get_current_screen();
		if ($screen->id == $this->plugin_screen_hook_suffix) {
			wp_enqueue_script($this->plugin_slug . "-admin-script", plugins_url("js/ajency-workflow-admin.js", __FILE__),
				array("jquery"), $this->version);
		}

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style($this->plugin_slug . "-plugin-styles", plugins_url("css/public.css", __FILE__), array(),
			$this->version);
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script($this->plugin_slug . "-plugin-script", plugins_url("js/public.js", __FILE__), array("jquery"),
			$this->version);
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    0.1.0
	 */
	public function add_plugin_admin_menu() {
		$this->plugin_screen_hook_suffix = add_plugins_page(__("ajency-workflow - Administration", $this->plugin_slug),
			__("ajency-workflow", $this->plugin_slug), "read", $this->plugin_slug, array($this, "display_plugin_admin_page"));
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    0.1.0
	 */
	public function display_plugin_admin_page() {
		include_once("views/admin.php");
	}

	/**
	 * NOTE:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *        WordPress Actions: http://codex.wordpress.org/Plugin_API#Actions
	 *        Action Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    0.1.0
	 */
	public function action_method_name() {
		// TODO: Define your action hook callback here
	}

	/**
	 * NOTE:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *        WordPress Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *        Filter Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since    0.1.0
	 */
	public function filter_method_name() {
		// TODO: Define your filter hook callback here
	}

	public function workflow_process($workflow_name,$user_id){

		//check if param workflow is present
		if($workflow_name == null && $workflow == ""){

			return new WP_Error( 'workflow_name_missing', __( 'Workflow name parameter missing.' ), array( 'status' => 500 ) );
		}

		//fetch all the forms based on the workflow name specified

		$forms = workflow_get_forms($workflow_name);

		if(is_wp_error($forms)){

			return $forms;
		}

		$forms_array = array();

		//getting the array of all forms in a proper sequence
		foreach ($forms as $key => $value) {
			$forms_array[$value->id]  = $value->url;
		}

		foreach ($forms_array as $key => $value) {
			//check if entry is present in workflow_user table
			$workflow_user_id = workflow_check_user($key,$user_id);

			if(is_null($workflow_user_id)){

				$workflow_user_id = workflow_insert_user($key,$user_id);

			}
			else{
				//check for the status
				$workflow_user_status = $workflow_user_id->status;

				$status = workflow_get_status($workflow_user_id->form_id);

				if($workflow_user_status == $status['default']){
					return $value;
					exit();
				}
				else{

					continue;
				}
			}




		}





	}

	public function workflow_insert_main($args,$status){

		global $wpdb;
		$workflow_tbl = $wpdb->prefix."workflow";
		$workflow_name = $args['name'];

		//#_TODO: use $wpdb->prepare()
		$sql_query = $wpdb->get_row("SELECT * FROM $workflow_tbl WHERE workflow_name LIKE '%$workflow_name%'");



		//insert into workflow user table
		if(is_null($sql_query)){
			$insert_id = $wpdb->insert(
				$workflow_tbl,
				array(
					'workflow_name'		=> $args['name'],
					'status'			=> serialize($status) //#_TODO: use maybe_serialize()
				),
				array(
					'%s',
					'%s'
				)
			);

			if($insert_id){

				return array('status' => 200 , 'response' => $insert_id); //#_TODO: status is not part of response. It mus tbe part of response header
			}
			else{

				return new WP_Error( 'Workflow_user_not_inserted', __( 'User Worklfow not inserted.' ), array( 'status' => 500 ) );

			}
		}


	}

	//plugin function to save the workflow for a user
	public function workflow_update_user($user_id,$form){

		global $wpdb;
		$workflow_user_tbl = $wpdb->prefix."workflow_user";

		//get form id based on status
		$form_id = workflow_form_id($form);

		//get workflow completion status
		$status = workflow_get_status($form_id);

		$update_id = $wpdb->update(
			$workflow_user_tbl,
			array(
				'status' => $status['complete']
			),
			array( 'user_id' => $user_id,
			       'form_id' => $form_id
			),
			array(
				'%s'
			),
			array( '%d',
				   '%d'
			)
		);

		if($update_id === false){

			return new WP_Error( 'Workflow_user_not_updated', __( 'User Worklfow not updated.' ), array( 'status' => 500 ) );

		}
		else{

			return array('status' => 200 , 'response' => $updated_id);
		}




	}


	public function workflow_needed($user_id){

		//fetch all the forms based on the workflow name specified

		global $wpdb;

		global $aj_workflow;

		$workflow_user_tbl = $wpdb->prefix."workflow_user";

		//#_TODO: use $wpdb->prepare() to generate queries
		$sqlquery = $wpdb->get_results("SELECT * FROM $workflow_user_tbl WHERE user_id=".$user_id);

		if(count($sqlquery) ==0 ){

			$aj_workflow->workflow_process('login',$user_id);
		}
		$forms = workflow_get_forms($workflow_name);

		if(is_wp_error($forms)){

			return $forms;
		}

		$forms_array = array();
		$flag = 0;
		//getting the array of all forms in a proper sequence
		foreach ($forms as $key => $value) {
			$form_id = $value->id;
			//#_TODO: use $wpdb->prepare() to generate queries
			$sql_query = $wpdb->get_row("SELECT * FROM $workflow_user_tbl WHERE form_id =".$form_id." and user_id=".$user_id);
			if(!(is_null($sql_query)))
			{
				//get workflow completion status
				$status = workflow_get_status($sql_query->form_id);

				if(($status['complete']) == $sql_query->status){

					$flag = '/home';

				}
				else
				{
					$flag = $aj_workflow->workflow_process('login',$user_id);
					return $flag;
					exit(); //#_TODO: Code will never reach here. Why is this needed?

				}

			}


			return $flag;





		}



	}

}

