//----------------------------------------------------Add Calendar JS------------------------------------------------------------------------------

// letzen Monat anzeigen

// nächsten Monat anzeigen

// Eventclicker <td>
var $ = jQuery;

jQuery(document).ready(function() {
  jQuery("#chocToggle .day").on("click", function() {
    var me = jQuery(this);
    var myDate = me.data("mydate");
    console.log(myDate);
    me.toggleClass("active");
    jQuery.ajax({
      url: "this is the insert",
      method: "GET", // Muss GET/POST auslesen
      success: function(response) {
        jQuery("#inserted").html(response);
      }
    });

    if (jQuery(".active")) {
      me.removeClass("active");
    }
    // click
  });
  // ready
});

// TODO: Hot to implement #inserted -> overlay with 'Day is now active'?
