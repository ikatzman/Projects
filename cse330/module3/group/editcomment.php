<!doctype html>
<html lang='en'>
    <link rel="stylesheet" type="text/css" href="newssite2.css"/>
    <head><title>Edit comment</title></head>
    <body>
        <?php
            session_start();
            //check if user is logged in and if token is valid
            if (!array_key_exists('user_id', $_SESSION)) header("Location: newsfailure.html");
            if(!hash_equals($_SESSION['token'], $_POST['token'])){
                header("Location: newsfailure.html");
            }
            $user_id = $_SESSION['user_id'];
            $commenter = $_POST['commenter'];

            //check if user owns the comment
            if ($user_id != $commenter) header("Location: newsfailure.html");

            $comment_id = $_POST['comment_id'];

            require 'database.php';

            //get comment contents for editing
            $stmt = $mysqli->prepare("select contents from comments where comment_id=?");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }

            $stmt->bind_param('i', $comment_id);
            $stmt->execute();
            $stmt->bind_result($comment_contents);
            $stmt->fetch();
            //form for editing, with contents of the comment included
            ?>
            <form action='finishededitcomment.php' method='POST'>
                <label>Edit your comment:</label>
                <textarea name='commentcontents' rows='5' cols='80'><?php echo $comment_contents;?></textarea>
                <input type='hidden' name='comment_id' value='<?php echo $comment_id;?>'>
                <input type='submit' value='Done Editing'>
            </form>
            <?php
            $stmt->close();
        ?>
    </body>
</html>
