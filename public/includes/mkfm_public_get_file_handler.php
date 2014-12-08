<?php

if ( ! defined( 'WPINC' ) ) {
	die('There is no access here.');
}

require_once( 'mkfm_public_generate_inner_content.php' );
require_once( 'mkfm_public_create_breadcrumb.php' );
require_once( 'mkfm_public_utils.php' );

/**
 * mkfm_refresh_list
 *
 * Function called by AJAX to echo out construction file and folder html.
 *
 * @since 1.0.0
 * @access public
 * 
 *
 * @return json echos out the constructed breadcrumb, file, and folder html 
 * structures.
 */
function mkfm_refresh_list() {
    $result = json_encode( mkfm_show_files() );
    echo $result;
    die();
}

/**
 * mkfm_show_files_shortcode
 *
 * Function initially called when the page is loaded. This returns the 
 * constructed menu and file/folder html structures.
 *
 * @since 1.0.0
 * @access public
 * 
 * @return string returns file/folder html structures.
 */
function mkfm_show_files_shortcode() {
    $result  = mkfm_print_menu();
    $result .= mkfm_show_files();
    return $result;
}

/**
 * mkfm_show_files
 *
 * Creates a breadcrumb menu based on teh current working directory and then 
 * constucts a Foundation small block grid (unordered listed) that is used to 
 * create a responsive list to store the the list of folders and files
 *
 * @since 1.0.0
 * @access public
 * 
 * @return string returns Foundation block grid with Folder and File within
 * each li.
 */
function mkfm_show_files() {
    $results = mkfm_get_files();
    $cons  = mkfm_create_breadcrumb( mkfm_get_current_dir() );
    $cons .= "<ul class='small-block-grid-2 medium-block-grid-4 large-block-grid-6'>";
	if ( sizeof( $results['folders'] ) > 0 ) {
        foreach ( $results['folders'] as $folder ) {
            $cons .= $folder;
        }
    }
    if ( sizeof( $results['files'] ) > 0 ) {
        foreach ( $results['files'] as $file ) {
            $cons .= $file;
        }
    }
    $cons .= "</ul></div>";
	return $cons;
}

/**
 * mkfm_get_files
 *
 * Using the current directory, a multi-dimentional array is created with a list of
 * folders and files containing html structures.
 *
 * @since 1.0.0
 * @access public
 * 
 * @return array returns file/folder html structures.
 */
function mkfm_get_files() {
    $counter = 0;
    mkfm_set_dir();
    $dir = mkfm_get_current_dir();
    $files = scandir( $dir );
	foreach ( $files as $file ) {
		if ( ( $file != '.' ) && ( $file != '..' ) && ( $file != 'del' ) ) {
			if ( is_dir( $dir  . '/' . $file ) ) {
				$result['folders'][] = mkfm_format_folder ( "$dir/$file" );
			} else {
				$result['files'][] = mkfm_format_file ( $file, $counter );
                $counter++;
            }
		}
	}
    return $result;
}
