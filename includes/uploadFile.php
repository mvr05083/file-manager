<?php
include_once('config.php');
include_once('utils.php');
if(!isset($_SESSION)){
    session_start();
}

$target_dir = str_replace("../", "", $_SESSION['current-directory']);
$target_dir = DOCUMENT_ROOT_PREFIX . $target_dir . "/" .basename( $_FILES["uploadFile"]["name"]);
$uploadOk=1;

echo $target_dir . "<br />";
echo $target_dir . $_FILES["uploadFile"]["name"] . "<br />";
print_r ($_FILES["uploadFile"]);

// Check if file already exists
if (file_exists($target_dir)) {
    $_SESSION['upload-message']  = "<div id='upload-message' class='alert-box warning'><p>File already exists.</p>";
    $uploadOk = 0;
}

// Check file size greater than 10MB
if ($_FILES['uploadFile']['size']> 10*MB) { 
    $_SESSION['upload-message']  = "<div id='upload-message' class='alert-box warning'>Sorry, your file is larger than 10MB.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $_SESSION['upload-message']  .= "<p>Your file was not uploaded.</p></div>";
// if everything is ok, try to upload file
} else { 
    if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_dir)) {
        insertNew(createHash($target_dir), $target_dir, 0);
        $_SESSION['upload-message']  = "<div id='upload-message' class='alert-box success'>The file ". basename( $_FILES["uploadFile"]["name"]). " has been uploaded.</div>";
    } else {
        $_SESSION['upload-message']  = "<div id='upload-message' class='alert-box warning'>Sorry, there was an error uploading your file.</div>";
    }
}

//echo "<a href='index.php'>Continue</a>";

header( "Location: " . "https://" . $_SERVER['HTTP_HOST'] . PROJECT_ROOT . "/index.php?ptf=" . returnHash($_SESSION['current-directory']) );
exit;