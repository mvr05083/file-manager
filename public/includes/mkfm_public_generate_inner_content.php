<?php

function mkfm_print_menu() {
    $result .= "<ul class='small-block-grid-2 medium-block-grid-4 large-block-grid-4'>";
    $result .= "<li><a class='alert-box primary' id='mkfm-home' href='#'>Home</a></li>";
    $result .= "<li><a class='alert-box warning' value='" . DOCUMENT_ROOT ."' id='mkfm-refresh' href='#'>Refresh</a></li>";
    $result .= "<li><a class='alert-box success' data-reveal-id='mkfm-add-folder-modal' href='#'>Add Folder</a></li>";
    $result .= "<li><a class='alert-box secondary' data-reveal-id='mkfm-upload-file-modal' href='#'>Upload File</a></li>";
    // Add Folder modal
    $result .= "<div id='mkfm-add-folder-modal' class='reveal-modal' data-reveal>";
    $result .= "<a id='mkfm-close-add-folder' class='close-reveal-modal'>&#215;</a>";
    $result .= "<input type='text' id='mkfm-add-folder-text-box' />";
    $result .= "<a id='mkfm-add-folder-submit'href='#' class='alert-box success'>Add Folder</a></div>";
    // Upload File modal
    $result .= "<div id='mkfm-upload-file-modal' class='reveal-modal' data-reveal>";
    $result .= "<a id='mkfm-close-add-folder' class='close-reveal-modal'>&#215;</a>";
    $result .= '<form action="" id="upload-form">';
    $result .= '<input type="file" id="fileToUpload"/><br/><div id="progressbar"></div>';
    $result .= '<button id="upload_btn">Start Uploading</button></form></div>';

    $result .= "</ul><div id='messages'></div><div id='output'>";
    
    
    return $result;
}

function mkfm_format_folder ( $folder ) {
    $return  = "<li class='text-center'><a class='folder' href='#'>";
    $return .= "<img class='icon' value='$folder' src='" . FILE_MANAGER_URL;
    $return .= "public/assets/img/folder.png' alt='folder' /><p>" . basename( $folder ) . "</p></a></li>";
    return $return;
}

function mkfm_format_file ( $file, $counter ) {
    $return  = "<li class='text-center file'><a href='#' data-reveal-id='file-". $counter ."'>";
    $return .= "<img class='icon' src='" . FILE_MANAGER_URL . "public/assets/img/txt.png' alt='file'>";
    $return .= "<p>$file</p></a></li>";
    $return .= "<div id='file-" . $counter . "' class='reveal-modal' data-reveal><p>Here is some sample content</p><a class='close-reveal-modal'>&#215;</a></div>";

    return $return;
}