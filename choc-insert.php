<?php
//----------------------------------------------------Insert into DB------------------------------------------------------------------------------

/* function choc_insert() {
    global $wpdb

    $date = $_POST["newDate"];
    $client = $_POST["newClient"];
    $wpdb->query("INSERT INTO $table_name ( date, client ) VALUES ( '$date', '$client' )");

}; */

/* 

function choc-insert() {
    global $wpdb;

    $meeting = Choc_Calendar::$current_day:
    $key = 'Key';

    $wpdb->insert( wp_postmeta, array (
        'meta_key' => $key,
        'meta_value' => $meeting
    ));
} */

?>


<!-- if(isset($_POST["title"]))
    {
    $query = "
    INSERT INTO events 
    (title, start_event, end_event) 
    VALUES (:title, :start_event, :end_event)
    ";
    $statement = $connect->prepare($query);
    $statement->execute(
    array(
    ':title'  => $_POST['title'],
    ':start_event' => $_POST['start'],
    ':end_event' => $_POST['end']
    )
    );
    }  -->