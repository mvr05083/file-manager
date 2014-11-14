<?php 
include_once('utils.php');
if(!isset($_SESSION)){
    session_start();
}


if (isset($_REQUEST['f']) && isset($_REQUEST['directories'])){
    
    if($file_path = getPath($_REQUEST['f'])){
        
        if(!file_exists(getPath($_REQUEST['directories']) . '/'. basename($file_path))){
            /*  Handle requests made to the directory   */
            if ($_REQUEST['directories'] == "home"){
                if(copy($file_path, DOCUMENT_ROOT_PREFIX . 'docs/'. basename($file_path))){
                    $_SESSION['move-message'] = "<div id='move-message' class='alert-box success'>" . basename($file_path) . " was successfully moved to the Home directory</div>";
                    insertNew(createHash(DOCUMENT_ROOT_PREFIX . 'docs/'. basename($file_path)), DOCUMENT_ROOT_PREFIX . 'docs/'. basename($file_path), 0);
                    recycleDocument($file_path);
                } else {
                    $_SESSION['move-message'] = "<div id='move-message' class='alert-box warning'>" . basename($file_path) . " could not be moved to the Home directory</div>";
                }
            /*  Handle all other move locations */
            }  elseif($dir_path = DOCUMENT_ROOT_PREFIX . str_replace("../", "", getPath($_REQUEST['directories']))){
                echo $dir_path . '/'. basename($file_path);

                if(copy($file_path, $dir_path . '/'. basename($file_path))){
                    $_SESSION['move-message'] = "<div id='move-message' class='alert-box success'>" . basename($file_path) . " was successfully moved to " . $dir_path .".</div>";
                    insertNew(createHash($dir_path . '/'. basename($file_path)), $dir_path . '/'. basename($file_path), 0);
                    recycleDocument($file_path);
                } else {
                    $_SESSION['move-message'] = "<div id='move-message' class='alert-box warning'>" . basename($file_path) . " could not be moved to " . $dir_path .".</div>";
                }
            } else {
                $_SESSION['move-message'] = "<div id='move-message' class='alert-box warning'>" . basename($file_path) . " does not exist. Please make sure the file you are trying to move still exists.</div>";
            }
        } else {
            $_SESSION['move-message'] = "<div id='move-message' class='alert-box warning'>" . basename($file_path) . " already exists in ". getPath($_REQUEST['directories']) . ".</div>";
        }
    }
} else {
    $_SESSION['move-message'] = "<div id='move-message' class='alert-box warning'>Invalid \"move\" request.</div>";
}


//
header( "Location: " . "https://" . $_SERVER['HTTP_HOST'] . PROJECT_ROOT . "/index.php?ptf=" . returnHash($_SESSION['current-directory']) );
exit;