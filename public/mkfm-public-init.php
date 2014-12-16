<?php

/**
 * Prevents any direct access to this page through the browser
 */
if ( ! defined( 'WPINC' ) ) {
	die('There is no access here.');
}

// TODO: Create entries in upload directory for already existing folders/files
require_once( 'includes/mkfm_public_get_file_handler.php' );
require_once( 'includes/mkfm_public_add_folder.php' );
require_once( 'includes/mkfm_public_upload_file.php' );
require_once( 'includes/mkfm_public_enqueue.php' );
require_once( 'includes/mkfm_public_db_init.php' );
require_once( 'includes/mkfm_public_db_utils.php' );
require_once( 'includes/mkfm_public_utils.php' );
require_once( 'includes/mkfm_public_content_generator.php' );



/**
 * mkfm_enqueue_styles_scripts
 *
 * Calls function to enqueue stylesheets and js scripts. Function 
 * call is made from file-manager.php in the root of the plugin.
 *
 * @since 1.0.0
 * @access public
 *
 * @see mkfm_public_enqueue.php/mkfm_enqueue_all
 */
function mkfm_enqueue_styles_scripts() {
    mkfm_enqueue_all();
}

/**
 * mkfm_db_init
 *
 * Calls function to create the database during plugin activation. 
 * Function call takes place in the file-manager.php file at the 
 * root of the plugin.
 *
 * @since 1.0.0
 * @access public
 *
 * @see mkfm_public_db_init.php/mkfm_create_db
 */
function mkfm_db_init(){
    mkfm_create_db();
}

/**
 * mkfm_add_functions
 *
 * Relies on built-in WordPress functions to create a callback
 * function for all AJAX requests. Additionally, an action is created
 * to initialize the shortcode using the 'init' WordPress hook. 
 * Finally, the plugin scans the DOCUMENT_ROOT to verify that all existing 
 * folders/files are also present in the database to ensure application
 * integrity.
 *
 * @since 1.0.0
 * @access public
 *
 * @see mkfm_public_utils.php/mkfm_initialize_document_root
 */
function mkfm_add_functions() {
    add_action( 'wp_ajax_mkfm_refresh_list', 'mkfm_refresh_list' );
    add_action( 'wp_ajax_nopriv_mkfm_refresh_list', 'mkfm_refresh_list' );
    
    add_action( 'wp_ajax_mkfm_add_folder', 'mkfm_add_folder' );
    add_action( 'wp_ajax_nopriv_mkfm_add_folder', 'mkfm_add_folder' );
    
    add_action( 'wp_ajax_mkfm_upload_file', 'mkfm_upload_file' );
    add_action( 'wp_ajax_nopriv_mkfm_upload_file', 'mkfm_upload_file' );
    
    add_action( 'init', 'mkfm_enqueue_styles_scripts' );

    add_shortcode( 'show_files', 'mkfm_show_files_shortcode' );
    
    mkfm_initialize_document_root();
}

mkfm_add_functions();