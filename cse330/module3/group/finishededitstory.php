<?php
    session_start();
    $contents = $_POST['storycontents'];
    $story_id = $_SESSION['story_id'];

    require 'database.php';

    //update database with new story contents
    $stmt = $mysqli->prepare("update stories set contents=? where story_id=?");
    $stmt->bind_param('ss', $contents, $story_id);
    $stmt->execute();
    $stmt->close();

    header("Location: storyview.php");
?>