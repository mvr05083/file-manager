<?php
    if(isset($_SESSION['upload-message'])){
        echo $_SESSION['upload-message'];
        $_SESSION['upload-message'] = '';
    }
    if(isset($_SESSION['folder-message'])){
        echo $_SESSION['folder-message'];
        $_SESSION['folder-message'] = '';
    }
    if(isset($_SESSION['delete-message'])){
        echo $_SESSION['delete-message'];
        $_SESSION['delete-message'] = '';
    }
    if(isset($_SESSION['replace-message'])){
        echo $_SESSION['replace-message'];
        $_SESSION['replace-message'] = '';
    }
    if(isset($_SESSION['move-message'])){
        echo $_SESSION['move-message'];
        $_SESSION['move-message'] = '';
    }

    if(isset($_SESSION['content'])){
        echo $_SESSION['content'];
        $_SESSION['content'] = '';
    }
?>
