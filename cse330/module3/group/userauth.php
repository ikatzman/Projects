<?php
// This is a *good* example of how you can implement password-based user authentication in your web application.

require 'database.php';
session_start();
$username = $_POST['username'];
$pwd_guess = $_POST['password'];

// Use a prepared statement
$stmt = $mysqli->prepare("SELECT password_hash FROM users WHERE username=?");

// Bind the parameter
$stmt->bind_param('s', $username);

$stmt->execute();

// Bind the results
$stmt->bind_result($pwd_hash);
$stmt->fetch();


// Compare the submitted password to the actual password hash

if(password_verify($pwd_guess, $pwd_hash)){
    // Login succeeded!
    $_SESSION['user_id'] = $username;
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
    // Redirect to your target page
    header("Location: newshomepage.php");
} else{
    // Login failed; redirect back to the login screen
    header("Location: newslogin.html");
}
?>
