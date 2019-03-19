//----------------------------------------------------Add Calendar JS------------------------------------------------------------------------------

// letzen Monat anzeigen

// nächsten Monat anzeigen

// Eventclicker for each day -> change class and add into/ delete from DB

// To avoid the jQuery-conflict in WP
var $ = jQuery;


jQuery(document).ready(function() {
	// When clicked on a day inside of the calendar
	jQuery("#chocToggle .day").on("click", function() {
		// Substitute to make it easier to code
		var me = jQuery(this);
		// Get the custom data-attribute
		var myDate = me.data("mydate");
		console.log(myDate);
		jQuery.ajax({
			// Setting to admin-ajax.php - The way WP wants it
			url: choc_calendar_globals.ajax_url,
			method: "GET", // TODO: POST oder GET ??
			datatype: 'json', // TODO: Wird per Json übergeben ??
			// Start our saving function and check the nonce
			data: {action: 'chocAjax',
					_ajax_nonce: choc_calendar_globals.choc_nonce },
			// If successful, add the class
			success: function(response) {
				me.toggleClass("active");
				console.log("kaching");
				// alert( 'Date added into or removed from Database!' ) // TODO: Uncomment this line once the AJAX is working !! 
				// jQuery("#inserted").html(response.kaching);
		},
		// If not, tell us it's not working 
		error: function(response){
			console.log("error");
			// alert( 'Date could not be updated!' ) // TODO: Uncomment this line once the AJAX is working !! 
		}
		});
		// click
	});
	// ready
});

// me.hasClass("active"

// TODO: Hot to implement #inserted -> overlay with 'Day is now active'?
