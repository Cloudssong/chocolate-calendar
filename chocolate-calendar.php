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


function choc_calendar_styles() {
    // call jquery (already registered by default)
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
add_action( 'admin_print_styles', 'choc_calendar_styles' );

?>
<br>
<?php
class Choc_Calendar {

    public function __construct($year = '', $month = '') {

        $date = time();

        if (empty($year) OR empty($month)) {
            $year = date('Y', $date);
            $month = date('m', $date);
            $day = date('d', $date);
        }

        $first_day = mktime(0, 0, 0, $month, 1, $year);
        $title = date('F', $first_day);
        $day_of_week = date('D', $first_day);

         switch ($day_of_week) {
            case "Mon": $blank = 0;
                break;
            case "Tue": $blank = 1;
                break;
            case "Wed": $blank = 2;
                break;
            case "Thu": $blank = 3;
                break;
            case "Fri": $blank = 4;
                break;
            case "Sat": $blank = 5;
                break;
            case "Sun": $blank = 6;
                break;
        }

        $days_in_month = cal_days_in_month(0, $month, $year);

        echo '<table border=1 width=394>';

        echo '<tr>';
        echo '<th colspan=60>' . $title . ' ' . $year . '</th>';
        echo '</tr>';

        echo '<tr>';
        echo '<td width=62>Mon</td>';
        echo '<td width=62>Tue</td>';
        echo '<td width=62>Wed</td>';
        echo '<td width=62>Thu</td>';
        echo '<td width=62>Fri</td>';
        echo '<td width=62>Sat</td>';
        echo '<td width=62>Sun</td>';
        echo '</tr>';

        $day_count = 1;

        while ($blank > 0) {
            echo '<td></td>';
            $blank = $blank - 1;
            $day_count++;
        }

        $day_num = 1;

        while ($day_num <= $days_in_month) {

            echo '<td>' . $day_num . '</td>';
            $day_num++;
            $day_count++;

            if ($day_count > 7) {
                echo '</tr><tr>';
                $day_count = 1;
            }
        }

        while ($day_count > 1 && $day_count <= 7) {
            echo '<td> </td>';
            $day_count++;
        }

        echo '</tr>';

        echo '</table>';
    }

}

$c = new Choc_Calendar(2019, 3);