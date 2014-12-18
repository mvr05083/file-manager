<?php 
/**
 * Prevents any direct access to this page through the browser
 */
if ( ! defined( 'WPINC' ) ) {
	die('There is no access here.');
}

function mkfm_add_folder() {
    check_ajax_referer( 'ajax_verify', 'security' );
    
    if ( isset( $_REQUEST['new_folder_name'] ) ) {
        $folder_name = $_REQUEST['new_folder_name'];
    } else {
        $folder_name = 'Un-Named Folder';
    }
    
    $target_dir = mkfm_get_current_dir() . '/' . $folder_name;
    if ( is_dir( $target_dir ) ) {
        echo json_encode( "<div id='folder-message' class='alert-box warning'>Sorry, that directory already exists. Please select a different name</div>" );
        die();
       
    } else {
        if ( mkdir( $target_dir, 0755 ) ) {
            mkfm_insert( array( 'file_key' => mkfm_create_file_key(), 
                                'file_path' => $target_dir, 
                                'is_directory' => 1, 
                                'revision' => 1 ) 
                       );
            echo json_encode( "<div id='folder-message' class='alert-box success'>". basename($target_dir) ." created.</div>" );
            die();
        } else {
            echo json_encode( "<div id='folder-message' class='alert-box warning'>There was an error creating the folder. Please check folders.</div>" );
            die();
        }
    }
}
