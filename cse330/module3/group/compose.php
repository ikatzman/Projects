<!DOCTYPE html>
<html lang = "en">
  <head>
    <link rel="stylesheet" type="text/css" href="newsite.css"/>
    <title>Compose Story</title>
    News Website
  </head>

  <body>
    <?php
    session_start();
    require 'database.php';
    //check if user is logged in and if token is valid
    if (!array_key_exists("user_id", $_SESSION)) header("Location: newshomepage.php");
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
      header("Location: newsfailure.html");
    }
    //form for composing story, with link if necessary
    ?>
    <form name='compose' action='finishedcompose.php' method='POST'>
      <label for='composetitle'>The title of your story:</label>
        <input type='text' name='title' id='composetitle'>
          <br></br>
      <label for='compose'>Write your story here:</label>

        <textarea name='composition' rows='10' cols='30'></textarea>
        <input type='submit' value='Submit'>
        <br></br>
      <label for='compose'>Add a link with your story if necessary (Must copy and paste link):</label>
        <textarea name='link' rows='1' cols='20'></textarea>

        <input type='submit' value='Submit'>
    </form>
  </body>
</html>
