<?php
/*
Plugin Name: BTN  SDR
Plugin URI: https://businesstechninjas.com/
Description:  SDR Custom Post Type
Version: 1.0.0
Author: Business Tech Ninjas
Author URI: https://businesstechninjas.com/
License: Copyright (c) Business Tech Ninjas
Text Domain: btn-media
*/

// If this file is called directly, abort.
if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

define('BTN_MEDIA_VERSION', '1.0.2');
define('BTN_MEDIA_PLUGIN', __FILE__);
define('BTN_MEDIA_DIR', __DIR__ . '/');
define('BTN_MEDIA_CLASS_DIR', BTN_MEDIA_DIR . 'classes/');
define('BTN_MEDIA_TMPL_DIR', BTN_MEDIA_DIR . 'templates/');
$btn_default_url = plugins_url('', __FILE__);
define('BTN_MEDIA_URL', $btn_default_url . '/');
define('BTN_MEDIA_ASSETS_URL', BTN_MEDIA_URL . 'assets/');

// Include Autoloader
include_once BTN_MEDIA_CLASS_DIR . 'autoloader.php';

// Init Plugin
add_action('plugins_loaded',function(){
	btn_media()->init();
}, 1 );

// Gets the instance of the `btn_default` class
function btn_media(){
    return btn_media::get_instance();
}
