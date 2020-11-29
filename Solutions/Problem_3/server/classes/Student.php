<?php

class Student {

    private $first_name;
    private $last_name;
    private $gender;
    private $dateOfBirth;
    private $picture;
    private $picture_type;
    private $ID;

    function __construct($ID, $first_name, $last_name, $gender, $dateOfBirth, $picture, $picture_type) {
        $this->ID = $ID;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->gender = $gender == 'M' ? "male" : "female";
        $this->dateOfBirth = $dateOfBirth;
        $this->picture = $picture;
        $this->picture_type = $picture_type;
    }

    function get_first_name() {
        return $this->first_name;
    }

    function get_last_name() {
        return $this->last_name;
    }

    function get_gender() {
        return $this->gender;
    }

    function get_dateOfBirth() {
        return $this->dateOfBirth;
    }

    function get_picture() {
        return $this->picture;
    }

    function get_picture_type() {
        return $this->picture_type;
    }

    function get_age() {
        return date_diff(date_create($this->dateOfBirth), date_create('now'))->y; //calculate $age based using date_diff (date difference)
    }

    function enroll_in_course($database, $courseID, $enrollment_date) {
        $date = date_format($enrollment_date, "Y/m/d");
        $values = array("Course_ID" => $courseID, "Student_ID" => $this->ID, "Enrollment_Date" => $date);
        $final = $database->insert("Enrollment", $values);
        return $final;
    }

    function drop_course($database, $courseID) {
        $result = $database->delete_where("Enrollment", "Student_ID=$this->ID AND Course_ID='$courseID'");
        return $result;
    }

    function enrolled_courses_JSON($database) {
        $result = $database->inner_join_SQL("Enrollment", "Course", "Course.ID, Course.Description, Course.Title, Enrollment.Enrollment_Date", "Enrollment.Course_ID = Course.ID", "Enrollment.Student_ID=$this->ID");
        if (!$result)
            return "";
        $row_count = mysqli_num_rows($result);
        $courses = array();
        $courses["courses"]=array();

        for ($j = 0; $j < $row_count; ++$j) {
            $row = mysqli_fetch_array($result); //fetch the next row
            $courses["courses"][]= array("ID"=>$row["ID"], "Title"=>$row["Title"], "Enrollment_Date"=>$row["Enrollment_Date"]);
        }
        return json_encode($courses);
    }
    
    function offered_courses_JSON($database){
        $SQL="SELECT * FROM COURSE WHERE ID NOT IN (".
             "  SELECT Course.ID FROM Course INNER JOIN".
             "   Enrollment ".
             " ON Course.ID=Enrollment.Course_ID".
             " WHERE Enrollment.Student_ID='$this->ID')";
        $result=$database->general_query($SQL);
        $course_list=new CourseList();
        return $course_list->courses_as_JSON($result);
    }


    function to_JSON() {
        $picture_src='data:' . $this->picture_type . ';base64,' . base64_encode($this->picture);
        $name= $this->first_name . " " . $this->last_name;
        $array = array("Picture"=>$picture_src, "Name"=>$name, "Gender"=>$this->gender,"Age"=>$this->get_age());
        return json_encode($array);
    }
}

?>
