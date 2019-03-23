<?php

//--------------------------------------------------Calendar validation------------------------------------------------------------------

$choc_validator = new GUMP();

// Sanitize the Post
$_POST = $choc_validator->sanitize($_POST);
// Define rules and filters
$rules = array(
    'date' => 'required|date|exact_len,10',
    'client' => 'valid_name|min_len,2'
);
$filters = array(
    'date' => 'trim|sanitize_string',  // might write own sanitize_date
    'client' => 'trim|sanitize_string'
);
// Filter the Post
$_POST = $choc_validator->filter($_POST, $filters);
// Validate Post
$validated = $choc_validator->validate($_POST, $rules);
// Check if Validation was successful
if($validated === TRUE) {
    // Can use Post safely
    echo "Successful Validation\n\n";
} else {
    // Use built in error message (get_readable_errors(boolean)) -> true => HTML, false => array
    echo "<div class='h'> There were errors with the data you provided \n";
    echo $choc_validator->get_readable_errors(true);
    echo "</div>";
}
