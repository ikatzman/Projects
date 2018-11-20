<?php
session_start();
require "database.php";

$newuser = $_POST['newusername'];
$newuserpass = $_POST['newpassword'];

//check against empty strings
if($newuser=='' or $newuserpass=='') {
    header("Location: newsfailure.html");
    exit;
}

$check = $mysqli->prepare("select username from users");
if(!$check){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$check->execute();
$check->bind_result($temp_user);
while ($check->fetch()) {
    if ($temp_user == $newuser) {
        header("Location: newsfailure.html");
        exit;
    }
}


//hash the new password
$hash = password_hash($newuserpass, PASSWORD_BCRYPT);

//insert data into users table in mysql
$stmt = $mysqli->prepare("insert into users (username, password_hash) values (?, ?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('ss', $newuser, $hash);
$stmt->execute();
$stmt->close();

$_SESSION['user_id'] = $newuser;
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
header("Location: newshomepage.php");
?>
