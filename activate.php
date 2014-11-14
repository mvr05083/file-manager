<?php

if ( ! defined( 'WPINC' ) ) {
	die('There is no access here.');
}


add_action('wp_ajax_refresh_list', 'refresh_list');
add_action('wp_ajax_nopriv_refresh_list', 'refresh_list');
add_action( 'init', 'my_script_enqueuer' );

function my_script_enqueuer() {
   wp_register_script( "file-manager-script", FILE_MANAGER_URL . 'assets/js/file-manager.js', array('jquery') );
   wp_localize_script( 'file-manager-script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        

   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'file-manager-script' );

}

function refresh_list(){
    $dir = DOCUMENT_ROOT;
    $files = scandir( $dir );
	foreach ( $files as $file ) {
		if ( ( $file != '.' ) && ( $file != '..' ) && ( $file != 'del' ) ) {
			if ( is_dir( $dir  . '/' . $file ) ) {
				$result['folders'][] = "<strong>" . $file . "</strong><br />";
			} else {
				$result['files'][] = $file . "<br />";
			}
		}
	}
    
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      $result = json_encode($result);
      echo $result;
    } else {
      header("Location: ".$_SERVER["HTTP_REFERER"]);
    }

    die();

}