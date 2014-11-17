<?php
/************/
/*  Scripts */
/************/

function mkfm_enqueue_all() {
    mkfm_register_scripts();
    mkfm_register_styles();
}

function mkfm_register_scripts() {
    if ( ! is_admin() ){
        wp_register_script( 'mkfm-file-manager-script', 
                            FILE_MANAGER_URL . 'public/assets/js/file-manager.js', 
                            array('jquery'),
                            '1.0',
                            true    //Script is registered with the footer
                          );
        mkfm_localize_scripts();
   }
}

function mkfm_localize_scripts() {
    if ( ! is_admin() ) {
         wp_localize_script( 'mkfm-file-manager-script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
        mkfm_enqueue_scripts();
    }
}

function mkfm_enqueue_scripts() {
    if ( ! is_admin() ) {
        wp_enqueue_script( 'mkfm-file-manager-script' );
    }
}
/************/
/*  Styles  */
/************/

function mkfm_register_styles() {
    if ( ! is_admin() ) {
        wp_register_style( 'mkfm-public-style', FILE_MANAGER_URL . 'public/stylesheets/app.css' );
        mkfm_enqueue_styles();
    }
}

function mkfm_enqueue_styles() {
    if ( ! is_admin() ) {
        wp_enqueue_style( 'mkfm-public-style' );
    }
}