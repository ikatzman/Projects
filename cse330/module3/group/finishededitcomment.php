<?php
session_start();
$contents = $_POST['commentcontents'];
$comment_id = $_POST['comment_id'];

require 'database.php';

//update database with new comment contents
$stmt = $mysqli->prepare("update comments set contents=? where comment_id=?");
$stmt->bind_param('ss', $contents, $comment_id);
$stmt->execute();
$stmt->close();

header("Location: storyview.php");
?>