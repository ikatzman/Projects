<?php
    //add the comment to comment table, story_id is given through post
    echo "<link rel='stylesheet' type='text/css' href='newsite.css'/>";
    session_start();

    require 'database.php';

    //gather all necessary info from POST or SESSION
    $comment = $_POST['composition'];
    $username = $_SESSION['user_id'];
    $story_id = $_POST['story_id'];
    $new_comment_id;

    //insert data into database
    $insert_stmt = $mysqli->prepare("insert into comments (comment_id, story_id, owner, contents) values (?, ?, ?, ?)");

     if(!$insert_stmt){
        printf("1Query Prep Failed: %s\n", $mysqli->error);
         exit;
     }

     $insert_stmt->bind_param('ssss', $new_comment_id, $story_id, $username, $comment);
     $insert_stmt->execute();
     $insert_stmt->close();

     header("Location: newssuccess.html");
?>
