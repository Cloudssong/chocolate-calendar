<?php

//----------------------------------------------------Form validation------------------------------------------------------------------

$choc_validator = new GUMP();

// Sanitize the Post
$_POST = $choc_validator->sanitize($_POST);
// Define rules and filters
$rules = array(
    'name' => 'required|valid_name|min_len,2|max_len,50',
    'email' => 'required|valid_email|min_len,6'
    'comment' => 'max_len,255'
);
$filters = array(
    'name' => 'trim|sanitize_string',
    'email' => 'trim|sanitize_email',
    'comment' => 'trim|sanitize_string'
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
