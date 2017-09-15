<?php
/*
 Plugin Name: TechSarathy Sendy CF7 Integration
 Plugin URI: 
 Description: Sendy integration for Contact Form 7 
 Author: Rahul Taiwala
 Author URI: http://www.rktaiwala.in
 Version: 1.1.1
 License: GPLv2 or later
 Text Domain: ts_sendy
 Domain Path: languages
 */

class TsSendy
{
	/** @var string $version */
	static $version = '1.1.1';
	

	/**
	 * Bootstraps the application by assigning the right functions to
	 * the right action hooks.
	 *
	 * @since 1.1.0
	 */
	static function bootStrap()
	{
		self::autoInclude();
        TsSendyPostType::init();
        TsSendyShortcode::init();
        TsSendySettings::init();
        add_action('init', array(__CLASS__, 'init'));
        
        add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueueBackendScripts'));
	}
    static function init(){
        add_action( 'wpcf7_before_send_mail', array('TsSendyShortcode','subscribe_from_cf7'));
        TsSendyShortcode::wpcf7_hook();
    }
    /**
	 * Includes backend script.
	 *
	 * Should always be called on the admin_enqueue_scrips hook.
	 *
	 * @since 1.0.0
	 */
	static function enqueueBackendScripts()
	{
		// Function get_current_screen() should be defined
		if (!function_exists('get_current_screen'))
		{
			return;
		}

		$currentScreen = get_current_screen();

		// Enqueue 3.5 uploader
		if ($currentScreen->post_type === TsSendyPostType::$postType)
		{
             wp_enqueue_script(
                'ts-sendy',
                TsSendy::getPluginUrl().'/js/materialize.min.js',
                TsSendy::$version
            );
            wp_enqueue_style('sendy-style',TsSendy::getPluginUrl().'/css/materialize.min.css',TsSendy::$version);
            wp_enqueue_style('sendy-style-self',TsSendy::getPluginUrl().'/css/sandy.css',TsSendy::$version);
		}

		
	}
	
    
	/**
	 * Returns url to the base directory of this plugin.
	 *
	 * @since 1.0.0
	 * @return string pluginUrl
	 */
	static function getPluginUrl()
	{
		return plugins_url('', __FILE__);
	}

	/**
	 * Returns path to the base directory of this plugin
	 *
	 * @since 1.0.0
	 * @return string pluginPath
	 */
	static function getPluginPath()
	{
		return dirname(__FILE__);
	}

	/**
	 * This function will load classes automatically on-call.
	 *
	 * @since 1.0.0
	 */
	static function autoInclude()
	{
		if (!function_exists('spl_autoload_register'))
		{
			return;
		}

		function TsSendyAutoLoader($name)
		{
			$name = str_replace('\\', DIRECTORY_SEPARATOR, $name);
			$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $name . '.php';

			if (is_file($file))
			{
				require_once $file;
			}
		}

		spl_autoload_register('TsSendyAutoLoader');
	}
    
    
}

/**
 * Activate plugin
 */
TsSendy::bootStrap();
add_action('plugins_loaded', 'ts_sendy_plugin_init');
function ts_sendy_plugin_init() {
 
 load_plugin_textdomain( 'ts_sendy', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}