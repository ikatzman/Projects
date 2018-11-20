<?php

  echo "<link rel='stylesheet' type='text/css' href='newsite.css'/>";
  //Start session
  session_start();

  require 'database.php';

  //gather all necessary data either from POST or SESSION
  $title = $_POST['title'];
  $composition = $_POST['composition'];
  $username = $_SESSION['user_id'];
  $link = $_POST['link'];
  $new_story_id;
  
  //insert into database
  $insert_stmt = $mysqli->prepare("insert into stories (owner, title, contents, link) values (?, ?, ?, ?)");

  if(!$insert_stmt){
	   printf("1Query Prep Failed: %s\n", $mysqli->error);
	    exit;
  }

  $insert_stmt->bind_param('ssss', $username, $title, $composition, $link);
  $insert_stmt->execute();
  $insert_stmt->close();

  header("Location: newshomepage.php");
?>
