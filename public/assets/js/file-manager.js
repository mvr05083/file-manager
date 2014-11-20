jQuery(document).ready( function() {
    
    //Initiate Foundation
    jQuery(document).foundation();
    
    //Handle Home button
    jQuery(document).on("click", "#mkfm-home",  function() {
        jQuery("#messages").html("").show();
        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : {action: "mkfm_refresh_list"},
            success: function(response) {
                jQuery("#output").html(response);
            }
        });  
        jQuery("#messages").delay(2000).fadeOut("slow");
    });
    
    //Handle refreshing list, and folder navigation
    // TODO: determine better element stucture to encapulate all clicks
    jQuery(document).on("click", ".folder img, .breadcrumb-link, #mkfm-refresh",  function(event) {
        var path = '';
        if ( event.target.getAttribute('value') != null || event.target.getAttribute('value') != undefined ) {
            path = event.target.getAttribute('value');
        } 
        
        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : {action: 'mkfm_refresh_list', 
                    path_id: path},
            success: function(response) {
                jQuery("#output").html(response);
                jQuery("#mkfm-refresh").attr("value", path);
            }
        });  
    });    
    
    //Handle Add Folder
   jQuery(document).on("click", "#mkfm-add-folder-submit",  function() {
        var folder_name = jQuery("#mkfm-add-folder-text-box").val();
        
        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : {action: 'mkfm_add_folder', 
                    new_folder_name : folder_name},
            success: function(response) {
                jQuery("#messages").html(response);
                jQuery('#mkfm-add-folder-text-box').val('');
           
            }
        });  
    });  
    
    
    //Handle File Uploads
//    jQuery('#upload-form').on('submit', function(event){
//       
//        var fd = new FormData();
//        fd.append('files', event.target.files);
//        jQuery.ajax({
//            type: 'POST',
//            url: myAjax.ajaxurl,
//            data: {action: 'mkfm_upload_file', 
//                    file : fd},
//            processData: false,
//            contentType: false,
//            success: function(response) {
//                
//                jQuery("#messages").html(response);
//                jQuery('#mkfm-add-folder-text-box').val('');
//                alert("finished");
//           
//            }
//        });
//    });
//    jQuery(document).on("click", "#mkfm-upload-file-submit",  function(event) {
//        event.preventDefault();
//        var fileIn = jQuery("#fileToUpload")[0];
//        //Has any file been selected yet?
//        if (fileIn.files === undefined || fileIn.files.length == 0) {
//            alert("Please select a file");
//            return;
//        }
//
//        //We will upload only one file in this demo
//        var file = fileIn.files[0];
//        //Show the progress bar
//        jQuery("#progressbar").show();
//
//        jQuery.ajax({
//            url: myAjax.ajaxurl,
//            type: "POST",
//            data: {
//                 action: 'mkfm_upload_file',
//                 data: file
//            },
//            processData: false, //Work around #1
//            contentType: file.type, //Work around #2
//            success: function(response){
//                jQuery("#messages").html(response);
//            },
//            error: function(){alert("Failed");},
//            //Work around #3
//            xhr: function() {
//                myXhr = jQuery.ajaxSettings.xhr();
//                if(myXhr.upload){
//                    myXhr.upload.addEventListener('progress',showProgress, false);
//                } else {
//                    console.log("Uploadress is not supported.");
//                }
//                return myXhr;
//            }
//        });
//
//    }); 

            var files;
 
            // Add events
            jQuery('input[type=file]').on('change', prepareUpload);

            // Grab the files and set them to our variable
            function prepareUpload(event)
            {
              files = event.target.files;
            }
            
            jQuery('form').on('submit', uploadFiles);
 
            // Catch the form submit and upload the files
            function uploadFiles(event)
            {
                event.stopPropagation(); // Stop stuff happening
                event.preventDefault(); // Totally stop stuff happening

                // START A LOADING SPINNER HERE
                console.log(files);
                // Create a formdata object and add the files
                var data = new FormData();
                jQuery.each(files, function(key, value)
                {
                    console.log(key + ": " + value);
                    data.append(key, value);
                });

                jQuery.ajax({
                    url: myAjax.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'mkfm_upload_file',
                        files: 'set',
                        data: data},
                    cache: false,
                    dataType: 'json',
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function(data, textStatus, jqXHR)
                    {
                        if(typeof data.error === 'undefined')
                        {
                            // Success so call function to process the form
                            console.log(data);
                            submitForm(event, data);
                        }
                        else
                        {
                            // Handle errors here
                            console.log('ERRORS: ' + data.error);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        // Handle errors here
                        console.log('ERRORS: ' + textStatus);
                        // STOP LOADING SPINNER
                    }
                });
            }
            
            function submitForm(event, data)
            {
              // Create a jQuery object from the form
                jQueryform = jQuery(event.target);

                // Serialize the form data
                var formData = jQueryform.serialize();
                
                // You should sterilise the file names
                jQuery.each(data.files, function(key, value)
                {
                    formData = formData + '&filenames[]=' + value;
                });

                jQuery.ajax({
                    url: myAjax.ajaxurl,
                    type: 'POST',
                    data: {action: 'mkfm_upload_file',
                           formData:formData},
                    cache: false,
                    dataType: 'json',
                    success: function(data, textStatus, jqXHR)
                    {
                        if(typeof data.error === 'undefined')
                        {
                            // Success so call function to process the form
                            console.log('SUCCESS: ' + data.success);
                        }
                        else
                        {
                            // Handle errors here
                            console.log('ERRORS: ' + data.error);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        // Handle errors here
                        console.log('ERRORS: ' + textStatus);
                    },
                    complete: function()
                    {
                        // STOP LOADING SPINNER
                    }
                });
            }

});