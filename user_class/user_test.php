<?php

include "user.php";

$user=new User("Samir","samir");
$name=$user->name; //access password variable
$info=$user->info(); //access info


$user_2=$user; //a shallow copy of $user
$user_2->name="Joseph"; //it will change the name for $user and $user2

print_r($user);

$user_3= clone $user; //a deep copy of $user (independant of $user)
$user_3->name="Ali"; //It will change the name only for $user_3




?>
