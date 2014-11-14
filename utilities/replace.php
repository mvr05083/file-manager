<?php 
include_once('utils.php');
if(!isset($_SESSION)){
    session_start();
}
$uploadOk = 1;
$_SESSION['replace-message'] = '';
$revision = getRevision($_REQUEST['f']) + 1;
if (isset($_REQUEST['f'])){
    
    if($file_path = DOCUMENT_ROOT_PREFIX . str_replace("../", "", getPath($_REQUEST['f']))){
        
        if(file_exists($file_path)){
            $old_name = $file_path;
            $old_path_parts = pathinfo($old_name);
            $path_parts = pathinfo($_FILES['replaceFile']['name']);
            
            if ($old_path_parts['extension'] === $path_parts['extension']){
                
                // Check file size greater than 10MB
                if ($_FILES['replaceFile']['size']> 10*MB) { 
                    $_SESSION['replace-message']  .= "<div id='replace-message' class='alert-box warning'>Sorry, your file is larger than 10MB.";
                    echo $_SESSION['replace-message'];
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    $_SESSION['replace-message']  .= "<p>Your file was not uploaded.</p></div>";
                    echo $_SESSION['replace-message'];
                
                // if everything is ok, try to upload file
                } else { 
                    recycleDocument($file_path);
                    
                    if (move_uploaded_file($_FILES["replaceFile"]["tmp_name"], $old_name)) {
                        insertNew(createHash($old_name), $old_name, 0, $revision);
                        $_SESSION['replace-message']  = "<div id='replace-message' class='alert-box success'>The file ". basename( $_FILES["replaceFile"]["name"]). " has been uploaded.</div>";
                        echo $_SESSION['replace-message'];
                    } else {
                        $_SESSION['replace-message']  = "<div id='replace-message' class='alert-box warning'>Sorry, there was an error uploading your file.</div>";
                        echo $_SESSION['replace-message'];
                        echo $old_name;
                    }
                }
            } else {
                    $_SESSION['replace-message'] = "<div id='replace-message' class='alert-box warning'>File type mismatch. Please make sure both files share the same extension.</div>";
            }
            

        }
    }
}

header( "Location: " . "https://" . $_SERVER['HTTP_HOST'] . PROJECT_ROOT . "/index.php?ptf=" . returnHash($_SESSION['current-directory']) );
exit;