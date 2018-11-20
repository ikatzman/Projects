<?php
  //Session starts
  session_start();

  //Get the file name from the view button
  $filename = $_GET['file'];

  //Check for valid filename
  if(!preg_match('/^[\w_\.\-]+$/', $filename)){
    echo "Invalid Filename";
    exit;
  }

  //Check for valid username
  $username = $_SESSION['username'];
  if( !preg_match('/^[\w_\-]+$/', $username) ){
	  echo "Invalid username";
	  exit;
  }

  //full filepath to view file
  $full_path = sprintf("/home/ikatzman/mod2/%s/%s", $username, $filename);

  //Got from the Wiki
  $finfo = new finfo(FILEINFO_MIME_TYPE);
  $mime = $finfo->file($full_path);

  //Got from the PHP manual: http://www.php.net/manual/en/function.readfile.php
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Type: application/pdf');
  header('Content-Disposition: attachment; filename="'.basename($filename).'"');
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  readfile($full_path);
  exit;
?>
