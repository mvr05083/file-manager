<?php

function mkfm_create_breadcrumb( $full_path ) {
    echo 'Full path is: ' . $full_path;
    $breadcrumb = '';
    $running_full_path = DOCUMENT_ROOT;
    $paths = mkfm_sanitize_path_for_breadcrumb( $full_path );
    foreach ( $paths as $path ) {
        if ( $path !== '' || $path != null ) {
            $running_full_path .= '/' . $path;
            $breadcrumb .= '<a class="breadcrumb" value="' . $running_full_path . '" href="#"> ' . $path . '</a> /';
        }
    }
    return $breadcrumb;
}

function mkfm_sanitize_path_for_breadcrumb( $full_path ) {
    //Remove the obligatory document root for easier parsing
    $full_path = str_replace( DOCUMENT_ROOT, '', $full_path );
    //Make sure that each slash is now a forward slash to prep for exploding
    $full_path = str_replace( '\\', '/', $full_path );
    //Now each element in the array is a level within the folder structure
    $full_path = explode( '/', $full_path );
    return $full_path;
}

function mkfm_return_full_path ( $path, $path_element ) {
    $path = substr( $path, strrpos( $path, '/' . $path_element ) + 1 );
    echo $path;
}