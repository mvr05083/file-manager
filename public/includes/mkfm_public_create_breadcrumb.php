<?php

function mkfm_create_breadcrumb( $full_path ) {
   
    $breadcrumb = '<div class="breadcrumb"><a class="breadcrumb-link" value="' . DOCUMENT_ROOT . '" href="#">Home</a><span> &raquo; </span>';
    $running_full_path = DOCUMENT_ROOT;
    $paths = mkfm_sanitize_path_for_breadcrumb( $full_path );
    if ( $paths !== '' || $paths !== null ) {
        foreach ( $paths as $path ) {
            if ( $path !== '' || $path != null ) {
                $running_full_path .= '/' . $path;
                $breadcrumb .= '<a class="breadcrumb-link" value="' . $running_full_path . '" href="#">' . $path . '</a><span> &raquo; </span>';
            }
        }
    }
    $breadcrumb .= '</div>';
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
