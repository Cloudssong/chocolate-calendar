<?php
/**
 * @package ChocolateCalendar
 */
/*
Plugin Name: Chocolate-Calendar
Plugin URI: https://github.com/Cloudssong/plugins
Description: A calendar to plan them all.
Version: 1.0.0
Author: Alexander Kottisch
Author URI:https://github.com/Cloudssong
License: GPLv2 or later
Text Domain: chocolate-calendar
*/

//-----------------------------------------------------------Database------------------------------------------------------------------------------

// Creates new table for plugin onto activation
register_activation_hook( __FILE__, 'choc_crud_table' );
function choc_crud_table() {
    global $wpdb;
    // charset + collation --> e.g. utf8_general_ci 
    $charset_collate = $wpdb->get_charset_collate();
    // prefix set on WP-installation
    $table_name = $wpdb->prefix . "choc_meta";
    $sql = "CREATE TABLE `$table_name` (
        `date_id` int(11) NOT NULL,
        `date` varchar(220) DEFAULT NULL,
        `active` varchar(220) DEFAULT NULL,
        `dummy1` int(11) DEFAULT '1',
        PRIMARY KEY(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8_general_ci;
        ";
        // Only if table doesn't already exist
    if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name ) {
        // upgrade.php enables this file to upgrade the DB
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");
        // modifies the DB based on $sql
        dbDelta( $sql );
    }
}

//------------------------------------------------------Create Admin Page--------------------------------------------------------------------------

// adds admin menu
add_action( 'admin_menu', 'add_choc_admin_page' );

// defines the admin page (npage-title / menu-title / capability / slug / function / icon-url (/ position) )
function add_choc_admin_page() {
    add_menu_page( 'Chocolate Calendar', 'Chocolate Calendar', 'manage_options', __FILE__, 'choc_admin_page', 'dashicons-calendar-alt' );
}

// TODO: basically the content of the admin page (??)
function choc_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . "choc_meta";
    echo 'Still alive!';
}

//-----------------------------------------------------------Require------------------------------------------------------------------------------

function choc_calendar_styles() {
    // call jquery (already registered by default, but better use google ajax lib)
 /*    wp_deregister_script('jquery');
	wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js', false, '1.3.2', true);  */
	wp_enqueue_script('jquery');

    // register scripts and styles
    wp_register_script( 'script_to_moment', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js', false, false, false );
    wp_register_script( 'script_to_jquery_ui', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', false, false, false );
    wp_register_script( 'choc_calendar_script', plugin_dir_url( __FILE__ ) . 'choc-calendar.js' );
    wp_register_style( 'choc_calendar_styles', plugin_dir_url( __FILE__ ) . 'choc-calendar.css' );
    
    // call scripts and styles
    wp_enqueue_script( 'script_to_moment' );
    wp_enqueue_script( 'script_to_jquery_ui' );
    wp_enqueue_script( 'choc_calendar_script' );
    wp_enqueue_style( 'choc_calendar_styles' );
}
add_action( 'admin_enqueue_scripts', 'choc_calendar_styles' );

include ( 'choc-functions.php' );

//--------------------------------------------------------Calendar-Class---------------------------------------------------------------------------

?>
<br>
<?php
class Choc_Calendar {
    private $month;
    private $year;
    private $days_of_week;
    private $num_days;
    private $date_info;
    private $day_of_week;

    public function __construct( $month, $year, $days_of_week = array ('So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa' ) ) {
        $this->month = $month;
        $this->year = $year;
        $this->days_of_week = $days_of_week;
        $this->num_days = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
        $this->date_info = getdate(strtotime('first day of', mktime(0,0,0,$this->month, 1, $this->year)));
        $this->day_of_week = $this->date_info['wday'];
    }

    public function show() {
        // Month and year caption
        $output = '<table class="calendar">';
        $output .= '<caption>' . $this->date_info['month'] . ' ' . $this->year . '</caption';
        $output .= '<tr>';

        // Days of the week header
        foreach ($this->days_of_week as $day) {
            $output .= '<th class="header">' . $day . '</th>';
        }

        // Close header row and open first row of days
        $output .= '</tr><tr>';

        // If first day of a month does not fall on a Sunday -> fill the space with colspan
        if ( $this->day_of_week > 0 ) {
            $output .= '<td colspan=""' . $this->day_of_week . '"></td>';
        }

        // Start numdays counter
        $current_day = 1;

        // Loop and build days
        while ( $current_day <= $this->num_days ) {
            // Reset 'day of week' counter and close row if end of row
            if ( $this->day_of_week == 7 ) {
                $this->day_of_week = 0;
                $output .= '</tr><tr>';
            }

            // Build each days cell
            $output .= '<td class="day">' . $current_day . '</td>';

            // Increment counters
            $current_day++;
            $this->day_of_week++;
        }

        // Once num_days counter stops, if day or week counter is not 7 -> fill the space with colspan
        if ($this->day_of_week != 7) {
            $remaining_days = 7 - $this->day_of_week;
            $output .= '<td colspan = ""' . $remainin_days . '"></td>';
        }

        // Close final row and table
        $output .= '</tr>';
        $output .= '</table>';

        // Output calendar
        return $output;
    }
}

add_action('admin_init',function() {
    $c = new Choc_Calendar( 3, 2019 );
});