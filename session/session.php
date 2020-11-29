<?php

include "sanitization.php";
$name="";$dept="";

if(isset($_POST["name"]) && isset($_POST["dept"])){
    $name= sanitizeString($_POST["name"]);
    $dept=  sanitizeString($_POST["dept"]);
    
    session_start(); //start session
    $_SESSION["name"]=$name;
    $_SESSION["dept"]=$dept;
    $_SESSION["start"]=time(); //current date and time
    
    header( 'Location: logout.php' ) ; //redirect to logout.php
}

?>



