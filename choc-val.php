<?php
/* header( 'Access-Control-Allow-Origin: *' );
header( 'Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept' );
header( 'Content-Type:application/json' ); */



// here happens the validation

// fetch $_GET -> Variablename from ajax call
//echo $_GET['test'];

echo json_encode(['kaching' => 'gotcha']);

// add_action('wp_ajax_chocToggle', 'choc-val.php');