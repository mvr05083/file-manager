jQuery( document ).ready(  function(  ) {
    
    // Initiate Foundation
    jQuery( document ).foundation(  );
    
    // Handle Home button
    jQuery( document ).on( "click", "#mkfm-home",  function( event ) {
        event.preventDefault(  );
        jQuery( "#messages" ).html( "" ).show(  );
        jQuery.ajax( {
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : {action: "mkfm_refresh_list"},
            success: function( response ) {
                jQuery( "#output" ).html( response );
                jQuery( "#mkfm-refresh" ).attr( "value", '' );
            },
            error: function ( response, error, erro2) {
                alert( "Failed" );
                console.log(response);
                console.log(error);
                console.log(erro2);
            }
        } );  
        jQuery( "#messages" ).delay( 2000 ).fadeOut( "slow" );
    } );
    
    // Handle refreshing list, and folder navigation
    // TODO: determine better element stucture to encapulate all clicks
    jQuery( document ).on( "click", ".folder img, .breadcrumb-link, #mkfm-refresh",  function( event ) {
        event.preventDefault(  );
        var path = '';
        if (  event.target.getAttribute( 'value' ) != null || event.target.getAttribute( 'value' ) != undefined  ) {
            path = event.target.getAttribute( 'value' );
        } 
        
        jQuery.ajax( {
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : {action: 'mkfm_refresh_list', 
                    path_id: path},
            success: function( response ) {
                jQuery( "#output" ).html( response );
                jQuery( "#mkfm-refresh" ).attr( "value", path );
            },
            error: function ( response, error, erro2 ) {
                alert("Failed: " + path );
                console.log(error);
                console.log(erro2);
            }
        } );  
    } );    
    
    // Handle Add Folder
    jQuery( document ).on( "click", "#mkfm-add-folder-submit",  function(  ) {
        var folder_name = jQuery( "#mkfm-add-folder-text-box" ).val(  );
        
        jQuery.ajax( {
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : {action: 'mkfm_add_folder', 
                    new_folder_name : folder_name,
                    security: myAjax.ajax_nonce
                   },
            success: function( response ) {
                jQuery( "#messages" ).show(  );
                jQuery( "#messages" ).html( response );
                jQuery( '#mkfm-add-folder-text-box' ).val( '' );
                jQuery( "#mkfm-close-upload-file" ).trigger( "click" );
                jQuery( "#mkfm-refresh" ).trigger( "click" );
                jQuery( "#messages" ).delay( 2000 ).fadeOut( "slow" );
            },
            error: function ( response, error, erro2 ) {
                alert( "Failed" );
                console.log(error);
                console.log(erro2);
                
            }
        } );  
    } );  
    
    // Handle File Uploads
    jQuery( document ).on( "click", "#mkfm-upload-file-submit",  function( event ) {
        event.preventDefault(  );
        console.log( jQuery( "#fileToUpload" )[0].files );
        if ( window.FormData ){
            var formdata = new FormData(  );
            formdata.append( 'files', jQuery( "#fileToUpload" )[0].files[0] );
            if ( formdata ){
                jQuery.ajax( {
                    url: myAjax.ajaxurl + "?action=mkfm_upload_file&security=" + myAjax.ajax_nonce,
                    type: "POST",
                    dataType: "json",
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function( response ){
                        jQuery( "#fileToUpload" ).replaceWith(  jQuery( "#fileToUpload" ).val( '' ).clone(  true  )  );
                        jQuery( "#messages" ).show(  );
                        jQuery( "#messages" ).html( response );
                        jQuery( "#mkfm-close-upload-file" ).trigger( "click" );
                        jQuery( "#mkfm-refresh" ).trigger( "click" );
                        jQuery( "#messages" ).delay( 2000 ).fadeOut( "slow" );
                    },
                    error: function( xhr ){
                        alert( "Failed: " + xhr.error );
                    }
                } )
            }
        } else {
            var response = "<div class='alert-box warning'>File was not uploaded. Please use a browser that supports HTML5 FormData object.</div>";
            jQuery( "#mkfm-close-upload-file" ).trigger( "click" );
            jQuery( "#messages" ).show(  );
            jQuery( "#messages" ).html( response );
        }
    } );
} );
