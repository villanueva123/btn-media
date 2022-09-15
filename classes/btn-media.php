<?php
if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

/**
 * Main Plugin Class
 *
 * @since      1.0.0
 * @package    btn-media
 * @subpackage btn-media/classes
 * @author     Augustus Villanueva <augustus@businesstechninjas.com>
 */
final class btn_media {

	function init(){
			// Text Domain / Localization
			$this->load_text_domain();
			// Init Hooks
			add_action('init',[$this,'init_hooks']);

    }

    // Init
    function init_hooks(){

			$this->post()->register();

			add_action('pre_get_posts', [$this,'add_custom_post_types']);
			$active_plugins = apply_filters('active_plugins', get_option('active_plugins'));
			
			$this->acf = ( class_exists( 'ACF' ) ) ? true : false;
			$this->get_field = ( function_exists( 'get_field' ) ) ? true : false;
		
			if (is_admin()) {
			  $this->admin()->add_wp_hooks();
			  $this->post_screen()->add_wp_hooks();
			}else{
				$this->frontend()->add_wp_hooks();
			}

			// AJAX Hooks
			if ( wp_doing_ajax() ) {
				$this->ajax()->add_wp_hooks();
			}

}

// Get Edition Class
	function elementor(){
	static $elementor = null;
			if( is_null($elementor) ){
					$elementor = new btn_media_elementor;
			}
			return $elementor;
	}


	// Get Edition Class
		function ajax(){
		static $ajax = null;
				if( is_null($ajax) ){
						$ajax = new btn_media_ajax;
				}
				return $ajax;
		}

	// Get Edition Class
  function post(){
	static $post = null;
      if( is_null($post) ){
          $post = new btn_media_post;
      }
      return $post;
  }


	// Get Admin Class
	function frontend(){
	static $frontend = null;
			if( is_null($frontend) ){
				$frontend = new btn_media_frontend;
			}
			return $frontend;
	}
	// Get Instance of Admin
	function post_screen(){
		static $post_screen = null;
		if( is_null($post_screen) ){
			$post_screen = new btn_media_screen;
		}
		return $post_screen;
	}
	// Get Instance of Admin
	function admin(){
		static $admin = null;
		if( is_null($admin) ){
			$admin = new btn_media_admin;
		}
		return $admin;
	}


	function add_custom_post_types($query) {
			if ( is_home() && $query->is_main_query() ) {
				  $post_slug = $this->post()->get_post_slug();
					$query->set( 'post_type', [$post_slug] );
			}
			return $query;
	}


	/**
	 * Return templates path checks child theme first
	 *
	 * @param string $filename
	 * @return string template path admin error or false
	*/
	function template_part_path( $filename, $directory_name = '' ){

		$not_found = [];
		$directory_name = $directory_name > '' ? trailingslashit($directory_name) : '';
		$theme_template = "{$directory_name}{$filename}";

		// Locate Template in Themes
		$template = locate_template($theme_template, false);
		// Get Plugin Defaults
		if( ! is_file($template) ){
			$not_found['theme'] = $theme_template;
			$template = BTN_MEDIA_DIR . 'templates/' . $filename;
			if( ! is_file($template) ){
				$not_found['extension'] = $template;
				$template = false;
			}
		}

		$template = apply_filters('btn/post/template/path', $template, $filename, $directory_name);
		if ( ! is_file($template) )	{
			if ( is_admin() ) {
				$notice = __('File not found in any of the following locations :', 'btn-media');
				$notice .= '<ul>';
				foreach ($not_found as $path) {
					$notice .= "<li>{$path}</li>";
				}
				$notice .= '</ul>';
				return $this->admin_error_msg($notice);
			}
			else{
				return false;
			}
		}
		else{
			return $template;
		}
	}

	// Text Domain
	function load_text_domain(){
		load_plugin_textdomain('btn-media', false, BTN_MEDIA_DIR . '/languages' );
	}

  // Write Log
  function write_log( $log, $print = false ){
      $error_log = ( is_array( $log ) || is_object( $log ) ) ? print_r( $log, true ) : $log;
      if($print){
          return '<pre>'.$error_log.'</pre>';
      }
      else{
          error_log($error_log);
      }
  }
	
	
	/**
	 * Get acf custom field
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function get_field($field, $id, $default = ''){
	    if($this->acf){
	        if($this->get_field){
	            return get_field($field, $id);
	        }
	    }
	    else {
	        return  get_metadata('post', $id , $field, true);
	    }
	 }

	 /**
	  * Get acf Repeater
	  * @param string $repeater
	  * @param int $return = repeater count
	  */
	 public function get_repeater($repeater = ''){
	     $return = false;
	     if($this->acf){
	         $repeater = esc_attr($repeater);
	         if( $repeater > '' ){
	             $rows = get_field($repeater);
	             if( is_array($rows) || is_object($rows) ){
	                 if( count($rows) > 0 ){
	                     $return = $rows;
	                 }
	             }
	         }
	     }
	     return $return;
	 }


    // Singleton Instance
  private function __construct(){}
	public static function get_instance() {
        static $instance = null;
        if ( is_null( $instance ) ) {
            $instance = new self;
        }
        return $instance;
    }
	
	private $acf;
	private $get_field;

}


