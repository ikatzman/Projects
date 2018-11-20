<?php
    //since this page comes directly from user page, no need to check credentials
    require 'database.php';
    session_start();
    $username = $_SESSION['user_id'];
    $pwd_guess = $_POST['currentpass'];

    //get the current password hash
    $stmt = $mysqli->prepare("SELECT password_hash FROM users WHERE username=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($pwd_hash);
    $stmt->fetch();


    // Compare the submitted password to the actual password hash
    if(password_verify($pwd_guess, $pwd_hash)){
        $stmt->close();
        //if the submitted password is correct then change the password
        $newuserpass = $_POST['newpass'];
        //new password cannot be blank
        if($newuserpass=='') {
            header("Location: newsfailure.php");
            exit;
        }
        //hash the new password
        $hash = password_hash($newuserpass, PASSWORD_BCRYPT);
        //and insert it into the database
        $stmt = $mysqli->prepare("update users set password_hash=? where username=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('ss', $hash, $username);
        $stmt->execute();
        $stmt->close();
        //redirect user accordingly; if failure, to failure page
        header("Location: userpage.php");


    }
    else{        
        $stmt->close();
        header("Location: newsfailure.html");
    }


?>