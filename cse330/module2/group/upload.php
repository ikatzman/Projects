<?php
 //begin session
 session_start();

 //comes from the chosen file from fileview.php, used wiki for help
 $filename = basename($_FILES['uploaded']['name']);
 if(!preg_match('/^[\w_\.\-]+$/', $filename)) {
   echo "Invalid Filename";
   header("Location: failure.html");
   exit;
 }

 //checks for valid username, used wiki for help
 $username = $_SESSION['username'];
  if( !preg_match('/^[\w_\-]+$/', $username) ) {
    echo "Invalid username";
    header("Location: failure.html");
    exit;
 }

 //creates a variable that contains the full file path to upload the file to, used wiki for help
 $full_path = sprintf("/home/ikatzman/mod2/%s/%s", $username, $filename);

 //if the file is successfully uploaded, go to success page, otherwise go to failure page, used wiki for help
 if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $full_path) ) {
   header("Location: success.html");
   exit;
 }
 else {
   header("Location: failure.html");
   exit;
 }
?>
