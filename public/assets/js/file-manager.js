jQuery(document).ready( function() {
    jQuery(document).foundation();
    jQuery(document).on("click", "#mkfm-home",  function() {
        jQuery("#messages").html("").show();
        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : {action: "mkfm_refresh_list"},
            success: function(response) {
                jQuery("#output").html(response);
                jQuery("#messages").html("<div id='upload-message' class='alert-box success'>Refreshed</div>");
            }
        });  
        jQuery("#messages").delay(2000).fadeOut("slow");
    });
    //TODO: determine better element stucture to encapulate all clicks
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
                jQuery('#mkfm-refresh').trigger("click");
                jQuery('#mkfm-close-add-folder').trigger("click");
                jQuery("#messages").delay(2000).fadeOut("slow");
            }
        });  
    });   
});