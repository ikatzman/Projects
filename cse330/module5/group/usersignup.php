<?php
// login_ajax.php

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//Variables can be accessed as such:
$new_username = $json_obj['new_username'];
$new_password = $json_obj['new_password'];
//This is equivalent to what you previously did with $_POST['username'] and $_POST['password']

// Check to see if the username and password are valid.  (You learned how to do this in Module 3.)
require 'calendar_db.php';

//hash the new password
$hash = password_hash($new_password, PASSWORD_BCRYPT);

//insert data into users table in mysql
$stmt = $mysqli->prepare("insert into users (username, password_hash) values (?, ?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('ss', $new_username, $hash);
$stmt->execute();
$stmt->close();

if($new_password != ""){
	ini_set("session.cookie_httponly", 1);
	session_start();
	$_SESSION['username'] = $new_username;
	$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));

	echo json_encode(array(
		"success" => true
	));
	exit;
}else{
	echo json_encode(array(
		"success" => false,
		"message" => $new_password
	));
	exit;
}
?>
