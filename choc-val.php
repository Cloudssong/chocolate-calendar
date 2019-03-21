<?php
/* header( 'Access-Control-Allow-Origin: *' );
header( 'Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept' );
header( 'Content-Type:application/json' ); */



// here happens the validation

// fetch $_GET -> Variablename from ajax call
//echo $_GET['test'];

echo json_encode(['kaching' => 'gotcha']);

// add_action('wp_ajax_chocToggle', 'choc-val.php');


//----------------------------------------------------------------Validates the Calendar---------------------------------------------------------------------------------
$chocDate = [
    'myDate' => [
        'required' => true,
        
    ]
]


//-------------------------------------------------------------------Validates the Form---------------------------------------------------------------------------------

// Legt uns ein 
$chocFormFields = [
    'name' => [
        'required' => true,
        'dataType' => 'text',
        'min_len' => 2,
        'max_len' => 50
    ],
    'email' => [
        'required' => true,
        'dataType' => 'email',
        'min_len' => 2
    ]
    'textarea' => [
        'required' => false,
        'dataType' => 'text',
        'max_len' => 255
    ]
];

// Saves our error messages in here
$errors = [];
$chocFormOK = false;


 // Formular validieren
if (!empty($_POST)) {
    foreach($chocFormFields as $chocField => $config) {
        // Null coalescing operator -> like if/else
        $chocVal = $_POST[$fieldName] ?? ''; 
        $fieldOK = false;
        
        // Check required (is it required? is it empty?)
        if ($config['required'] == true && checkRequired($chocVal) == false) {
            $errors[$chocField] = "$chocField muss ausgefüllt werden.";
            continue;
        } // If not required and empty, end this validation
        elseif (!$config['required'] && $chocVal == '') {
            continue;
        }
        
        // Datatyp validation
        $dataTypeOK = false;
        
        switch ($config['dataType']) {
            /* case 'text':
                if (checkText) {

                }
                else {

                } */
            break;
            case 'email':
                if (checkEmail($chocVal) == false) {
                    $errors[$chocField] = "$chocField muss eine E-Mail Adresse enthalten.";
                }
                else {
                    $dataTypeOK = true;
                }
            break;
            default: 
                // Escape < and > and add them as HTML
                $chocVal = htmlspecialchars($chocVal);
                $dataTypeOK = true;
        }
        
        // End validation if datatype is not okay
        if(!$dataTypeOK) {
            continue;
        }

        // Min/Max validation
        $min = $config['min'] ?? '';
        $max = $config['max'] ?? '';
        $min_len = $config['min_len'] ?? '';
        $max_len = $config['max_len'] ?? '';

        // If both min and max are added, value has to be in between
        if ($min != '' && $max != '') {
            if ($chocVal < $min || $chocVal > $max) {
                $errors[$chocField] = "$chocField darf mindestens $min und höchstens $max sein.";
                continue;                
            }
        }
        
        // Digit - Minimum
        if ($min != '') {
            if ($chocVal < $min) {
                $errors[$chocField] = "$chocField muss mindestens $min sein.";
                continue;
            }
        }
        
        // Digit - Maximum
        if ($max != '') {
            if ($chocVal > $max) {
                $errors[$chocField] = "$chocField darf höchstens $max sein.";
                continue;
            }
        }


        // String length
        if ($min_len != '' && $max_len != '') {
            if (strlen($chocVal) < $min_len || strlen($chocVal) > $max_len) {
                $errors[$chocField] = "$chocField muss mindestens $min_len und höchstens $max_len Zeichen enthalten.";
                continue;                
            }
        }
        // Minimum length
        if ($min_len != '') {
            if (strlen($chocVal) < $min_len) {
                $errors[$chocField] = "$chocField muss mindestens $min_len Zeichen enthalten.";
                continue;
            }
        }
        // Maximum length
        if ($max_len != '') {
            if (strlen($chocVal) > $max_len) {
                $errors[$chocField] = "$chocField darf höchstens $max_len Zeichen enthalten.";
                continue;
            }
        }
    }

    // Wenn nirgendswo Fehler -> Form ist fertig validiert
    if (empty($errors)) {
        $formOK = true;
    }
}
