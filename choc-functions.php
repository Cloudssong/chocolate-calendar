<?php
//---------------------------------------------------Navigate to 'today'---------------------------------------------------------------------------



//----------------------------------------------------Show the timeslots---------------------------------------------------------------------------


//----------------------------------------------------Feedback for AJAX---------------------------------------------------------------------------



function chocAjax() { 
    // Checking the nonce
    // check_ajax_referer( 'choc_nonce' ); TODO: Nonce not working (error)

    // TODO: Here comes the INSERT or UPDATE
    
    $response[ 'success' ] = true;

    // Echo what was saved in JSON and shut down
    $response = json_encode( $response );
    echo $response;
    die();
}

// If logged in site
add_action( 'wp_ajax_chocAjax', 'chocAjax' );
// If not loged in site
add_action( 'wp_ajac_nopriv_chocAjax', 'chocAjax');