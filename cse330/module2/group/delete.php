<?php
  //Start session
  session_start();

  //Get the file from the delete button
  $filename = $_GET['file'];

  //The username is the session username
  $username = $_SESSION['username'];

  //Path is the full file path
  $path = sprintf("/home/ikatzman/mod2/%s/%s", $username, $filename);

  //If the deletion of the file works, redirect to success page, otherwise redirect to failure page
  if(unlink($path)){
    header("Location: success.html");
  }
  else{
    header("Location: failure.html");
  }
?>
