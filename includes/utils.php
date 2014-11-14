<?php

if(!isset($_SESSION)){
    session_start();
}

/********/
/*  C   */
/********/
function createHash(){
    $time = time();
    return $hash = md5(HASH . $time);;
}

/********/
/*  D   */
/********/
function deleteRow($key){
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS,  DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $key = addslashes($key);
    $sql = "DELETE FROM uploads WHERE file_path='$key'";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    
    $conn->close();
}

/********/
/*  G   */
/********/
function getAllDirectory($dir = DOCUMENT_ROOT){
    $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($dir), 
            RecursiveIteratorIterator::SELF_FIRST);

    foreach($iterator as $file) {
        if($file->isDir()) {
            $file_name = $file->__toString();
            
            if (basename($file_name) !== ".." && basename($file_name) !== "." && basename($file_name) !== 'del'){
                $directories[] = str_replace("\\", "/", $file_name);
            }
        }
    }
    return $directories;
}

function getImage($file_list){
    $ext = substr($file_list, strrpos($file_list, '.') + 1);
    $pic = 'assets/';
    switch($ext) {
        case 'doc':
        case 'docx':
            $pic .= 'word.png';
            break;
        case 'ppt':
        case 'pptx':
            $pic .= 'powerpoint.png';
            break;
        case 'pdf':
            $pic .= 'pdf.png';
            break;
        case 'xlsx':
        case 'xlms':
        case 'xls':
        case 'xlsb':
            $pic .= 'excel.png';
            break;
        case 'png':
        case 'tiff':
        case 'jpg':
        case 'jpeg':
        case 'gif':
        case 'svg':
            $pic .= 'image.png';
            break;
        default:
            $pic .= 'txt.png';
            break;
    }
    return $pic;
}

function getPath($key){
    
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS,  DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT file_path FROM uploads where file_key='$key'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $output =  $row['file_path'];
        }
    } else {
        $output =  "0 results";
    }
    $conn->close();
    return $output;
}

function getRevision($key){
    
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS,  DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT revision FROM uploads where file_key='$key'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $output =  $row['revision'];
        }
    } else {
        $output =  "0 results";
    }
    $conn->close();
    return $output;
}

/********/
/*  I   */
/********/
function insertNew($key, $name, $is_directory, $revision = 1){
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS,  DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $name = str_replace("\\", "/", $name);
    $name = addslashes($name);
    $sql = "INSERT INTO uploads (file_key, file_path, is_directory, revision) VALUES ('$key', '$name', $is_directory, $revision)";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

/********/
/*  M   */
/********/
function moveDelete($path){
    $dir = basename($path);
    $new_folder_location = substr($path, 0, strrpos($path,$dir));
    if(file_exists($path) && !file_exists($new_folder_location . 'del/' . $dir)){
        if(rename($path, $new_folder_location . 'del/' . $dir)){
            deleteRow($path);
        }
    } elseif (file_exists($path) && file_exists($new_folder_location . 'del/' . $dir)){
        if(rename($path, $new_folder_location . 'del/' . $dir . '-' . time())){
            deleteRow($path);
        }
    }
}

/********/
/*  R   */
/********/
function recycleDocument($file_path){
    $filename = addslashes(basename($file_path));
    $filename = str_replace("../", "", $filename);
    
    $new_file_location = substr($file_path, 0, strrpos($file_path,$filename));
    if (!file_exists($new_file_location . 'del/')){
        mkdir($new_file_location . 'del/', 0755);   
    }
    if (rename($file_path, $new_file_location . 'del/' . time() . $filename)){
        deleteRow($file_path);
    }
}

function recursiveDelete($str){
    if(is_file($str)){
        return recycleDocument($str);
    }
    elseif(is_dir($str) && basename($str) !== "del"){
        $scan = glob(rtrim($str,'/').'/*');
        foreach($scan as $index=>$path){
            recursiveDelete($path);
        }
        return @rmdir($str);
    }
}

function returnHash($path){
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS,  DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $path = str_replace("\\", "/", $path);
    $path = addslashes($path);
    $path = DOCUMENT_ROOT_PREFIX . str_replace("../", "", $path);
    $sql = "SELECT file_key FROM uploads where file_path='$path'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $output =  $row['file_key'];
        }
    } else {
        $output =  "Not Found";
    }
    $conn->close();
    return $output;
}

/********************************/
/*  PERMISSIONS Functions
/********************************/

function adminPanel(){
    if ($_SESSION['permissions']['admin_panel'] == 0){
        return false;
    } else {
        return true;
    }
}
function canDelete(){
    if ($_SESSION['permissions']['can_delete'] == 0){
        return false;
    } else {
        return true;
    }
}

function canMove(){
    if ($_SESSION['permissions']['can_move'] == 0){
        return false;
    } else {
        return true;
    }
}

function canReplace(){
    if ($_SESSION['permissions']['can_replace'] == 0){
        return false;
    } else {
        return true;
    }
}

function canUpload(){
    if ($_SESSION['permissions']['can_upload'] == 0){
        return false;
    } else {
        return true;
    }
}

function isAdmin(){
    if ($_SESSION['permissions']['is_admin'] == 0){
        return false;
    } else {
        return true;
    }
}

function checkUserExist($username){
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS,  DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT username FROM users where username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    } else {
        $sql = "INSERT INTO users (username) VALUES ('$username')";
        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
    $conn->close();
}

function getPermissions($username){
    $output = '';
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS,  DB_NAME);
    if (checkUserExist($username)) {
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT g.name, g.can_delete, g.can_move, g.can_upload, g.can_replace, g.is_admin, u.username FROM users u, groups g where u.username='$username' and u.group_id = g.id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['permissions'] = $row;
        } else {
            $output =  Array('username'=>$username, 'default'=>0);
        }
        $conn->close();
        return $output;
    } else {
        return Array('username'=>$username, 'default'=>0);
    }
}



