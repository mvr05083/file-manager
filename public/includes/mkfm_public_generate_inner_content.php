<?php

require_once( 'mkfm_public_create_breadcrumb.php' );


function mkfm_print_menu() {
    $result  = 
    $result .= "<ul class='small-block-grid-2 medium-block-grid-4 large-block-grid-4'>";
    $result .= "<li><a class='alert-box primary' id='mkfm-home' href='#'>Home</a></li>";
    if ( isset( $_REQUEST['up_dir'] ) ){
        $result .= "<li><a class='alert-box secondary' value='" . $_REQUEST['up_dir'] . "' id='mkfm-refresh' href='#'>Refresh</a></li>";
    } else {
        $result .= "<li><a class='alert-box secondary' value='" . DOCUMENT_ROOT ."' id='mkfm-refresh' href='#'>Refresh</a></li>";
    }
    $result .= "</ul><div id='messages'></div><div id='output'>";
    return $result;
}

function mkfm_format_folder ( $folder ) {
    $return  = "<li class='text-center'><a class='folder' href='#'>";
    $return .= "<img class='icon' value='$folder' src='" . FILE_MANAGER_URL;
    $return .= "public/assets/img/folder.png' alt='file' /><p>" . basename( $folder ) . "</p></a></li>";
    return $return;
}

function mkfm_format_file ( $file ) {
    $return  = "<li class='text-center file'><img class='icon' src='" . FILE_MANAGER_URL;
    $return .= "public/assets/img/txt.png' alt='file' /><p>$file</p></li>";
    return $return;
}