<?php 
include_once('config.php');
include_once('utils.php');
if(!isset($_SESSION)){
    session_start();
}

$target_dir = DOCUMENT_ROOT_PREFIX . str_replace("../", "", $_SESSION['current-directory']) . "/" . $_POST['folderName'];

//Folder already exitsts
if (is_dir($target_dir)){
    $_SESSION['folder-message'] = "<div id='folder-message' class='alert-box warning'>Folder name already exists.</div>";
} else {
    echo $target_dir;
    if (mkdir($target_dir, 0755)){
        if(!file_exists(substr($target_dir, 0, strrpos($target_dir, basename($target_dir))) . 'del/')){
            mkdir(substr($target_dir, 0, strrpos($target_dir, basename($target_dir))) . 'del/', 0755);
        }
        insertNew(createHash($target_dir), $target_dir, 1);
        $_SESSION['folder-message'] = "<div id='folder-message' class='alert-box success'>Folder created.</div>";
        
    } else {
        $_SESSION['folder-message'] = "<div id='folder-message' class='alert-box warning'>There was an error creating the folder.</div>";
    }
}

header( "Location: " . "https://" . $_SERVER['HTTP_HOST'] . PROJECT_ROOT . "/index.php?ptf=" . returnHash($_SESSION['current-directory']) );
exit;