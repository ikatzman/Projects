<!doctype html>
<html lang='en'>
    <link rel="stylesheet" type="text/css" href="newsite.css"/>
    <head><title>User Page</title></head>
    <body>
        <?php
            session_start();
            unset($_SESSION['story_id']);

            $username = $_SESSION['user_id'];
            echo "Logged in as: " . htmlentities($username);
            //change password button
            ?>
            <br>
            <form action='changepass.php'>
                <input type='submit' value='Change Password'>
            </form>
            <br><br>
            Stories:
            <br>
            <?php

            require 'database.php';
            //display all user's stories' titles, with button to go to the story
            $getstories = $mysqli->prepare("select title, story_id, views from stories where owner=?");
            if(!$getstories){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $getstories->bind_param('s', $username);
            $getstories->execute();
            $getstories->bind_result($story_title, $story_id, $views);

            while ($getstories->fetch()) {
                echo htmlspecialchars($story_title);
                ?>
                <form action='viewcounter.php' method='POST'>
                    <input type='hidden' name='story_id' value='<?php echo $story_id;?>'>
                    <input type='hidden' name='views' value='<?php echo $views;?>'>
                    <input type='submit' value='View'>
                </form>
                <br>
                <?php
            }
            $getstories->close();
            echo "<br><br><br>";
            //display all the user's comments, with a button to go to the story
            $getcomments = $mysqli->prepare("select contents, story_id from comments where owner=?");
            if(!$getcomments){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $getcomments->bind_param('s', $username);
            $getcomments->execute();
            $getcomments->bind_result($comment_contents, $comment_story);
            echo "Comments:";
            echo "<br>";
            while ($getcomments->fetch()) {
                echo htmlspecialchars($comment_contents);
                ?>
                <form action='viewcounter.php' method='POST'>
                    <input type='hidden' name='story_id' value='<?php echo $comment_story;?>'>
                    <input type='hidden' name='views' value='<?php echo $views;?>'>
                    <input type='submit' value='View'>
                </form>
                <br>
                <?php
            }
            echo "<form action='newshomepage.php' method='POST'>
                  <input type='submit' value='Home'>
                  </form>";
        ?>
    </body>
</html>
