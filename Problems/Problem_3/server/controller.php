<?php
include "sanitization.php";
include "login.php";
include "classes/database.php";
include "classes/CourseList.php";
include "classes/StudentList.php";
$database = new database($db_hostname, $db_database, $db_username, $db_password); //establish connection
$connection = $database->db_server;
if (isset($_POST["type"])) {
    $request_type = sanitizeMYSQL($connection, $_POST["type"]);
    $returned_value = "fail"; //default value
    if ($request_type != "login")
        session_start();
    else
        $_SESSION["start"] = time(); //reset the session start time

    switch ($request_type) {
        case "login":
            $returned_value = login($database, sanitizeMYSQL($connection, $_POST["name"]), sanitizeMYSQL($connection, $_POST["password"]));
            break;
        case "info":
            if (is_session_active())
                $returned_value = info($database);
            break;
        case "enrolled_courses":
            if (is_session_active())
                $returned_value = enrolled_courses($database);
            break;
        case "offered_courses":
            if (is_session_active())
                $returned_value = offered_courses($database);
            break;
        case "logout":
            if (is_session_active()) {
                logout();
                $returned_value = "success";
            }
            break;
        case "drop":
            if (is_session_active()) {
                $course_id = sanitizeMYSQL($connection, $_POST['course_id']);
                $result = drop_course($database, $course_id);
                if ($result)
                    $returned_value = "success";
            }
            break;
    }
    echo $returned_value;
}



function drop_course($database, $course_id) {
    $student = $_SESSION["student"];
    if ($student != null)
        return $student->drop_course($database, $course_id);
    return ""; //no student is available
}

function enrolled_courses($database) {
    $student = $_SESSION["student"];
    if ($student != null)
        return $student->enrolled_courses_JSON($database);
    return convert_json(array()); //no student is available
}

function offered_courses($database) {
    $student = $_SESSION["student"];
    if ($student != null)
        return $student->offered_courses_JSON($database);
    return convert_json(array()); //no student is available
}

function info($database) {
    $student = $_SESSION["student"];
    if ($student != null)
        return $student->to_JSON();
    return convert_json(array()); //no student is available
}

function login($database, $username, $password) {
    $student_list = new StudentList();
    $student = $student_list->authenticate($database, $username, $password);
    if ($student != null) { //success
        session_start();
        $_SESSION["start"] = time(); //start time is now
        $_SESSION["student"] = $student; //store the student object in the session
        return "success";
    }
    return "fail";
}

function is_session_active() {
    return isset($_SESSION) && count($_SESSION) > 0 && time() < $_SESSION['start'] + 60 * 5; //check if it has been 5 minutes
}

function logout() {
    // Unset all of the session variables.
    $_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
        );
    }

// Finally, destroy the session.
    session_destroy();
}
?>

