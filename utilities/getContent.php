<?php
include_once FILE_MANAGER_DIR . "utilities/utils.php";
function display_constants(){
	getFiles( DOCUMENT_ROOT );
}
add_shortcode( 'display_constants', 'display_constants' );

function getFiles( $directory ) {
	$dir         = $directory;
	$directories = array();
	$files_list  = array();

	/*  Makes sure users cannot pass values to the  */
	/*  server to access files outside the scope of */
	/*  the application                             */

	$files = scandir( $dir );
	foreach ( $files as $file ) {
		if ( ( $file != '.' ) && ( $file != '..' ) && ( $file != 'del' ) ) {
			if ( is_dir( $dir  . '/' . $file ) ) {
				$directories[] = $file;
			} else {
				$files_list[] = $file;
			}
		}
	}
//    echo "<a id='refresh-me' href='" . admin_url('admin-ajax.php?action=refresh_list') . "'>Refresh</a>";
    echo "<a id='refresh-me' href='#'>Refresh</a>";
	echo "<div id='output'>Folders:<br />";
	foreach ( $directories as $directory ){
		echo '<strong>' . $directory . '</strong><br />';
	}

	echo "Files:<br />";
	foreach ( $files_list as $file ){
		echo $file . '<br />';
	}
    echo "</div>";
}













