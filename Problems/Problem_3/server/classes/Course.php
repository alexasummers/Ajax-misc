<?php

class Course {

    private $ID;
    private $title;
    private $description;

    function __construct($ID, $title, $description) {
        $this->ID = $ID;
        $this->title = $title;
        $this->description = $description;
    }

    function getID() {
        return $this->ID;
    }

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }
    
    function course_as_array() {
        return array("ID"=>$this->ID, "Title"=>$this->title, "Description"=>$this->description);
    }

}

?>
