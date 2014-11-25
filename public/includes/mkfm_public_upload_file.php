<?php 
require_once( 'mkfm_public_get_file_handler.php' );
require_once( 'mkfm_public_db_utils.php' );

function mkfm_upload_file(){

    $target_dir =  mkfm_get_current_dir() . '/'. $_FILES['files']['name'];
    $return = $target_dir;
    $uploadOk = 1;

    if ( file_exists( $target_dir ) ) {
        $return = "<div id='upload-message' class='alert-box warning'><p>File already exists.</p>";
        $uploadOk = 0;
    }

    if ( $_FILES['files']['size']> 10*MB ) { 
        $return = "<div id='upload-message' class='alert-box warning'>Sorry, your file is larger than 10MB.";
        $uploadOk = 0;
    } 

    if ( $uploadOk == 0 ) {
       $return .= "<p>Your file was not uploaded.</p></div>";
    } else { 
        if ( move_uploaded_file( $_FILES["files"]["tmp_name"], $target_dir ) ) {
            mkfm_insert( array( 'file_key' => 'dkajdljasd', 'file_path' => $target_dir, 'is_directory' => 0, 'revision' => 1 ) );
            $return =  "<div id='upload-message' class='alert-box success'>The file ". basename( $_FILES["files"]["name"] ). " has been uploaded.</div>";
        } else {
            $return = "<div id='upload-message' class='alert-box warning'>Sorry, there was an error uploading your file.</div>";
        }
    }
    
    echo json_encode( $return, JSON_UNESCAPED_SLASHES );
    die();

}
