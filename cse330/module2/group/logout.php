<?php
  //Start session
  session_start();

  //Destroy the current session
  session_destroy();

  //Redirect to login page
  header("Location: loginsite.html");
  exit;
?>
