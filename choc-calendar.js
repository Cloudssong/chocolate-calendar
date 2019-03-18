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
      url: "/localhost/mysite/wp-content/plugins/chocolate-calendar/choc-val.php",
	  method: "GET", // Muss GET/POST auslesen
	  data: {name: 'this'},
      success: function(response) {
		  console.log(response);
		//jQuery("#inserted").html(response.lol);
	  },
	  error: function(response){
		  console.log("error");
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
