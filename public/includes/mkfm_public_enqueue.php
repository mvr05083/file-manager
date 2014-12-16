<?php
/**
 * Enqueue Scripts & Stylesheets
 *
 * This file contains functions for appending stylesheets and 
 * JavaScript scripts to the page.
 *
 * @link URL
 * @since 1.0.0
 *
 * @package WordPress
 * @subpackage PluginInitialization
 */

/**
 * Prevents any direct access to this page through the browser
 */
if ( ! defined( 'WPINC' ) ) {
	die('There is no access here.');
}

/**
 * mkfm_enqueue_all
 *
 * Begins the chain of script registration functions.
 *
 * @since 1.0.0
 * @access public
 *
 * @package FileManager
 * @see mkfm_register_scripts
 * @see mkfm_register_styles
 */
function mkfm_enqueue_all() {
    mkfm_register_scripts();
    mkfm_register_styles();
}

/**
 * mkfm_register_scripts
 *
 * Checks to see if the user is currently logged into WordPress's 
 * admin panel before appending any JavaScript to the page. The Foundation
 * JavaScript libraries are loaded followed by the File Manager's. All this
 * is achieved using WordPress function 'wp_register_script'
 *
 * @since 1.0.0
 * @access public
 *
 * @package FileManager 
 * @see mkfm_register_scripts
 * @see mkfm_localize_scripts
 * 
 * @package WordPress
 * @see is_admin
 * @see wp_register_script
 */
function mkfm_register_scripts() {
    if ( ! is_admin() ){
        wp_register_script( 'mkfm-foundation',
                        FILE_MANAGER_URL . 'public/assets/js/foundation.min.js',
                        array(),
                        '1.0',
                        true
                      );
        wp_register_script( 'mkfm-foundation-reveal',
                        FILE_MANAGER_URL . 'public/assets/js/foundation.reveal.js',
                        array( 'mkfm-foundation' ),
                        '1.0',
                        true
                      );
        wp_register_script( 'mkfm-file-manager-script', 
                        FILE_MANAGER_URL . 'public/assets/js/file-manager.js', 
                        array( 'jquery' ),
                        '1.0',
                        true    //Script is registered with the footer
                      );
        mkfm_localize_scripts();
   }
}

/**
 * mkfm_enqueue_all
 *
 * Creates two variables to use within the JavaScript files:
 *  1. ajaxurl    =>  References admin-ajax.php file to allow WordPress to 
 *                    handle AJAX requests.
 *  2. ajax_nonce =>  References the WordPress-style nonce that is used to 
 *                    prevent bogus form submissions within the plugin.
 *                 
 * @since 1.0.0
 * @access public
 *
 * @package FileManager
 * @see mkfm_register_scripts
 * @see mkfm_enqueue_scripts 
 *
 * @package WordPress
 * @see is_admin
 * @see wp_localize_script
 * @see wp_create_nonce
 * @see admin_url
 */
function mkfm_localize_scripts() {
    if ( ! is_admin() ) {
        $params = array(
            'ajaxurl' => admin_url( 'admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce( 'ajax_verify' )
        );
        wp_localize_script( 'mkfm-file-manager-script', 'myAjax', $params );
        mkfm_enqueue_scripts();
    }
}

/**
 * mkfm_enqueue_scripts
 *
 * Uses the WordPress function to finally enqueue the scripts registered
 * onto the page.
 *                 
 * @since 1.0.0
 * @access public 
 *
 * @package WordPress
 * @see is_admin
 * @see wp_enqueue_scripts
 */
function mkfm_enqueue_scripts() {
    if ( ! is_admin() ) {
        wp_enqueue_script( 'mkfm-foundation' );
        wp_enqueue_script( 'mkfm-foundation-reveal' );
        wp_enqueue_script( 'mkfm-file-manager-script' );
    }
}

/**
 * mkfm_register_styles
 *
 * Checks to see if the user is currently logged into WordPress's 
 * admin panel before appending any CSS to the page. All this
 * is achieved using WordPress function 'wp_register_style'
 *
 * @since 1.0.0
 * @access public
 *
 * @global FILE_MANAGER_URL This is the URL that points to the root folder
 * of the plugin.
 * 
 * @package FileManager 
 * @see mkfm_enqueue_styles
 * 
 * @package WordPress
 * @see is_admin
 * @see wp_register_script
 */
function mkfm_register_styles() {
    if ( ! is_admin() ) {
        wp_register_style( 'mkfm-public-style', FILE_MANAGER_URL . 'public/stylesheets/app.css' );
        mkfm_enqueue_styles();
    }
}
/**
 * mkfm_enqueue_styles
 *
 * Uses the WordPress function to finally enqueue the stylesheets registered
 * onto the page.
 *                 
 * @since 1.0.0
 * @access public 
 *
 * @package WordPress
 * @see is_admin
 * @see wp_enqueue_styles
 */
function mkfm_enqueue_styles() {
    if ( ! is_admin() ) {
        wp_enqueue_style( 'mkfm-public-style' );
    }
}