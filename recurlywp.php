<?php
/*
Plugin Name: Recurly Toolset for WordPress
Plugin URI: https://www.secretstache.com/recurly-toolset-wordpress
Description: This plugin creates a toolset for using Recurly with WordPress.
Version: 0.1.0
Author: Secret Stache Media
Author URI: https://www.secretstache.com/
Text Domain: recurlywp
Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 *  Define Constants
 *  @since   RecurlyWP  0.1.0
 */
define( 'RECURLYWP_VERSION', '0.1.2' );
define( 'RECURLYWP_URL', plugin_dir_url( __FILE__ ) );
define( 'RECURLYWP_DIR', plugin_dir_path( __FILE__ ) );
define( 'RECURLYWP_BASENAME', plugin_basename( __FILE__ ) );

define( 'RECURLYWP_DIR_INC', trailingslashit ( PRB_RECURLY_DIR . 'inc' ) );
define( 'RECURLYWP_DIR_LIB', trailingslashit ( PRB_RECURLY_DIR . 'lib' ) );
define( 'RECURLYWP_DIR_OPTIONS', trailingslashit ( PRB_RECURLY_DIR . 'options' ) );

// Required Files

// Load Recurly PHP Client
if ( ! class_exists('Recurly_Base') ) {
	require_once( RECURLYWP_DIR_LIB . '/recurly/lib/recurly.php' );

}
