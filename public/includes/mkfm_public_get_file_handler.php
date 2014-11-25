<?php
require_once( 'mkfm_public_generate_inner_content.php' );
require_once( 'mkfm_public_create_breadcrumb.php' );

if( ! isset( $_SESSION ) ) {
    session_start();
}

function mkfm_refresh_list() {
    $result = json_encode( mkfm_show_files() );
    echo $result;
    die();
}

function mkfm_show_files_shortcode() {
    $result  = mkfm_print_menu();
    $result .= mkfm_show_files();
    return $result;
}

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

function mkfm_get_files() {
    $counter = 0;
    $dir = mkfm_set_dir();
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

function mkfm_set_dir() {
    if ( isset( $_REQUEST['path_id'] ) && $_REQUEST['path_id'] != '' ) {
        $dir = $_REQUEST['path_id'];
    } else {
        $dir = DOCUMENT_ROOT;
    }
    mkfm_set_current_dir( $dir );
    return $dir;
}

function mkfm_set_current_dir( $path ) {
    $_SESSION['current_dir'] = $path;
}

function mkfm_get_current_dir() {
    if ( isset( $_SESSION['current_dir'] ) ) {
        $current_dir = $_SESSION['current_dir'];
    } else {
        $current_dir = DOCUMENT_ROOT;
    }
    return $current_dir;
}