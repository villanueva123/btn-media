<?php
if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

/**
 * BTN POST Main Admin
 *
 * @since      1.0.0
 * @package    btn-media
 * @subpackage btn-media/classes
 * @author     Augustus Villanueva <augustus@businesstechninjas.com>
 */
final class btn_media_admin {

	// Add WP Actions / Filters
    function add_wp_hooks(){

			if (current_user_can('manage_options')) {
				// Actions
				add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts'], PHP_INT_MAX);
			}


    }


	// Enqueue Scripts and Styles
	function enqueue_scripts( $hook ){

		$enqueue_scripts = false;

		// Post Type Pages
		if( in_array($hook, $this->post_type_pages) ){
			$post_type = isset($_GET['post_type']) ? $_GET['post_type'] : false;
			if( ! $post_type ){
				$post_id = isset($_GET['post']) ? (int)$_GET['post'] : 0;
				$post_type = ( $post_id > 0 ) ? get_post_type($post_id) : false;
			}
			$enqueue_scripts = true;
		}

		// Enqueue Templater Settings
		if( $enqueue_scripts ){
			$handle = 'btn_media';
			$assets = BTN_MEDIA_ASSETS_URL;
			$url = $assets . 'js/admin.js';
			$v = BTN_MEDIA_VERSION;
			wp_register_script($handle, $url, [], $v, 'all');
			$url = $assets . 'css/admin.css';
			wp_enqueue_style($handle, $url, [], $v, 'all');
		}

	}


  function __construct(){}

  // JSON Data
	private $footer_json = [];
	// Common Text Translations for Javascript
	private $I18n = [];
	// Admin Templater
	private $templater;
	// Screen Hooks to load Templater
	private $templater_hooks = [];
	private $templater_post_types = [];
	// Comon Post Type Pages
	private $post_type_pages = ['post.php','post-new.php'];
	// Post Type Slug
	private $post_slug;

}
