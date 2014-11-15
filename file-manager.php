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
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress dashboard.
 * Version:           1.0.0
 * Author:            Your Name or Your Company
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die('There is no access here.');
}

define( 'FILE_MANAGER_DIR', plugin_dir_path ( __FILE__ ) );
define( 'FILE_MANAGER_URL', plugin_dir_url ( __FILE__ ) );
define( 'WP_PREFIX', $wpdb->prefix );
define( 'DOCUMENT_ROOT', plugin_dir_path ( __FILE__ ) . "../../uploads" );
define( 'KB', 1024 );
define( 'MB', 1048576 );
define( 'GB', 1073741824 );
define( 'TB', 1099511627776 );
define( 'HASH', 'd41d8cd98f00b204e9800998ecf8427e' );


require_once ( FILE_MANAGER_DIR . "activate.php" );
require_once ( FILE_MANAGER_DIR . "utilities/setTable.php");
require_once ( FILE_MANAGER_DIR . 'utilities/getContent.php');

register_activation_hook( __FILE__, 'fm_install' );
