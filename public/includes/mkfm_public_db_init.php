<?php 
/**
 * Prevents any direct access to this page through the browser
 */
if ( ! defined( 'WPINC' ) ) {
	die('There is no access here.');
}

function mkfm_create_db() {
    global $wpdb;
	$table_name = $wpdb->prefix . "uploads";

	$sql = 	"CREATE TABLE IF NOT EXISTS $table_name (
			id int(4) NOT NULL AUTO_INCREMENT,
		  	file_key char(50) DEFAULT NULL,
		  	file_path char(255) DEFAULT NULL,
		  	is_directory tinyint(1) NOT NULL,
		  	revision int(11) NOT NULL DEFAULT '1',
		  	PRIMARY KEY (id)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;";

	$wpdb->query( $sql );
}