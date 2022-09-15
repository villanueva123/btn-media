<?php
if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

/**
 * Frontend Ajax Functions
 *
 * @since      1.0.0
 * @package    btn-lms
 * @subpackage btn-lms/classes
 * @author     Augustus Villanueva <augustus@businesstechninjas.com>
 */
final class btn_media_ajax  {

    // Add WP Hooks
	static function add_wp_hooks(){

		// Templater Ajax
		add_action('wp_ajax_wpat_ajax', ['wp_admin_templater_ajax', 'admin_ajax']);

		add_filter('wp/admin/templater/save/btn/post/settings', ['btn_media_setting_screen','save_settings']);
		add_filter('wp/admin/templater/save/btn_media/taxonomy', ['btn_media_setting_screen','save_module_activities']);

    }
    function __construct(){}
}
