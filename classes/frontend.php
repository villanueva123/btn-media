<?php
if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

/**
 * Frontend Class
 *
 * @since      1.0.0
 * @package    btn-media
 * @subpackage btn-media/classes
 * @author    Augustus Villanueva <augustus@businesstechninjas.com>
 */
final class btn_media_frontend {

    // Wordpress Hooks ( Actions & Filters )
    function add_wp_hooks() {

		    add_action('wp_enqueue_scripts',[$this,'enqueue']);
        add_action('wp_footer', [$this,'frontend_print_scripts']);
    		// Shortcodes
    		$this->register_shortcodes();
    }


	// Register Shortcodes
	function register_shortcodes(){

		$prefix = "btn_media_";
		$this->shortcode_map = [
			"{$prefix}list"	=> "{$prefix}shortcodes",
			"{$prefix}podcast"	=> "{$prefix}shortcodes",
			"{$prefix}downloads"	=> "{$prefix}shortcodes",

		];
		foreach ($this->shortcode_map as $tag => $class) {
			add_shortcode($tag, [$this, "shortcode_mapping"]);
		}
	}

	// Shortcode Mapping Function
	// Only includes suporting classes as needed
	function shortcode_mapping( $atts, $content, $tag ){
		$html = '';
		if( isset($this->shortcode_map[$tag]) ){
			$class = $this->shortcode_map[$tag];
			if( class_exists($class) ){
				$prefix = "btn_media_";
				$func = str_replace($prefix, '', $tag);
				if( method_exists($class, $func) ){
					$html = call_user_func([$class, $func], $atts, $content, $tag);
				}
				else {
					error_log("Function {$class} does not exist");
				}
			}
			else {
				error_log("Class {$class} does not exist");
			}
		}
		return $html;
	}

	// Enqueue Scripts
 function enqueue(){
			$url = BTN_MEDIA_ASSETS_URL ;
			$v = BTN_MEDIA_VERSION;

    wp_register_style('btn-media-frontend-css', "{$url}css/frontend.css", [], $v, 'all');


	}

  // Footer Scripts
function frontend_print_scripts(){
  $to_json = $this->get_json();
    // Nothing Doing
  if ( empty($to_json) ){
        return;
  }else {
    wp_enqueue_style('btn-media-frontend-css');
  }
}

	// Set JSON Data
    function set_json($key, $value = false) {
		if ($value) {
			$this->to_json[$key] = $value;
		}
		else {
			unset($this->to_json[$key]);
		}
	}

    // Get JSON Data
	function get_json($key = false) {
		if ($key) {
			return (isset($this->to_json[$key])) ? $this->to_json[$key] : null;
		}
		else {
			return $this->to_json;
		}
	}

	function __construct(){}

	// JSON Data for JS
	private $to_json = [];
	private $enqueue_css = false;
	// Shortcode Mapping
	private $shortcode_map;
	// Current User Data
	private $user = null;
}
