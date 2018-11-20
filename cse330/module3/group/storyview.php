<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <link rel="stylesheet" type="text/css" href="newssite2.css"/>
        <title>View Story</title>
    </head>
    <body>
        <?php
            session_start();
            require 'database.php';
            $views = $_SESSION['views'];
            $views++;
            //check if this is a redirect from anything but the homepage
            if (!array_key_exists('story_id', $_SESSION)){
                $story_id = $_SESSION['story_id'];
            }
            else {
                $story_id = $_SESSION['story_id'];
            }
            //get data from mysql
            $stmt = $mysqli->prepare("select owner, title, contents, link, likes, dislikes, views from stories where story_id=?");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('i', $story_id);
            $stmt->execute();

            $result = $stmt->bind_result($owner, $title, $contents, $link, $likes, $dislikes, $views);
            $stmt->fetch();

            //print contents and if link, link
            echo htmlentities($title);
            echo "<br><br>";
            echo "by " . htmlentities($owner);
            echo "<br><br>";
            echo htmlentities($contents);
            echo "<br><br>";
            if($link == null){
              echo "No link for this story";
            }
            else if (!(preg_match('/\b.com\b/', $link))){
              echo "No Link for this story";
            }
            else {
              echo "Story Link: <a href=".$link.">Link</a>";
            }
            $stmt->close();
            //buttons for edit, delete, like, dislike story
            ?>
                <form action='editstory.php' method='POST'>
                    <input type='hidden' name='owner' value='<?php echo $owner;?>'/>
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                    <input type='submit' value='Edit Story'/>
                </form><br>
                <form action='deletestory.php' method='POST'>
                    <input type='hidden' name='story_id' value='<?php echo $story_id;?>'>
                    <input type='hidden' name='author' value='<?php echo $owner;?>'>
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                    <input type='submit' value='Delete Story'>
                </form><br>
                <form action='likepost.php' method='POST'>
                    <input type='hidden' name='likesid' value='<?php echo $story_id;?>'/>
                    <input type='hidden' name='likes' value='<?php echo $likes;?>'/>
                    <input type='submit' value='Like Post'/>
                </form><br>
                <form action='dislikepost.php' method='POST'>
                    <input type='hidden' name='dislikesid' value='<?php echo $story_id;?>'/>
                    <input type='hidden' name='dislikes' value='<?php echo $dislikes;?>'/>
                    <input type='submit' value='Dislike Post'/>
                </form><br>

            <?php
            echo "Total page views: ".$views;
            echo "<br>";
            echo "Likes: ".$likes."  Dislikes: ".$dislikes;

            echo "<br><br>";

            //get comments information
            $comment_stmt = $mysqli->prepare("select comment_id, owner, contents from comments where story_id=?");
            if (!$comment_stmt) {
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $comment_stmt->bind_param('s', $story_id);
            $comment_stmt->execute();
            $comment_stmt->bind_result($c_id, $c_owner, $c_contents);
            echo "Comments: <br>";

            //print comments, with buttons to edit, delete or add comments
            while($comment_stmt->fetch()){
                    echo htmlspecialchars($c_owner) . ": ";
                    echo htmlspecialchars($c_contents);
                ?>
                <form action='editcomment.php' method='POST'>
                    <input type='hidden' name='comment_id' value='<?php echo $c_id;?>'/>
                    <input type='hidden' name='commenter' value='<?php echo $c_owner;?>'>
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                    <input type='submit' value='Edit'/>
                </form>
                <form action='deletecomment.php' method='POST'>
                    <input type='hidden' name='comment_id' value='<?php echo $c_id;?>'>
                    <input type='hidden' name='commenter' value='<?php echo $c_owner;?>'>
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                    <input type='submit' value='Delete'>
                </form><br>
                <?php
            }
            $comment_stmt->close();
            ?>
            <br>
            <form action='addcomment.php' method='POST'>
                <input type='hidden' name='story_id' value='<?php echo $story_id;?>'>
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                <input type='submit' value='Add Comment'>
            </form><br>
            <form action="newshomepage.php" method="post">
              <input name="home" type="submit" value="Back to Homepage">
            </form>
    </body>
</html>
