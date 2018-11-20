<!doctype html>
<html lang='en'>
    <link rel="stylesheet" type="text/css" href="newssite2.css"/>
    <header><title>Edit Story</title></header>
    <body>
        <?php
            session_start();
            //check if user is logged in and if token is valid
            if (!array_key_exists('user_id', $_SESSION)) header("Location: newsfailure.html");
            if(!hash_equals($_SESSION['token'], $_POST['token'])){
                header("Location: newsfailure.html");
            }
            $user_id = $_SESSION['user_id'];
            $owner = $_POST['owner'];

            //check if user owns this story
            if ($user_id != $owner) header("Location: newsfailure.html");

            $story_id = $_SESSION['story_id'];

            require 'database.php';

            //get existing story contents for editing
            $stmt = $mysqli->prepare("select contents from stories where story_id=?");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }

            $stmt->bind_param('i', $story_id);
            $stmt->execute();
            $stmt->bind_result($story_contents);
            $stmt->fetch();
            //form for editing with existing contents included
            ?>
            <form action='finishededitstory.php' method='POST'>
                <label>Edit your story:</label>
                <textarea name='storycontents' rows='10' cols='80'><?php echo $story_contents?></textarea>
                <input type='submit' value='Done Editing'>
            </form>
            <?php
            $stmt->close();
        ?>
    </body>
</html>
