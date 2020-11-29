<?php

include "sanitization.php";
session_start();
$name="";
$dept="";

if(isset($_POST["delete"])){
    logout();
}

if(is_session_active()){
    $name=$_SESSION["name"];
    $dept=$_SESSION["dept"];
}
else
    logout();


function is_session_active() {
    return isset($_SESSION) && count($_SESSION) > 0 && time() < $_SESSION['start']+60; //check if it has been 1 minute
}

function logout(){
    // Unset all of the session variables.

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();
}
?>




<html>
    <head>
        <title>Destroy Session</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <?php echo "Name : $name,  Department: $dept"; ?>
        <form method="POST" action="logout.php">
             <input name="delete" type="submit" value="Delete Session">
        </form>
    </body>
</html>