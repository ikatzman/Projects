<?php
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

ini_set("session.cookie_httponly", 1);
session_start();
//if a user is not logged in or username is blank, fail
if (!array_key_exists("username", $_SESSION) || $_SESSION["username"] == "") {
    echo json_encode(array(
        "success" => false
    ));
    exit;
}

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//from wiki
$eventTime = $json_obj["eventTime"];
$eventDate = $json_obj["eventDate"];
$eventTitle = $json_obj["eventTitle"];
$eventText = $json_obj["eventText"];

//token
// $eventToken = $json_obj["eventToken"];

// if(!hash_equals($_SESSION['token'], $eventToken)){
//     echo json_encode(array(
//         "success" => false
//     ));
//     exit;
// }

//set session variable for username
$username = $_SESSION["username"];

//use calendar databse
require 'calendar_db.php';

//insert event info from menu into events mysql db
$stmt = $mysqli->prepare("insert into events (owner, event_details, event_time, event_date, event_title) values (?, ?, ?, ?, ?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    echo json_encode(array(
        "success" => false
    ));
    exit;
}

$stmt->bind_param('sssss', $username, $eventText, $eventTime, $eventDate, $eventTitle);
$stmt->execute();
$stmt->close();

//if a user is logged in and the stmt doesnt fail, json is success
echo json_encode(array(
    "success" => true
));
?>
