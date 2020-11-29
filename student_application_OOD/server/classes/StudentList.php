<?php

include "Student.php";

class StudentList {

    function __construct() {
        
    }

    function display_students($result) {
        if (!$result)
            return "";
        $row_count = mysql_num_rows($result);
        $students = "";

        for ($j = 0; $j < $row_count; ++$j) {
            $row = mysqli_fetch_array($result); //fetch the next row
            $student = new Student($row["ID"], $row["FirstName"], $row["LastName"], $row["Gender"], $row["DateOfBirth"], $row["Picture"], $row["Picture_Type"]);
            $students.=$student->to_JSON();
        }
        return $students;
    }

    function display_all($database) {
        $result = $database->select_fields_where("Student");
        return $this->display_students($result);
    }

    function search_LIKE($database, $data) {
        $LIKE_array = array("FirstName" => $data, "LastName" => $data);
        $result = $database->select_like("Student", "*", $LIKE_array);
        return $this->display_students($result);
    }

    function get_student($id) {
        $result = $database->select_fields_where("Student", "*", "ID='" . $username . "'");
        if (!$result)
            return null; //the student doesn't exist
        $row_count = mysqli_num_rows($result);
        if ($row_count == 1) { //start a session
            $row = mysqli_fetch_array($result);
            return new Student($row["ID"], $row["FirstName"], $row["LastName"], $row["Gender"], $row["DateOfBirth"], $row["Picture"], $row["Picture_Type"]);
        }
        return null;
    }

    function authenticate($database, $username, $password) {
        $password = md5('web' . $password . 'web');
        $result = $database->select_fields_where("Student", "*", "ID='" . $username . "' AND Password='" . $password . "'");
        if (!$result)
            return null;
        $row_count = mysqli_num_rows($result);
        if ($row_count == 1) { //start a session
            $row = mysqli_fetch_array($result);
            return new Student($row["ID"], $row["FirstName"], $row["LastName"], $row["Gender"], $row["DateOfBirth"], $row["Picture"], $row["Picture_Type"]);
        }
        return null;
    }

}
