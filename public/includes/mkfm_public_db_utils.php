<?php 

if ( ! defined( 'WPINC' ) ) {
	die('There is no access here.');
}

function mkfm_encrypt( $entry ) {
    return sha1( $entry );
}

function mkfm_insert( $path ) {
    global $wpdb;
    return $wpdb->insert( WP_PREFIX . 'uploads', $path, array( '%s', '%s', '%d', '%d' ) );
    
}