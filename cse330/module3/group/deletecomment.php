<?php

session_start();

//check if user is logged in and if token is valid
if (!array_key_exists('user_id', $_SESSION)) header("Location: newsfailure.html");
if(!hash_equals($_SESSION['token'], $_POST['token'])){
  header("Location: newsfailure.html");
}

$username = $_SESSION["user_id"];
$commenter = $_POST['commenter'];
$hold = False;

//check if user owns the comment
if($username != $commenter){
  header("Location: newsfailure.html");
}
else{
  $hold = True;
}

if($hold){
  require 'database.php';

  $id = $_POST['comment_id'];

  //delete comment from database
  $stmt = $mysqli->prepare("delete from comments where comment_id=?;");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }

  $stmt->bind_param('s', $id);

  $stmt->execute();

  $stmt->close();

  //alert user of success or failure
  header("Location: newssuccess.html");
}
else{
  header("Location: newsfailure.html");
}
?>
