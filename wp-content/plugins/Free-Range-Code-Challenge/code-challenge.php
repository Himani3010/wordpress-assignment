<?php
/**
 * Code Challenge
 *
 * @package           Code Challenge
 * @author            Rao Information Technology
 * @copyright         2023 Rao Information Technology
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Code Challenge
 * Plugin URI:        
 * Description:       Gutenberg Block created using ACF
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Rao Information Technology
 * Author URI:        https://raoinformationtechnology.com
 * Text Domain:       code-challenge
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */
// Define the path to our plugin.
define( 'RCC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'RCC_FILE', __FILE__ );
define( 'RCC_PLUGIN_URL', plugins_url( '', RCC_FILE ) );

//This file is required to autoload the classes using composer
require_once(plugin_dir_path(__FILE__) . '/vendor/autoload.php');

/**
 * Initializing the plugin
 * Loading required Classes and text domain for translationss
 */
function initialize_plugin() {

   load_plugin_textdomain( 'code-challenge', false, basename( dirname( __FILE__ ) ) . '/languages/' );

   if( !class_exists('Core') )
   new \CODE_CHALLENGE\Core();
  
   if( !class_exists('AjaxActions') )
   new \CODE_CHALLENGE\AjaxActions();

}
add_action( 'plugins_loaded', 'initialize_plugin' );
