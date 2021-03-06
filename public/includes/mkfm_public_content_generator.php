<?php
/**
 * Prevents any direct access to this page through the browser
 */
if ( ! defined( 'WPINC' ) ) {
	die('There is no access here.');
}

/**
 * mkfm_print_menu
 *
 * Returns menu and modals
 *
 * @since 1.0.0
 * @access public
 * 
 * @return string 
 */
function mkfm_print_menu() {
    $result .= "<ul class='small-block-grid-2 medium-block-grid-4 large-block-grid-4'>";
    $result .= "<li><a class='alert-box primary' id='mkfm-home' href='#'>Home</a></li>";
    $result .= "<li><a class='alert-box warning' value='" . mkfm_get_file_key( DOCUMENT_ROOT ) ."' id='mkfm-refresh' href='#'>Refresh</a></li>";
    $result .= "<li><a class='alert-box success' data-reveal-id='mkfm-add-folder-modal' href='#'>Add Folder</a></li>";
    $result .= "<li><a class='alert-box secondary' data-reveal-id='mkfm-upload-file-modal' href='#'>Upload File</a></li>";
    // Add Folder modal
    $result .= "<div id='mkfm-add-folder-modal' class='reveal-modal' data-reveal>";
    $result .= "<a id='mkfm-close-add-folder' class='close-reveal-modal'>&#215;</a>";
    $result .= "<input type='text' id='mkfm-add-folder-text-box' />";
    $result .= "<a id='mkfm-add-folder-submit'href='#' class='alert-box success'>Add Folder</a></div>";
    // Upload File modal
    $result .= "<div id='mkfm-upload-file-modal' class='reveal-modal' data-reveal>";
    $result .= "<a id='mkfm-close-upload-file' class='close-reveal-modal'>&#215;</a>";
    $result .= '<form id="upload-form" action="" method="post" enctype="multipart/form-data">';
    $result .= 'Select image to upload:<input type="file" name="fileToUpload" id="fileToUpload" multiple>';
    $result .= '<input type="submit" id="mkfm-upload-file-submit" value="Upload Image" name="submit"></form></div>';

    $result .= "</ul><div id='messages'></div><div id='output'>";
    
    return $result;
}

/**
 * mkfm_format_folder
 *
 * Returns folder html list structure
 *
 * @since 1.0.0
 * @access public
 * 
 * @see mkfm_get_file_key
 * 
 * @param string $folder Contains the path to folder
 * 
 * @return string 
 */
function mkfm_format_folder ( $folder ) {
    $return  = "<li class='text-center'><a class='folder' href='#'>";
    $return .= "<img class='icon' value='". mkfm_get_file_key( $folder ) . "' src='" . FILE_MANAGER_URL;
    $return .= "public/assets/img/folder.png' alt='folder' /><p>" . basename( $folder ) . "</p></a></li>";
    return $return;
}

/**
 * mkfm_format_file
 *
 * Returns file html list structure with accompanying modal
 *
 * @since 1.0.0
 * @access public
 * 
 * @param string $file Contains the path to file
 * @param integer $counter Counter to map <li> id to modal
 * 
 * @return array 
 */
function mkfm_format_file ( $file, $counter ) {
    $return  = "<li class='text-center file'><a href='#' data-reveal-id='file-". $counter ."'>";
    $return .= "<img class='icon' src='" . FILE_MANAGER_URL . "public/assets/img/txt.png' alt='file'>";
    $return .= "<p>$file</p></a></li>";
    $return .= "<div id='file-" . $counter . "' class='reveal-modal' data-reveal><p>Here is some sample content</p><a class='close-reveal-modal'>&#215;</a></div>";

    return $return;
}

/**
 * mkfm_create_breadcrumb
 *
 * Returns a multi-dimentional array containing
 * folder and file html structures.
 *
 * @since 1.0.0
 * @access public
 * 
 * @see mkfm_get_file_key
 * @see mkfm_sanatize_path_for_breadcrumb
 * 
 * @param string $full_path Contains the full path for the current directory
 * 
 * @return string
 */
function mkfm_create_breadcrumb( $full_path ) {
   
    $breadcrumb = '<div class="breadcrumb"><a class="breadcrumb-link" value="' . mkfm_get_file_key( DOCUMENT_ROOT ) . '" href="#">Home</a><span> &raquo; </span>';
    $running_full_path = DOCUMENT_ROOT;
    $paths = mkfm_sanitize_path_for_breadcrumb( $full_path );
    if ( $paths !== '' || $paths !== null ) {
        foreach ( $paths as $path ) {
            if ( $path !== '' || $path != null ) {
                $running_full_path .= '/' . $path;
                $breadcrumb .= '<a class="breadcrumb-link" value="' . mkfm_get_file_key( $running_full_path ). '" href="#">' . $path . '</a><span> &raquo; </span>';
            }
        }
    }
    $breadcrumb .= '</div>';
    return $breadcrumb;
}

/**
 * mkfm_sanatize_path_for_breadcrumb
 *
 * Returns array of directory path
 *
 * @since 1.0.0
 * @access public
 * 
 * @param string $full_path Contains the path of the current directory
 * 
 * @return array 
 */
function mkfm_sanitize_path_for_breadcrumb( $full_path ) {
    //Remove the obligatory document root for easier parsing
    $full_path = str_replace( DOCUMENT_ROOT, '', $full_path );
    //Make sure that each slash is now a forward slash to prep for exploding
    $full_path = str_replace( '\\', '/', $full_path );
    //Now each element in the array is a level within the folder structure
    $full_path = explode( '/', $full_path );
    return $full_path;
}
