<?php

if ( ! defined( 'WPINC' ) ) {
	die('There is no access here.');
}

add_action('wp_ajax_mkfm_refresh_list', 'mkfm_refresh_list');
add_action('wp_ajax_nopriv_mkfm_refresh_list', 'mkfm_refresh_list');
add_action( 'init', 'mkfm_enqueue_scripts' );

add_shortcode( 'show_files', 'mkfm_show_files_shortcode' );

function mkfm_enqueue_scripts() {
   if ( ! is_admin() ){
        wp_register_script( 'mkfm-file-manager-script', 
                            FILE_MANAGER_URL . 'public/assets/js/file-manager.js', 
                            array('jquery'),
                            '1.0',
                            true
                          );
       
        wp_localize_script( 'mkfm-file-manager-script', 'myAjax', 
                            array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) 
                          );
       
        wp_enqueue_script( 'mkfm-file-manager-script' );

        wp_register_style( 'mkfm-public-style', FILE_MANAGER_URL . 'public/stylesheets/app.css' );
        wp_enqueue_style( 'mkfm-public-style' );
   }
}

function mkfm_db_init(){
	global $wpdb;
	$table_name = $wpdb->prefix . "uploads";

	$sql = 	"CREATE TABLE IF NOT EXISTS $table_name (
			id int(4) NOT NULL AUTO_INCREMENT,
		  	file_key char(50) DEFAULT NULL,
		  	file_path char(255) DEFAULT NULL,
		  	is_directory tinyint(1) NOT NULL,
		  	revision int(11) NOT NULL DEFAULT '1',
		  	PRIMARY KEY (id)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;";

	$wpdb->query( $sql );
}

function mkfm_refresh_list() {
    $result = json_encode( mkfm_show_files() );
    echo $result;
    die();
}

function mkfm_show_files_shortcode(){
    $result  = mkfm_print_menu();
    $result .= mkfm_show_files();
    return $result;
}

function mkfm_show_files() {
    $results = mkfm_get_files();
    
    $cons .= "<ul class='small-block-grid-2 medium-block-grid-4 large-block-grid-6'>";
	if ( sizeof( $results['folders'] ) > 0 ){
        foreach ( $results['folders'] as $folder ) {
            $cons .= $folder;
        }
    }
    if ( sizeof( $results['files'] ) > 0 ){
        foreach ( $results['files'] as $file ) {
            $cons .= $file;
        }
    }
    
    $cons .= "</ul></div>";
	return $cons;
}

function mkfm_get_files() {
    $dir = mkfm_set_dir();
    $files = scandir( $dir );
	foreach ( $files as $file ) {
		if ( ( $file != '.' ) && ( $file != '..' ) && ( $file != 'del' ) ) {
			if ( is_dir( $dir  . '/' . $file ) ) {
				$result['folders'][] = mkfm_format_folder ( "$dir/$file" );
			} else {
				$result['files'][] = mkfm_format_file ( $file );
            }
		}
	}
    return $result;
}

function mkfm_set_dir() {
    if ( isset( $_REQUEST['path_id'] ) ) {
        $dir = $_REQUEST['path_id'];
    } else {
        $dir = DOCUMENT_ROOT;
    }
    return $dir;
}

function mkfm_print_menu() {
    $result  = "<ul class='small-block-grid-2 medium-block-grid-4 large-block-grid-4'>";
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