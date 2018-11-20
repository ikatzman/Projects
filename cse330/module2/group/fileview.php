<!doctype html>
<html lang="en">
    <header>
        <link rel="stylesheet" type="text/css" href="fileview.css"/>
        <title>View, upload, and delete files</title>
    </header>
    <body>
        <?php
        session_start();
        //check if this is a redirect or a new login
        if (array_key_exists("username", $_GET)) {
          $_SESSION['username'] = $_GET['username'];
          $username = $_SESSION['username'];
        }
        else {
          $username = $_SESSION['username'];
        }
        //check against nothing entered
        if ($username == '') header("Location: loginfailure.html");

        echo htmlentities("Logged in as " . $username);
        echo "<br><br>";

        //open and read users.txt
        $f = fopen("/home/ikatzman/mod2/users.txt", "r");
        while(!feof($f)){
            if ($username == trim(fgets($f))) {
                $filepath = sprintf("/home/ikatzman/mod2/%s", $username);
                goto a;
            }
        }
        //if the username is not valid, redirect
        header("Location: loginfailure.html");

        a:
        $files = fopen($filepath, "r");
        $contents = scandir($filepath);
            //print all files
            for($i = 2; $i < count($contents); $i++){
                $filename = htmlentities($contents[$i]);
                echo $filename;
                //buttons for view, delete, and transfer
                echo "<form action='view.php' method='GET'>
                    <input type='hidden' name='file' value='".$filename."'/>
                    <input type='submit' value='View'/>
                    </form>";
                echo "<form action='delete.php' method='GET'>
                    <input type='hidden' name='file' value='".$filename."'/>
                    <input type='submit' value='Delete'/>
                    </form>";
                echo "<form name='input' action='transfer.php' method='GET'>
                    <label for='usernameinput'>Enter the User you want to transfer this file to:</label>
                    <input type='text' name='move'>
                    <input type='hidden' name='transfer' value='".$filename."'/>
                    <input type='submit' value='Move'/>
                    </form>";
                echo "<br>";
        }
        ?>

        <!-- Uploading -->
        <form name="upload" enctype="multipart/form-data" action="upload.php" method="POST">
            <p>
                <input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
                <label for="input">Choose File for Upload:</label>
                <br></br>
                <input name="uploaded" type="file" id="input"/>
            </p>
            <p>
                <input type="submit" value="Upload"/>
           </p>
        </form>
        <form name="logout" action="logout.php">
              <input type='submit' value='Log Out'/>
        </form>
    </body>
</html>
