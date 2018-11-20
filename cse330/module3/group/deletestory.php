<?php

session_start();
//check if token is valid
if(!hash_equals($_SESSION['token'], $_POST['token'])){
  header("Location: newsfailure.html");
}
$username = $_SESSION["user_id"];
$author = $_POST['author'];
echo $username;
$hold = False;

//check if user owns the story
if($username != $author){
  header("Location: newsfailure.html");
}
else{
  $hold = True;
}

if($hold){
  require 'database.php';

  $id = $_POST['story_id'];
  echo $id;

  //delete all comments that user has
  //this needs to be done first because of foreign key restraints
  $stmt1 = $mysqli->prepare("delete from comments where story_id=?;");
  if(!$stmt1){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }

  $stmt1->bind_param('s', $id);

  $stmt1->execute();

  //next delete the story from story database
  $stmt = $mysqli->prepare("delete from stories where story_id=?;");
  if(!$stmt){
  	printf("Query Prep Failed: %s\n", $mysqli->error);
  	exit;
  }

  $stmt->bind_param('s', $id);

  $stmt->execute();

  $stmt->close();

  //redirect as necessary to show user success or failure
  header("Location: newssuccess.html");
}
else{
  header("Location: newsfailure.html");
}
?>
