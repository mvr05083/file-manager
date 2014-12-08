<?php 

if ( ! defined( 'WPINC' ) ) {
	die('There is no access here.');
}

if( ! isset( $_SESSION ) ) {
    session_start( );
}

require_once( 'mkfm_public_db_utils.php' );

function mkfm_encrypt( $entry ) {
    return sha1( $entry );
}

/**
 * mkfm_initialize_document_root
 *
 * Recursively searches through the entire directory structutre, 
 * starting with DOCUMENT_ROOT. It then checks to see if the 
 * file already exists in the database.
 *
 * @since 1.0.0
 * @access public
 *
 * @see mkfm_check_if_exists
 *
 * @global string DOCUMENT_ROOT stores the home directory for 
 * all files.
 */
function mkfm_initialize_document_root( ) {
    $iterator = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( DOCUMENT_ROOT ), RecursiveIteratorIterator::SELF_FIRST );
    
    mkfm_check_if_exists( DOCUMENT_ROOT, 1 );
    
    foreach( $iterator as $file ) {
        $file_name = str_replace( "\\", "/", $file->__toString( ) );
        if ( basename( $file_name ) !== ".." && basename( $file_name ) !== "." && basename( $file_name ) !== 'del' ){
            if ( $file->isFile( ) ){
                mkfm_check_if_exists( $file_name, 0 );
            }
            if ( $file->isDir( ) ){
                mkfm_check_if_exists( $file_name, 1 );
            }
        }
    }
}

/**
 * mkfm_set_dir.
 *
 * Checks $_REQUEST variable for a current directory that is 
 * passed through the 'path_id' variable. If there is no such
 * variable set, the DOCUMENT_ROOT is used instead.
 *
 * @since 1.0.0
 * @access public
 *
 * @see mkfm_set_current_dir
 *
 * @global string DOCUMENT_ROOT stores the home directory for 
 * all files.
 * @global string $_REQUEST['path_id'] is added to the html as
 * a reference to the file location. This value is passed 
 * through the AJAX call to retrieve the correct file/folder.
 */
function mkfm_set_dir( ) {
    if ( isset( $_REQUEST['path_id'] ) && $_REQUEST['path_id'] != '' ) {
        $dir = $_REQUEST['path_id'];
    } else {
        $dir = DOCUMENT_ROOT;
    }
    mkfm_set_current_dir( $dir );
}

/**
 * mkfm_set_current_dir
 *
 * Sets a session variable so that the current working directory
 * can be accessed throughout the plugin.
 *
 * @since 1.0.0
 * @access public
 *
 * @param file $path is the path to the current working 
 * directory.
 * 
 * @global string $_SESSION['current_dir'] stores the current 
 * directory.
 */
function mkfm_set_current_dir( $path ) {
    $_SESSION['current_dir'] = $path;
}

/**
 * mkfm_get_current_dir
 *
 * Checks the 'current_dir' SESSION variable for a current 
 * working directory. This variable is updated upon each 
 * folder change. 
 *
 * @since 1.0.0
 * @access public
 *
 * @global string DOCUMENT_ROOT stores the home directory for 
 * all files.
 * @global string $_SESSION['current_dir'] is used to access 
 * the current directory from anywhere within the plugin.
 * 
 * @return String value containing the current working directory.
 */
function mkfm_get_current_dir( ) {
    if ( isset( $_SESSION['current_dir'] ) ) {
        $current_dir = $_SESSION['current_dir'];
    } else {
        $current_dir = DOCUMENT_ROOT;
    }
    return $current_dir;
}



function mkfm_get_all( ) {
    
}