////include_once('utilities/config.php');
//include_once('utils.php');
//
//if (isset($_SERVER['REMOTE_USER'])){
//    getPermissions($_SERVER['REMOTE_USER']);
//}
//
//if (isset($_GET['ptf'])){
//    getFiles($_GET['ptf']);
//} else{
//    getFiles('docs');
//}
//
//function getFiles($directory){
//    $dir = getPath($directory);
//    $directories = array();
//    $files_list  = array();
//    $up_dir = substr($dir, 0, strrpos($dir, '/'));
//    $i = 0;
//
//    /*  Makes sure users cannot pass values to the  */
//    /*  server to access files outside the scope of */
//    /*  the application                             */
//    if (strpos($dir, "docs") === false){
//        $dir = 'docs';
//    }
//    $files = scandir(str_replace("../", "", $dir));
//    foreach($files as $file){
//
//        if(($file != '.') && ($file != '..') && ($file != 'del')){
//            if(is_dir(str_replace("../", "", $dir).'/'.$file)){
//                $directories[]  = $file;
//            }else{
//                $files_list[]    = $file;
//            }
//        }
//    }
//
//    /*******************/
//    /*  Start Session  */
//    /*******************/
//    if(!isset($_SESSION)){
//        session_start();
//    }
//
//    //Set current directory global
//    $_SESSION['current-directory'] = $dir;
//    $_SESSION['content'] = "<h3>" . substr($dir, strpos($dir, '/')) . "</h3>";
//
//    if ($dir !== "docs" ){
//        $_SESSION['content'] .= "<ul class='button-group small-screen-center'><li><a class='commands alert-box white small'";
//        $_SESSION['content'] .= "href='https://" . $_SERVER['HTTP_HOST'] . PROJECT_ROOT . "/index.php?ptf=" . returnHash( $up_dir) . "'>Go Back</a></li>";
//        if(canDelete() && isset($_SERVER['REMOTE_USER'])){
//            $_SESSION['content'] .= '<li><a class="alert-box clear small" href="#" data-reveal-id="delete-folder">Delete Folder</a></li>';
//            $_SESSION['content'] .= '<div id="delete-folder" class="reveal-modal small-modal" data-reveal>';
//            $_SESSION['content'] .= '<h3>Delete ' . $dir . '?</h3>';
//            $_SESSION['content'] .= '<p>Deleting this folder will also delete any files or subfolders in it.</p>';
//            $_SESSION['content'] .= '<a class="alert-box warning prompt white" href="utilities/delete.php?f=' . returnHash( $dir) .'">';
//            $_SESSION['content'] .= 'Yes</a><a class="close-reveal-modal">&#215;</a></div>';
//        }
//        $_SESSION['content'] .= "</ul>";
//    }
//
//    /*****************************/
//    /*  Create HTML for folders  */
//    /*****************************/
//    $_SESSION['content'] .= "<ul class='small-block-grid-2 medium-block-grid-4 large-block-grid-6'>";
//    foreach($directories as $directory){
//        if ($directory !== "del"){
//            $_SESSION['content'] .= "<li><a href='https://" . $_SERVER['HTTP_HOST'] . PROJECT_ROOT . "/index.php?ptf=" . returnHash( $dir. '/' . $directory) . "'>";
//            $_SESSION['content'] .= "<div class='text-center'><img class='icon-img' src='assets/folder.png' /><p class='text-center'>$directory</p></div></a></li>";
//        }
//    }
//
//    /***************************/
//    /*  Create HTML for files  */
//    /***************************/
//    foreach($files_list as $file_list){
//        /*  Each file anchor opens a modal for further, file-specific options   */
//        $_SESSION['content'] .= '<li><a href="#" data-reveal-id="file-' . $i . '">';
//        $_SESSION['content'] .= '<div class="text-center"><img class="icon-img" src="'. getImage($file_list) .'" /><p>' . $file_list . '</p></div></a></li>';
//        $_SESSION['content'] .= '<div id="file-'. $i . '" class="reveal-modal" data-reveal>';
//        $_SESSION['content'] .= '<a class="close-reveal-modal">&#215;</a>';
//        $_SESSION['content'] .= '<ul class="large-block-grid-6 small-block-grid-2">';
//        $_SESSION['content'] .= '<li><a class="alert-box success white" href="https://' . $_SERVER['HTTP_HOST'] . PROJECT_ROOT;
//        $_SESSION['content'] .= '/utilities/download.php?f=' . returnHash( $dir . '/' . $file_list) .'">Download</a></li>';
//
//        /*  Only display buttons users have access to see   */
//        if (canMove() && isset($_SERVER['REMOTE_USER'])){
//            $_SESSION['content'] .= '<li><a class="alert-box secondary white" href="#" data-reveal-id="move-' . $i . '">Move</a></li>';
//        }
//        if (canReplace() && isset($_SERVER['REMOTE_USER'])){
//            $_SESSION['content'] .= '<li><a class="alert-box warning white" href="#" data-reveal-id="replace-' . $i . '"';
//            $_SESSION['content'] .= 'href="replace.php?f=' .returnHash( $dir . '/' . $file_list) .'">Replace</a></li>';
//        }
//        if (canDelete() && isset($_SERVER['REMOTE_USER'])){
//            $_SESSION['content'] .= '<li><a class="alert-box alert white" href="#" data-reveal-id="delete-' . $i . '">Delete</a></li>';
//        }
//        $_SESSION['content'] .= '</ul>';
//        $_SESSION['content'] .= "<a href='https://" . $_SERVER['HTTP_HOST'] . PROJECT_ROOT . "/utilities/download.php?f=" . returnHash( $dir . '/' . $file_list) ."'>";
//        $_SESSION['content'] .= "<div class='text-center'><img class='icon-img' src='". getImage($file_list) ."' /><p>$file_list</p></div></a>";
//        $_SESSION['content'] .= '<p>Revision: '. getRevision(returnHash( $dir . '/' . $file_list)). '</p>';
//
//        /*  Delete file modal   */
//        if (canDelete() && isset($_SERVER['REMOTE_USER'])){
//            $_SESSION['content'] .= '<div id="delete-' .$i. '" class="reveal-modal small-modal" data-reveal>';
//            $_SESSION['content'] .= '<a class="close-reveal-modal">&#215;</a>';
//            $_SESSION['content'] .= 'Are you sure you want to delete this file?<a href="utilities/delete.php?f=' .returnHash( $dir . '/' . $file_list);
//            $_SESSION['content'] .= '"<div class="alert-box alert white prompt">Yes</div></a></div>';
//        }
//        /*  Replace file modal   */
//        if (canReplace() && isset($_SERVER['REMOTE_USER'])){
//            $_SESSION['content'] .= '<div id="replace-' . $i . '" class="reveal-modal small-modal" data-reveal>';
//            $_SESSION['content'] .= '<form  action="utilities/replace.php?f=' . returnHash( $dir . '/' . $file_list) . '" method="post" enctype="multipart/form-data">';
//            $_SESSION['content'] .= '<p>Replacing <strong>' . $file_list . '</strong> will overwrite the current document.</p>';
//            $_SESSION['content'] .= 'Please choose a file: <input type="file" name="replaceFile"><br>';
//            $_SESSION['content'] .= '<input class="alert-box warning" type="submit" value="Replace File">';
//            $_SESSION['content'] .= '</form><a class="close-reveal-modal">&#215;</a></div>';
//        }
//        /*  Move file modal   */
//        if (canMove() && isset($_SERVER['REMOTE_USER'])){
//            $_SESSION['content'] .= '<div id="move-' . $i . '" class="reveal-modal small-modal" data-reveal>';
//            $_SESSION['content'] .= '<form  action="utilities/move.php?f=' .returnHash( $dir . '/' . $file_list) . '" method="post" enctype="multipart/form-data">';
//            $_SESSION['content'] .= '<select name="directories">';
//            if ($dir != "docs"){
//                $_SESSION['content'] .= '<option value="home">docs</option>';
//            }
//            $directories = getAllDirectory();
//            foreach($directories as $directory){
//                if (!strpos($directory, "/del/") && $dir != $directory){
//                    $_SESSION['content'] .= "<option value='" . returnHash( $directory). "'>" .$directory. "</option>";
//                }
//            }
//            $_SESSION['content'] .= '</select>';
//            $_SESSION['content'] .= '<input class="alert-box secondary" type="submit" value="Move File">';
//            $_SESSION['content'] .= '</form><a class="close-reveal-modal">&#215;</a></div>';
//        }
//        $i++;
//    }
//    $_SESSION['content'] .= "</ul>";
//}