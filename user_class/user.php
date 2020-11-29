<?php

class User {

    public $name; //accessible outside the scope of the class
    private $password; //only accessible within the scope of the class

    //initializes name and password, called when an object of User gets created
    function __construct($name, $password) {
        $this->name = $name;
        $this->password = $password;
    }

    //return the info of the student
    function info() {
        return "Name : $this->name, Password: $this->password";
    }

}

?>
