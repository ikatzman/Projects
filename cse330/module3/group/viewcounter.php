<?php
  session_start();
  require 'database.php';
  $_SESSION['story_id'] = $_POST['story_id'];
  $story_id = $_SESSION['story_id'];
  $_SESSION['views'] = $_POST['views'];
  $views = $_SESSION['views'];

  $views++;
  $views_stmt = $mysqli->prepare("update stories set views=? WHERE story_id=?");
  $views_stmt->bind_param('ss', $views, $story_id);
  $views_stmt->execute();
  $views_stmt->close();

  header("Location: storyview.php");
?>
