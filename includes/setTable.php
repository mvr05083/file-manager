<?php
/**
 * Created by PhpStorm.
 * User: mredmond
 * Date: 11/12/2014
 * Time: 10:09 AM
 */

function fm_install(){
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
//	require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
//	dbDelta( $sql );
}