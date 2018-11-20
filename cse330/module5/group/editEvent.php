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

$hold = true;

$username = $_SESSION['username'];
//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//get edited values
$editEventID = $json_obj["editEventID"];
$editEventTime = $json_obj["editEventTime"];
$editEventDate = $json_obj["editEventDate"];
$editEventTitle = $json_obj["editEventTitle"];
$editEventText = $json_obj["editEventText"];

$username = $_SESSION["username"];

require 'calendar_db.php';

//these if statements check whether or not the edit event fields have any values,
//and based on that decide what to do
if($editEventText != null){
  $stmt = $mysqli->prepare("update events set event_details = ? where event_id = ? and owner = ?");
  if(!$stmt){
    echo json_encode(array(
        "success" => false
    ));
   }
  $stmt->bind_param('sss', $editEventText, $editEventID, $username);
  $stmt->execute();
  $stmt->close();
}
if($editEventDate != null){
  $stmt = $mysqli->prepare("update events set event_date = ? where event_id = ? and owner = ?");
  if(!$stmt){
    echo json_encode(array(
        "success" => false
    ));
   }
  $stmt->bind_param('sss', $editEventDate, $editEventID, $username);
  $stmt->execute();
  $stmt->close();
}
if($editEventTitle != null){
  $stmt = $mysqli->prepare("update events set event_title = ? where event_id = ? and owner = ?");
  if(!$stmt){
    echo json_encode(array(
        "success" => false
    ));
   }
  $stmt->bind_param('sss', $editEventTitle, $editEventID, $username);
  $stmt->execute();
  $stmt->close();
}
if($editEventTime != null){
  $stmt = $mysqli->prepare("update events set event_time = ? where event_id = ? and owner = ?");
  if(!$stmt){
    echo json_encode(array(
        "success" => false
    ));
   }
  $stmt->bind_param('sss', $editEventTime, $editEventID, $username);
  $stmt->execute();
  $stmt->close();
}

if($hold){
  echo json_encode(array(
      "success" => true
  ));
}

?>
