jQuery(document).ready( function() {
     
    jQuery(document).on("click", "#mkfm-refresh",  function() {
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
    jQuery(document).on("click", ".folder img",  function(event) {
        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : {action: 'mkfm_refresh_list', path_id: event.target.getAttribute("value")},
            success: function(response) {
                jQuery("#output").html(response);
            }
        });  
    });  
    
    jQuery(document).on("click", ".file", function( event ) {
        alert(event.target.innerHTML);
    });     

});