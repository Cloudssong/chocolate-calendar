<?php
//---------------------------------------------------Navigate to 'today'---------------------------------------------------------------------------



//----------------------------------------------------Show the timeslots---------------------------------------------------------------------------


//----------------------------------------------------Feedback for AJAX---------------------------------------------------------------------------


/* 
function chocAjax() { 
    // Checking the nonce
    check_ajax_referer( 'choc_nonce' );
    // die("xxx");
    // TODO: Here comes the INSERT or DELETE
    global $wpdb;
    $table_name = $wpdb->prefix . "choc_meta";
    $date = $_POST[ "myDate" ];
    $client = "to be added" ;

    if ( $wpdb->query("SELECT date FROM $table_name WHERE date = ' " . $date . " ' " )->num_rows > 0 ) {
        $wpdb->query("DELETE * FROM $table_name ( date, client ) WHERE date = ' " . $date . " ' ");
        echo 'Selected date deleted!';
    } else {
        $wpdb->query("INSERT INTO $table_name ( date, client ) VALUES ( '$date', '$client' )");
        echo 'Selected date added!';
    }

    $response[ 'success' ] = true;

    // Echo what was saved in JSON and shut down
    $response = json_encode( $response );
    echo $response;
    die();
} */

// If logged in site
// add_action( 'wp_ajax_chocAjax', 'chocAjax' );
// If not loged in site
// add_action( 'wp_ajax_nopriv_chocAjax', 'chocAjax');