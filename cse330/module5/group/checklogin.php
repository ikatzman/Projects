<?php
  //Checks for and sets session cookie variable for login
  ini_set("session.cookie_httponly", 1);
  session_start();
  if(isset($_SESSION['token'])){
    echo json_encode(array(
  		"success" => true,
      "token" => $_SESSION['token']
  	));
  	exit;
  }else{
  	echo json_encode(array(
  		"success" => false,
  	));
  	exit;
  }
  ?>
