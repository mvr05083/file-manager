<?php 
require_once( 'mkfm_public_get_file_handler.php' );


function mkfm_upload_file(){
   $data = array();

    if(isset($_GET['files']))
    {  
        $error = false;
        $files = array();

        $uploaddir = mkfm_get_current_dir();
        foreach($_FILES as $file)
        {
            if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name'])))
            {
                $files[] = $uploaddir .$file['name'];
            }
            else
            {
                $error = true;
            }
        }
        $data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
    }
    else
    {
        $data = array('success' => 'Form was submitted', 'formData' => $_POST);
    }

    echo json_encode($data);

}

function mkfm_execute_upload(){
    require_once( 'mkfm_public_get_file_handler.php' );

    $target_dir =  mkfm_get_current_dir() . '/'. $_FILES['fileToUpload']['name'];

    echo $target_dir;
    $uploadOk = 1;
    if (file_exists($target_dir)) {
        echo "<div id='upload-message' class='alert-box warning'><p>File already exists.</p>";
        $uploadOk = 0;
    } else {
        echo "Files does not exist";
    }

    // Check file size greater than 10MB
    if ($_FILES['fileToUpload']['size']> 10*MB) { 
        echo "<div id='upload-message' class='alert-box warning'>Sorry, your file is larger than 10MB.";
        $uploadOk = 0;
    } else {
        echo "File was the correct size";
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
       echo "<p>Your file was not uploaded.</p></div>";
    // if everything is ok, try to upload file
    } else { 
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir)) {
            echo "<div id='upload-message' class='alert-box success'>The file ". basename( $_FILES["uploadFile"]["name"]). " has been uploaded.</div>";
        } else {
            echo "<div id='upload-message' class='alert-box warning'>Sorry, there was an error uploading your file.</div>";
        }
    }
    mkfm_set_current_dir(mkfm_get_current_dir());
    header( 'Location: ' . $_SERVER['HTTP_REFERER'] );
    exit;
}