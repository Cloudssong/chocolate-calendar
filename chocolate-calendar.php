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

//-----------------------------------------------------------Require------------------------------------------------------------------------------

function choc_calendar_styles() {
    // Call jquery (already registered by default, but better use google ajax lib)
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

    // Localize a registered script with data for JS variables ( e.g. for localization, validation )
    // After register/enqueue
    // Handle, Name, Data
    wp_localize_script( 
        'choc_calendar_script',
        'choc_calendar_globals',
        [
            // setting AJAX-URL to better access it
            'ajax_url'  =>  admin_url( 'admin-ajax.php' ),
            // creating a Nonce for security
            'nonce'     =>  wp_create_nonce( 'choc_nonce' )
        ]
        );
    }
    add_action( 'admin_enqueue_scripts', 'choc_calendar_styles' );

    include ( 'choc-functions.php' );



//-----------------------------------------------------------Database------------------------------------------------------------------------------

// TODO: ADD INTO SENGERMED-DB!!
// Creates new table for plugin onto activation
register_activation_hook( __FILE__, 'choc_crud_table' );
function choc_crud_table() {
    global $wpdb;
    // Charset + collation --> e.g. utf8_general_ci 
    $charset_collate = $wpdb->get_charset_collate();
    // Prefix set on WP-installation
    $table_name = $wpdb->prefix . "choc_meta";
    $sql = "CREATE TABLE `$table_name` IF NOT EXISTS (
        `date_id` int(11) NOT NULL,
        `date` varchar(220) DEFAULT NULL, /* TODO: datetime(?) */
        `client` varchar(220) DEFAULT NULL,
        PRIMARY KEY(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8_general_ci;
        ";
    $wpdb->query( $sql );
} 

//------------------------------------------------------Create Admin Page--------------------------------------------------------------------------

// Adds admin menu
add_action( 'admin_menu', 'add_choc_admin_page' );

// Defines the admin page (npage-title / menu-title / capability / slug / function / icon-url (/ position) )
function add_choc_admin_page() {
    add_menu_page( 'Chocolate Calendar', 'Chocolate Calendar', 'manage_options', __FILE__, 'choc_admin_page', 'dashicons-calendar-alt' );
}

// Function for the content of the new admin page
function choc_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . "choc_meta";

//-----------------------------------------------------Content Admin Page--------------------------------------------------------------------------



    // TODO: ADD CALENDAR HERE??




    // Insert data onto submit
    if( isset($_POST[ "newSubmit" ])) {
        $date = $_POST["newDate"];
        $client = $_POST["newClient"];
        $wpdb->query("INSERT INTO $table_name ( date, client ) VALUES ( '$date', '$client' )");
        // automatically reload the page // TODO: AJAX!!
        echo "<script> location.replace('admin.php?page=chocolate-calendar%2Fchocolate-calendar.php');</script>";
    }

    // Update data onto submit (if the date_id is in the URL -> anchor)
    if( isset($_POST[ "updateSubmit" ])) {
        $id = $_POST["updateId"];
        $date = $_POST["updateDate"];
        $client = $_POST["updateClient"];
        $wpdb->query("UPDATE $table_name SET date='$date', client='$client' WHERE date_id='$id'");
        // automatically reload the page // TODO: AJAX!!
        echo "<script> location.replace('admin.php?page=chocolate-calendar%2Fchocolate-calendar.php');</script>";
    }

    // Delete data onto submit (if the date_id is in the URL -> anchor)
    if( isset($_GET["delete"])) {
        $delete_id = $_GET["delete"];
        $wpdb->query("DELETE FROM $table_name WHERE date_id='$delete_id'");
        // automatically reload the page // TODO: AJAX!!
        echo "<script> location.replace('admin.php?page=chocolate-calendar%2Fchocolate-calendar.php');</script>"; 
    }

    ?>

    <div class="wrap">
    <h2>Chocolate Calender CRUD</h2>
    <!-- using default WP CSS for the moment -->
    <table class="wp-list-table widefat striped">
        <thead>
            <tr>
                <th width="25%">Date_ID</th>
                <th width="25%">Date</th>
                <th width="25%">Client</th>
                <th width="25%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- empty action since we use same page to process the data -->
            <form action="" method="post">
                <tr>
                    <td>
                        <input type="text" value="AUTO_GENERATED" disabled>
                    </td>
                    <td>
                        <input type="text" name="newDate" id="newDate" placeholder="YYYY-MM-DD">
                    </td>
                    <td>
                        <input type="text" name="newClient" id="newClient">
                    </td>
                    <td>
                        <button type="submit" name="newSubmit" id="newSubmit">INSERT</button>
                    </td>
                </tr>
            </form>

            <?php
                $result = $wpdb->get_results( "SELECT * FROM $table_name" );
                // TODO: TABLE NEEDS TO BE CREATED
                foreach ( $result AS $print ) {
                    // TODO: HOW AND WHERE TO BEST USE MOMENT.JS
                    // Adds Anchors for UPDATE and DELETE
                    echo "
                        <tr>
                            <td width='25%'>$print->date_id</td>
                            <td width='25%'>$print->date</td>
                            <td width='25%'>$print->client</td>
                            <td width='25%'>
                                <a href='admin.php?page=chocolate-calendar%2Fchocolate-calendar.php&update=$print->date_id>
                                    <button type='button'>UPDATE</button>
                                </a>
                                <a href='admin.php?page=chocolate-calendar%2Fchocolate-calendar.php&delete=$print->date_id>
                                    <button type='button'>DELETE</button>
                                </a>
                            </td>
                        </tr>
                    ";
                }
            ?>

        </tbody>
    </table>
    <br><br>

    <?php
    // loads the results and is ready to update them - confirmation and cancel (remove date_id from URL) button included
    if(isset($_GET["update"])) {
        $update_id = $_GET["update"];
        $result = $wpdb->get_results( "SELECT * FROM $table_name WHERE data_id='update_id'" );
        foreach( $result AS $print ) {
            $date = $print->date;
            $client = $print->client;
        }
        echo "
        <table class='wp-list-table widefat striped'>
            <thead>
                <tr>
                    <th width='25%'>Date_ID</th>
                    <th width='25%'>Date</th>
                    <th width='25%'>Client</th>
                    <th width='25%'>Actions</th>
                </tr>
            </thead>
            <tbody>
                <form action='' method='post'>
                    <tr>
                        <td width='25%'>$print->date_id
                            <input type='hidden' name='updateId' id='updateId' value='$print->user_id>
                        </td>
                        <td width='25%'>
                            <input type='text' name='updateDate' id='updateDate' value='$print->date>
                        </td>
                        <td width='25%'>
                          <input type='text' name='updateClient' id='updateClient' value='$print->client>
                        </td>
                        <td width='25%'>
                            <button type='submit' name='updateSubmit' id='updateSubmit'>UPDATE</button>
                            <a href='admin.php?page=chocolate-calendar%2Fchocolate-calendar.php'>
                                <button type='button>CANCEL</button>
                            </a>
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>
        ";
    }

    ?>

    </div>

    <?php
}

//--------------------------------------------------------Calendar-Class---------------------------------------------------------------------------

require 'choc-calendar-fct.php';