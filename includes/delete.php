<?php 
include_once('utils.php');
if(!isset($_SESSION)){
    session_start();
}

if (isset($_REQUEST['f'])){
    
    if($file_path = getPath($_REQUEST['f'])){
        if(file_exists($file_path) && is_file($file_path)){
                recycleDocument($file_path);
                $_SESSION['delete-message'] = "<div id='delete-message' class='alert-box success'>". basename($file_path) . " was deleted successfully.</div>";
        } elseif (file_exists($file_path) && is_dir($file_path)){
                moveDelete($file_path);
                $_SESSION['current-directory'] = substr($file_path, 0, strrpos($file_path, basename($file_path)) - 1);
                $_SESSION['delete-message'] = "<div id='delete-message' class='alert-box success'>" . basename($file_path) . " was deleted along with all subfolders and files.</div>";
                
        } else {
                $_SESSION['delete-message'] = "<div id='delete-message' class='alert-box warning'>Unable to delete your file.";
                $_SESSION['delete-message'] .= "Please make sure you have permissions to all directories under the root.</div>";
        }
            
    } else {
        $_SESSION['delete-message'] = "<div id='delete-message' class='alert-box warning'>There was an error deleting the file.</div>";
    }
} else {
    $_SESSION['delete-message'] = "<div id='delete-message' class='alert-box warning'>There was no file specified.</div>";
}

echo $_SESSION['current-directory'];
header( "Location: " . "https://" . $_SERVER['HTTP_HOST'] . PROJECT_ROOT . "/index.php?ptf=" . returnHash($_SESSION['current-directory']) );
exit;
