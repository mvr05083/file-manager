<?php

/*
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           File Manager
 *
 * @wordpress-plugin
 * Plugin Name:       File Manager
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       Turns your wordpress installation into a simple to configure, simple to use file hosting service.
 * Version:           1.0.0
 * Author:            Mike Redmond
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */

/**
 * Prevents any direct access to this page through the browser
 */
if ( ! defined( 'WPINC' ) ) {
	die('There is no access here.');
}

// DEBUGGING PURPOSES ONLY
// DO NOT INCLUDE IN PRODUCTION
//$wpdb->show_errors();

/**
 * Path to the home of the plugin.
 *
 * @since 1.0.0
 * @var string FILE_MANAGER_DIR Uses WordPress plugin_dir_path to 
 * create a constant that can be used on any operating system, or 
 * file structure. This constant is used to reference resources
 * relative to the plugin.
 */
define( 'FILE_MANAGER_DIR', plugin_dir_path ( __FILE__ ) );

/**
 * URL to the home of the plugin.
 *
 * @since 1.0.0
 * @var string FILE_MANAGER_URL Uses WordPress plugin_dir_url to 
 * create a constant that can be used on any operating system, or 
 * file structure. This constant is used to reference resources
 * relative to the plugin, namely css, js, and images.
 */
define( 'FILE_MANAGER_URL', plugin_dir_url ( __FILE__ ) );

/**
 * Prefix of the installed WordPress database. 
 *
 * @since 1.0.0
 * @var string WP_PREFIX is the prefix of the MySQL database.
 * This is used when accessing the database. This ensures 
 * that this plugin can be univserally used with different 
 * database prefixes.
 */
define( 'WP_PREFIX', $wpdb->prefix );

/**
 * The upload directory of the plugin.
 *
 * @since 1.0.0
 * @var string DOCUMENT_ROOT uses a built in WordPress function
 * wp_upload_dir to access the 'basedir' which returns the path to 
 * the upload file. This is used to construct the proper path to 
 * each file and folder.
 */
$wp = wp_upload_dir();
define( 'DOCUMENT_ROOT', str_replace( "\\", "/", $wp['basedir'] ) );

/**
 * File size constand
 *
 * @since 1.0.0
 * @var string KB, MB, GB, TB are all constants that pre-define 
 * the corresponding memory size. This is mostly used in limiting 
 * the file upload size.
 */
define( 'KB', 1024 );
define( 'MB', 1048576 );
define( 'GB', 1073741824 );
define( 'TB', 1099511627776 );

/**
 * SHA1 hash key.
 *
 * @since 1.0.0
 * @var string HASH_KEY is one of the elements used in creating the 
 * key_file.
 */
define( 'HASH_KEY', 'da39a3ee5e6b4b0d3255bfef95601890afd80709' );

/**
 * Begins initialization of the public facing application used 
 * when the shortcode is found on a page.
 */
require_once ( FILE_MANAGER_DIR . "public/mkfm-public-init.php" );


//TODO: Add options setup in this step
register_activation_hook( __FILE__, 'mkfm_db_init' );
