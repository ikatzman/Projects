<?php
  session_start();
  require 'database.php';
  $username = $_SESSION['user_id'];
  $story_id = $_POST['likesid'];
  $likes = $_POST['likes'];
  $hold = True;

  if (!array_key_exists('user_id', $_SESSION)){
    header("Location: newsfailure.html");
    $hold = False;
  }

  if($hold){
    $user_id = $_SESSION['user_id'];

    $likes++;

    $stmt = $mysqli->prepare("update stories set likes=? WHERE story_id=?");

    $stmt->bind_param('ss', $likes, $story_id);
    $stmt->execute();
    $stmt->close();

    echo $username;
    header("Location: storyview.php");
  }
  else{
    header("Location: newsfailure.html");
  }
?>
