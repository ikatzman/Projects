<!DOCTYPE html>
<html lang = "en">
  <head>
    <link rel="stylesheet" type="text/css" href="newsite.css"/>
    <title>News Site Homepage</title>
  </head>

  <body>
    <?php
      echo "News Website";
      echo "<br>";
      session_start();
      unset($_SESSION['story_id']);

      //need to check if redirect or new login, and if it's a redirect, if password is correct?
      if (array_key_exists("user_id", $_SESSION) and $_SESSION['user_id'] != '') {
        echo htmlentities("Logged in as " . htmlentities($_SESSION['user_id']));
        //button for user account page
        ?>
        <form action='userpage.php' method='POST'>
          <input type='submit' value='User Account'>
        </form>
        <?php
      }
      else {
        //log out user
        session_destroy();
        echo "not logged in as a user";
      }


      require 'database.php';
      //login, logout, and compose story buttons
      ?>
       <div class='login'>
       <form name='login' action='newslogin.html' method='GET'>
            <input type='submit' value='Login/Signup'/>
            </form>
       <form name='logout' action='logout.php' method='GET'>
            <input type='submit' value='Logout'/>
            </form>
       </div>


       <br>
       <div class='compose'>
       <form name='compose' action='compose.php' method='POST'>
            Compose a new story here:
            <input type='submit' value='Compose'/>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
            </form>
            <br>
            Existing Stories:
            <br><br>
       </div>
       <?php

      //utilized this link in the following syntax:
      //https://stackoverflow.com/questions/848905/loop-through-database-and-show-in-table
      $result = mysqli_query($mysqli, "SELECT * FROM stories");

      while($row = mysqli_fetch_array($result)){
        //display all stories
        ?>
        <div class='stories'>
             <?php echo htmlentities($row['title']);?>
             <form action='viewcounter.php' method='POST'>
             <input type='hidden' name='story_id' value='<?php echo $row['story_id'];?>'>
             <input type='hidden' name='views' value='<?php echo $row['views'];?>'>
             By:
             <?php echo htmlentities($row['owner']);?>
             <br>

             <input type='submit' value='Read Story'/>
             <br><br>
             </form>

             </div>
        <?php
      }
      mysqli_close($mysqli);
    ?>
  </body>
</html>
