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
define( 'RECURLYWP_VERSION', '0.1.0' );
define( 'RECURLYWP_URL', plugin_dir_url( __FILE__ ) );
define( 'RECURLYWP_DIR', plugin_dir_path( __FILE__ ) );
define( 'RECURLYWP_BASENAME', plugin_basename( __FILE__ ) );

define( 'RECURLYWP_DIR_INC', trailingslashit ( RECURLYWP_DIR . 'inc' ) );
define( 'RECURLYWP_DIR_LIB', trailingslashit ( RECURLYWP_DIR . 'lib' ) );
define( 'RECURLYWP_DIR_OPTIONS', trailingslashit ( RECURLYWP_DIR . 'options' ) );

require_once( RECURLYWP_DIR_OPTIONS . '/recurly-validation.php' );
require_once( RECURLYWP_DIR_OPTIONS . '/init.php' );

// Load Recurly PHP Client
if ( ! class_exists('Recurly_Base') ) {
	require_once( RECURLYWP_DIR_LIB . '/recurly/lib/recurly.php' );
}

require_once( RECURLYWP_DIR_INC . '/helper-functions.php' );
require_once( RECURLYWP_DIR_INC . '/shortcodes.php' );

if ( class_exists('GFForms') && ! class_exists('RecurlyGFFields') ) {
	require_once( RECURLYWP_DIR_INC . '/RecurlyGFFields.php' );
}


// Get prb option value
function recurlywp_get_option( $option_name, $default_value = false ) {
    $current_value = get_option('recurlywp_options')[$option_name];

    // If no current value and has a default value
    if ( ! $current_value && $default_value ) {
        return $default_value;
    }
    return $current_value;
}

// Add plugin options submenu page
function recurlywp_options_page() {
    add_submenu_page(
        'options-general.php',
        'Recurly API Settings',
        'Recurly API',
        'manage_options',
        'recurlywp',
        'recurlywp_options_page_html'
    );
}
add_action('admin_menu', 'recurlywp_options_page', 99);
