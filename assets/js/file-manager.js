jQuery(document).ready( function() {

   jQuery("#refresh-me").click( function() {
       
      jQuery.ajax({
         type : "post",
         dataType : "json",
         url : myAjax.ajaxurl,
         data : {action: "refresh_list"},
         success: function(response) {
            jQuery("#output").html("Folders:<br />");
            jQuery("#output").append(response.folders);
            jQuery("#output").append("Files:<br />");
            jQuery("#output").append(response.files);
         }
      });  
       
   });
    
});