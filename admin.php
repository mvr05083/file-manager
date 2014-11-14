<?php
include_once('utils.php');
include_once('config.php');

if(!isset($_SESSION)){
    session_start();
}


if (isAdmin()){
    $_SESSION['content'] = "<p>Congrats, you're in.</p>";
} else {
    $_SESSION['content'] = "<p>Access denied.</div>";
}
include_once('views/headers/adminHeader.php');
include_once('views/getFilesView.php');