<?php
  //Start session
  session_start();

  //Filename gotten from Move button on fileview, username1 is the user's username, username2 is the user the file will be transferred to
  $filename = $_GET['transfer'];
  $username1 = $_SESSION['username'];
  $username2 = $_GET['move'];

  //full_path1 is the original path file, full_path2 is the new desired path file
  $full_path1 = sprintf("/home/ikatzman/mod2/%s/%s", $username1, $filename);
  $full_path2 = sprintf("/home/ikatzman/mod2/%s/%s", $username2, $filename);

  //Used the PHP manual to learn how to use rename, which moves a file from an old file path to a new one
  if(rename($full_path1, $full_path2)){
    header("Location: success.html");
    exit;
  }
  else {
    header("Location: failure.html");
    exit;
  }
?>
