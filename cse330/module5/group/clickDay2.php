<?php
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

$day = $json_obj['day'];
$month = $json_obj['month'];
$year = $json_obj['year'];

//This is equivalent to wh
ini_set("session.cookie_httponly", 1);
session_start();

$username = $_SESSION['username'];
require 'calendar_db.php';
$hold = true;

//initialize array to use to store values from db
$array = array();

//make string so that the date is usable to compare
$dateinfo = $year . "-" . $month . "-" . $day;

//select events to display
$stmt = $mysqli->prepare('select event_details, event_time, event_id, event_date, event_title from events where owner = ? and event_date = ?');

if(!$stmt){
     printf("Query Prep Failed: %s\n", $mysqli->error);
     $hold = false;
 }

$stmt->bind_param('ss', $username, $dateinfo);
$stmt->execute();
$stmt->bind_result($event_details, $event_time, $event_id, $event_date, $event_title);

//add each binded result to an array that will be sent back thru json
while($stmt->fetch()){
  $temp_arr = [$event_details, $event_time, $event_id, $event_date, $event_title];
  array_push($array, $temp_arr);
}

if($hold){
  echo json_encode(array(
      "success" => true,
      "arr" => $array
  ));
}
else{
  echo json_encode(array(
      "success" => false
  ));
}



?>
