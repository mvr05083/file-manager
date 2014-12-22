<?php 
/**
 * Database Utilities
 *
 * This file contains functions for performing frequent CRUD type
 * database functions.
 *
 * @link URL
 * @since 1.0.0
 *
 * @package WordPress
 * @subpackage Database
 */

/**
 * Prevents any direct access to this page through the browser
 */
if ( ! defined( 'WPINC' ) ) {
	die('There is no access here.');
}

/**
 * mkfm_insert
 *
 * Checks the <wp-prefix>-uploads database table for the existence of
 * the current file. File existence checked using the absolute file path.
 *
 * @since 1.0.0
 * @access public
 *
 * @global string WP_PREFIX contains the WordPress database prefix.
 * 
 * @param string $path is the absolute path to the folder or file.
 * @param double $file_type is either a 1 (directory) or a 0 (file)
 * 
 * @return String Returns a hashed value that is used as a key 
 * to map to the absolute path.
 */
function mkfm_insert( $path ) {
    global $wpdb;
    return $wpdb->insert( WP_PREFIX . 'uploads', $path, array( '%s', '%s', '%d', '%d' ) );
}

/**
 * mkfm_check_if_exists
 *
 * Checks the <wp-prefix>-uploads database table for the existence of
 * the current file. Files are checked on the absolute file path.
 *
 * @since 1.0.0
 * @access public
 *
 * @global string WP_PREFIX contains the WordPress database prefix.
 * 
 * @param string $path is the absolute path to the folder or file.
 * @param double $file_type is either a 1 (directory) or a 0 (file)
 * 
 * @return String Returns a hashed value that is used as a key 
 * to map to the absolute path.
 */
function mkfm_check_if_exists( $path, $file_type ) {
    global $wpdb;
    
    $exists = $wpdb->query( 'SELECT * FROM ' . WP_PREFIX . 'uploads WHERE file_path="' . $path . '"' );
    if ( $exists == 0 ) {
        mkfm_insert( array( 'file_key' => mkfm_create_file_key( $path ), 
                            'file_path' => $path, 
                            'is_directory' => $file_type, 
                            'revision' => 1 
                          ) 
                   );
    } else {
        return true;
    }
}

/**
 * mkfm_create_file_key
 *
 * Returns a hash value that is calculated from the current time, 
 * a set key, and the file/folder itself 
 *
 * @since 1.0.0
 * @access public
 *
 * @global string HASH_KEY contains a generated SHA1 hash.
 * 
 * @param file/directory $path is the path to the current 
 * working directory.
 *
 * @return String Returns a hashed value that is used as a key 
 * to map to the absolute path.
 */
function mkfm_create_file_key ( $path ) {
    return $hash = sha1( HASH_KEY . time( ) .  $path );
}

/**
 * mkfm_get_file_key
 *
 * Takes an absolute path and returns the file_key mapped to it from 
 * the database. 
 *
 * @since 1.0.0
 * @access public
 *
 * @global database object $wpdb is a WordPress constant used for 
 * accessing the database.
 * 
 * @param string $path is the path to the selected file/folder.
 *
 * @return string returns a file_key value that contains a hashed value 
 * that maps to an absolute path.
 */
function mkfm_get_file_key ( $path ) {
    global $wpdb;
//    echo $path;
    $file_key = $wpdb->get_row( "SELECT file_key FROM " . WP_PREFIX . "uploads WHERE file_path='" . $path ."'" );
    
    return $file_key->file_key;
}

/**
 * mkfm_get_file_path
 *
 * Takes file_key (hashed value) and returns the absolute path associated
 * with it. 
 *
 * @since 1.0.0
 * @access public
 *
 * @global database object $wpdb is a WordPress constant used for accessing 
 * the database.
 * 
 * @param string $file_key is a hashed value that maps to an 
 * absolute path.
 *
 * @return string returns an absolute path to a file or folder.
 */
function mkfm_get_file_path ( $file_key ) {
    global $wpdb;
    $file_path = $wpdb->get_row( "SELECT file_path FROM " . WP_PREFIX . "uploads WHERE file_key='" . $file_key ."'" );
    
    return $file_path->file_path;
}