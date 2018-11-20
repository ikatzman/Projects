<!doctype html>
<html lang='en'>
    <head><title>Error</title></head>
    <body>
        Error. Please go back to homepage. Automatic logout.
        <?php
            session_start();
            session_destroy();
        ?>
        <form name='redirect' action='newshomepage.php'>
            <input type='submit' value='Back'>
        </form>
    </body>
    
</html>