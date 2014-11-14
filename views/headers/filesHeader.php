<?php
    if(!isset($_SESSION)){
        session_start();
    }
    $menus = '';
    if (canUpload()){
        $menus .= '<li><a class="commands alert-box success white" href="#" data-reveal-id="upload-file">Upload File</a></li>';
        $menus .= '<li><a  class="commands alert-box secondary white" href="#" data-reveal-id="folder-name">Create Folder</a></li>';
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
            <h4>File Repository</h4>
            <div class="row">
                <ul class="large-block-grid-6 small-block-grid-2">
                    <?php echo $menus; ?>
                    <li>
                        <a class="commands alert-box warning white" href="index.php">Home</a>
                    </li>
                    <li>
                        <a class="commands alert-box alert white" href="index.php?ptf=<?php echo returnHash($_SESSION['current-directory']) ?>">Reload</a>
                    </li>
                </ul>