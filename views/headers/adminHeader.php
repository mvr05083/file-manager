<?php
    if(!isset($_SESSION)){
        session_start();
    }
?>
<!DOCTYPE html>
<html>
   <head>
        <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="stylesheets/app.css">
        <link rel="stylesheet" href="stylesheets/style.css">
    </head>   
    <body>
        <header class="header">
           <div>
               <img src="assets/Fisher%20Website%20Image.png" alt="">
           </div>
        </header>
        <div class="content-wrapper content">
            <h2>President Search Committee</h2>
            <h4>Manage users</h4>
            <div class="row">
                <ul class="large-block-grid-6 small-block-grid-2">
                    <li>
                        <a class="commands alert-box success white" href="index.php">Save Changes</a>
                    </li>
                    <li>
                        <a class="commads alert-box secondary white" href="index.php">File Manager</a>
                    </li>
                </ul>
