<?php
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);
ini_set("session.cookie_httponly", 1);
session_start();
//Variables can be accessed as such:
$eventid = $json_obj['eventid'];
//This is equivalent to what you previously did with $_POST['username'] and $_POST['password']

require 'calendar_db.php';

$hold = true;

// //if a user is not logged in or username is blank, fail
if (!array_key_exists("username", $_SESSION) || $_SESSION["username"] == "") {
     echo json_encode(array(
         "success" => false
     ));
     exit;
}

//do stuff
$stmt = $mysqli->prepare("delete from events where event_id=?");

if(!$stmt){
     printf("Query Prep Failed: %s\n", $mysqli->error);
     $hold = false;
     exit;
 }
// Bind the parameter
$stmt->bind_param('s', $eventid);

$stmt->execute();

if($hold){
  echo json_encode(array(
      "success" => true,
      "eventid" => $eventid
  ));
}
else{
  echo json_encode(array(
      "success" => false
  ));
}

?>
