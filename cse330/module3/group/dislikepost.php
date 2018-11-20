<?php
  session_start();
  require 'database.php';
  $story_id = $_POST['dislikesid'];
  $dislikes = $_POST['dislikes'];
  $hold = True;

  if (!array_key_exists('user_id', $_SESSION)){
    header("Location: newsfailure.html");
    $hold = False;
  }

  if($hold){
    $user_id = $_SESSION['user_id'];

    $dislikes++;

    $stmt = $mysqli->prepare("update stories set dislikes=? WHERE story_id=?");

    $stmt->bind_param('ss', $dislikes, $story_id);
    $stmt->execute();
    $stmt->close();

    echo $username;
    header("Location: storyview.php");
  }
  else{
    header("Location: newsfailure.html");
  }
?>
