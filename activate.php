<?php

if ( ! defined( 'WPINC' ) ) {
	die('There is no access here.');
}


add_action('wp_ajax_refresh_list', 'refresh_list');
add_action('wp_ajax_nopriv_refresh_list', 'refresh_list');
add_action( 'init', 'my_script_enqueuer' );

function my_script_enqueuer() {
    wp_register_script( "mkfm-file-manager-script", FILE_MANAGER_URL . 'assets/js/mkfm-file-manager.js', array('jquery') );
    wp_register_script( "mkfm-foundation-script", FILE_MANAGER_URL . 'assets/js/foundation.min.js', array('jquery') );

    wp_register_style( 'mkfm-foundation-style', FILE_MANAGER_URL . 'stylesheets/app.css' );

    wp_localize_script( 'mkfm-file-manager-script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'mkfm-foundation-script' );
    wp_enqueue_script( 'mkfm-file-manager-script' );
    
    wp_enqueue_style( 'mkfm-foundation-style' );

}

function refresh_list( $dir = '' ){
    
    if ($dir === ''){
        $dir = DOCUMENT_ROOT;
    }
    
    $files = scandir( $dir );
    
	foreach ( $files as $file ) {
		if ( ( $file != '.' ) && ( $file != '..' ) && ( $file != 'del' ) ) {
			if ( is_dir( $dir  . '/' . $file ) ) {
				$result['folders'][] = mkfm_format_folder( $file );
			} else {
				$result['files'][] = mkfm_format_file( $file );
			}
		}
	}
    
    $result = json_encode($result);
    echo $result;
    
//    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
//      $result = json_encode($result);
//      echo $result;
//    } else {
//      header("Location: ".$_SERVER["HTTP_REFERER"]);
//    }

    die();

}

function mkfm_format_folder ( $folder ) {
    
    return "<li class='text-center' ><img class='text-center' height='50' width='50' src='" . FILE_MANAGER_URL . "assets/folder.png' /><p>$folder</p></li>";
    
}

function mkfm_format_file ( $file ) {
    
    return "<li class='text-center'><img class='text-center' height='50' width='50' src='" . FILE_MANAGER_URL . "assets/file-icon.png' /><p>$file</p></li>";
    
}

