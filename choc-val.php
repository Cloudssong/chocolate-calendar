<?php
header( 'Access-Control-Allow-Origin: *' );
header( 'Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept' );
header( 'Content-Type:application/json' );
// here happens the validation

// fetch $_GET -> Variablename from ajax call
//echo $_GET['test'];

var_dump(true);

add_action('wp_ajax_myform', 'choc-val.php');
//echo json_encode(['lol' => 'lul']);