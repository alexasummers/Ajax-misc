<?php
$username="";
if (isset($_POST['username'])) {
    if (isset($_COOKIE['username'])) { //if there is a cookie, retrive it
        $username = $_COOKIE['username'];
    } else {
        /* Create a cookie with the name username and the value $username that is accessible 
         * across the entire web server on the current domain, and will be removed from the browser’s cache seven days:
         */

        setcookie('username', $_POST['username'], time() + 60 * 60 * 24 * 7, '/');
    }
}

if (isset($_POST['delete'])) {
    if (isset($_COOKIE['username']))
        setcookie('username', $_COOKIE['username'], time() - 60 * 60 * 24 * 7, '/');
    $html = "Cookie deleted <br>";
    echo $html;
}
?>

<html>
    <body>
        Hello <?php echo $username; ?> <br>
        <form action='cookies.php' method='POST'>
            <input type='submit' name='delete' value='Delete Cookie'>
        </form>
    </body>
</html>






