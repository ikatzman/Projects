<?php
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

// echo json_encode(array(
//   "success": false;
// ));

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
$array = array();

$dateinfo = $year . "-" . $month . "-" . $day;
//echo $day;
$stmt = $mysqli->prepare('select event_details, event_time, event_id, event_date, event_title from events where owner = ? and event_date = ?');

if(!$stmt){
     printf("Query Prep Failed: %s\n", $mysqli->error);
     echo json_encode(array(
      "success" => false
      ));     
      exit;
 }

 $stmt->bind_param('ss', $username, $dateinfo);

 $stmt->execute();

$stmt->bind_result($event_details, $event_time, $event_id, $event_date, $event_title);
while($stmt->fetch()){
 array_push($array, $event_details, $event_time, $event_id, $event_date, $event_title);
}

echo json_encode(array(
    "success" => $array,
));

if($hold){
  echo json_encode(array(
      "success" => $array,
  ));
}
else{
  echo json_encode(array(
      "success" => false
  ));
}



?>
