jQuery(document).ready(function () {

    jQuery("#refresh-me").click(function () {

        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : {action: "refresh_list"},
            success: function(response) {
                var data = "<ul class='small-block-grid-3 medium-block-grid-4 large-block-grid-6'>";
                jQuery.each(response.folders, function( index, value ) {
                  data += value;
                });
                jQuery.each(response.files, function( index, value ) {
                  data += value;
                });
                data += "</ul>";
                jQuery("#output").html(data);
            }  
        });
    });

});