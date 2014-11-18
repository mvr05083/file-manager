<?php 

require_once( 'mkfm_public_get_file_handler.php' );

function mkfm_add_folder() {
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
            //TODO: create the utilities for calling the database
            //insertNew(createHash($target_dir), $target_dir, 1);
            echo json_encode( "<div id='folder-message' class='alert-box success'>". basename($target_dir) ." created.</div>" );
            die();
        } else {
            echo json_encode( "<div id='folder-message' class='alert-box warning'>There was an error creating the folder.</div>" );
            die();
        }
    }
}
