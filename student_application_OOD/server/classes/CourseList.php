<?php
include "Course.php";

class CourseList {

    function __construct() {
        
    }

    function courses_as_JSON($result) {
        if (!$result)
            return "";
        $row_count = mysqli_num_rows($result);
        $courses = array();
        $courses["courses"]=array();

        for ($j = 0; $j < $row_count; ++$j) {
            $row = mysqli_fetch_array($result); //fetch the next row
            $course=new Course($row["ID"],$row["Title"],$row["Description"]);
            $courses["courses"][]=$course->course_as_array();
        }
        return json_encode($courses);
    }

    function display_all($database) {
        $result = $database->select_fields_where("Course");
        return $this->courses_as_JSON($result);
    }

    function search_LIKE($database, $data) {
        $LIKE_array = array("ID" => $data, "Title" => $data,"Description" => $data);
        $result = $database->select_like("Course", "*", $LIKE_array);
        return $this->courses_as_JSON($result);
    }

}
