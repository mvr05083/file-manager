<?php

if ( ! defined( 'WPINC' ) ) {
	die('There is no access here.');
}
require_once( 'includes/mkfm_public_get_file_handler.php' );
require_once( 'includes/mkfm_public_add_folder.php' );
require_once( 'includes/mkfm_public_upload_file.php' );
require_once( 'includes/mkfm_public_enqueue.php' );
require_once( 'includes/mkfm_public_db_init.php' );

mkfm_add_functions();

function mkfm_enqueue_styles_scripts() {
    mkfm_enqueue_all();
}

function mkfm_db_init(){
    mkfm_create_db();
}

function mkfm_add_functions() {
    // Refresh list
    add_action( 'wp_ajax_mkfm_refresh_list', 'mkfm_refresh_list' );
    add_action( 'wp_ajax_nopriv_mkfm_refresh_list', 'mkfm_refresh_list' );
    // Add Folder
    add_action( 'wp_ajax_mkfm_add_folder', 'mkfm_add_folder' );
    add_action( 'wp_ajax_nopriv_mkfm_add_folder', 'mkfm_add_folder' );
    // Upload File
    add_action( 'wp_ajax_mkfm_upload_file', 'mkfm_upload_file' );
    add_action( 'wp_ajax_nopriv_mkfm_upload_file', 'mkfm_upload_file' );
    // Enqueue scripts and styles
    add_action( 'init', 'mkfm_enqueue_styles_scripts' );

    add_shortcode( 'show_files', 'mkfm_show_files_shortcode' );
}