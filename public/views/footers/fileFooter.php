
                <div id="upload-file" class="reveal-modal small-modal" data-reveal>
                    <form  action="utilities/uploadFile.php" method="post" enctype="multipart/form-data">
                        Please choose a file: 
                        <input type="file" name="uploadFile"><br>
                        <input class="alert-box success" type="submit" value="Upload File">
                    </form>
                    <a class="close-reveal-modal">&#215;</a>
                </div> 
                <div id="folder-name" class="reveal-modal small-modal" data-reveal>
                    <form  action="utilities/addFolder.php" method="post">
                        <input type="text" name="folderName" autofocus>
                        <input class="alert-box secondary" type="submit" value="Add Folder">
                    </form>
                    <a class="close-reveal-modal">&#215;</a>
                </div>
            </div> <!-- row -->
        </div> <!-- content-wrapper -->
        <footer>
            <center>St. John Fisher College</center>
        </footer>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/foundation.min.js"></script>
        <script>
            $(document).foundation();
        </script>
        <script>
            $(document).ready(function(){
                $("#upload-message").delay(5000).fadeOut("slow");
                $("#folder-message").delay(5000).fadeOut("slow");
                $("#delete-message").delay(5000).fadeOut("slow");
                $("#replace-message").delay(5000).fadeOut("slow");
                $("#move-message").delay(5000).fadeOut("slow");
            });
        </script>
    </body>
</html>