<?php
  //Used the PHP manual for help

  //User inputs new username
  $newusername = $_GET['newusername'];

  //If mkdir is successful and a new user folder is created, 
  if (mkdir("/home/ikatzman/mod2/".$newusername, 0777)){
      $filepath = "/home/ikatzman/mod2/users.txt";
      $filehandle = fopen($filepath, "a");
      fwrite($filehandle, $newusername."\n");
      fclose($filehandle);
      header("Location: loginsite.html");
  }
  else {
    header("Location: failure.html");
  }
?>
