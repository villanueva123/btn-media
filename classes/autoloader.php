<?php
if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

spl_autoload_register(['btn_media_autoloader', 'load']);

final class btn_media_autoloader {

	private static $classes = false;
	private static $paths   = false;

	private static function init() {
		self::$classes = [
            'btn_media' 	=> BTN_MEDIA_CLASS_DIR . 'btn-media',
						'btn_media_screen'	=> BTN_MEDIA_DIR . 'screens/post_screen',
						'btn_media_setting_screen'	=> BTN_MEDIA_DIR . 'screens/setting_screen',
						'wp_admin_templater'		=> BTN_MEDIA_DIR . 'vendor/wp-admin-templater/wp-admin-templater',
						'wp_admin_templater_data'	=> BTN_MEDIA_DIR . 'vendor/wp-admin-templater/wp-admin-data',
						'wp_admin_templater_ajax'	=> BTN_MEDIA_DIR . 'vendor/wp-admin-templater/wp-admin-ajax',
        ];
		self::$paths = [
			BTN_MEDIA_CLASS_DIR,
			BTN_MEDIA_DIR . 'screens/',
		];
	}

	public static function load( $class ) {
		if ( ! self::$classes ) {
			self::init();
		}

		$class = trim( $class );
		if ( array_key_exists( $class, self::$classes ) && file_exists( self::$classes[$class] . '.php' ) ) {
			include_once self::$classes[$class] . '.php';
		}
		else {
			foreach(self::$paths as $path) {

				$file = $path . substr($class,10) . '.php';
				if (file_exists($file)) {
					include_once $file;
				}
			}
		}

		if (substr($class, 0, 9) <> 'btn_media') {
			return;
		}
	}

}
