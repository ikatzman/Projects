<!DOCTYPE html>
<html lang = "en">
  <head>
    <link rel="stylesheet" type="text/css" href="newsite.css"/>
    <title>Write Comment</title>
    News Website
  </head>

  <body>
    <?php
    session_start();
    require 'database.php';
    //check if user is logged in and if token is valid
    if (!array_key_exists("user_id", $_SESSION)) header("Location: storyview.php");
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
      header("Location: newsfailure.html");
    }
    $story_id = $_POST['story_id'];
    //form for writing new comment
    ?>
    <form name='write' action='finishedcomment.php' method='POST'>
      <label for='compose'>Write your comment here:</label>
        <textarea name='composition' rows='5' cols='50'></textarea>
        <input type='hidden' name='story_id' value='<?php echo $story_id;?>'>
        <input type='submit' value='Submit'>
    </form>
  </body>
  </html>
