<?php
// Here comes the awesome shortcode

function choc_frontend_calendar() {
    // Create Calendar-fct
    return 'This will create a calendar in case you call this Shortcode!';
}
add_shortcode('choc_cal', 'choc_frontend_calendar')

?>