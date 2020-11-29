$(document).ready(init);

function init(){
    /* when the user clicks on the logout link, call logout*/
    $("#logout-link").on("click",logout);
    show_info(); //show the student information
    show_enrolled_courses(); //show the enrolled courses
    show_offered_courses(); //show the offered courses
}

function show_info(){
    $.ajax({
        method: "POST",
        url: "../server/controller.php",
        dataType: "json",
        data: {type: "info"},//request type: info
        success: function (data) {
            var info_template=$("#info-template").html();//get the info-template
            var html_maker=new htmlMaker(info_template);
            var html=html_maker.getHTML(data);//generate dynamic HTML for student-info
            $("#info").html(html);//show the student info in the info div
        }
    });    
}

function show_enrolled_courses(){
    $.ajax({
        method: "POST",
        url: "../server/controller.php",
        dataType: "json",
        data: {type: "enrolled_courses"},
        success: function (data) {
            var info_template=$("#enrolled-course-template").html();
            var html_maker=new htmlMaker(info_template);
            var html=html_maker.getHTML(data);
            $("#enrolled-courses").html(html);
            //attach drop event
            $("div[name=drop-button]").on("click",function(){drop_course(this);});
        }
    });    
}

function show_offered_courses(){
       $.ajax({
        method: "POST",
        url: "../server/controller.php",
        dataType: "json",
        data: {type: "offered_courses"},
        success: function (data) {
            var info_template=$("#offered-course-template").html();
            var html_maker=new htmlMaker(info_template);
            var html=html_maker.getHTML(data);
            $("#offered-courses").html(html);
            //attach enroll event
            $("div[name=enroll-button]").on("click",function(){enroll_course(this);});
        }
    });    
}

function logout() {
    $.ajax({
        method: "POST",
        url: "../server/controller.php",
        dataType: "text",
        data: {type: "logout"},
        success: function () {
            window.location.assign("../HTML/login.html"); //redirect the page to login.html
        }
    });
}

function drop_course(drop_button){
    var course_id=$(drop_button).attr("data-course-id");
     $.ajax({
        method: "POST",
        url: "../server/controller.php",
        dataType: "text",
        data: {type: "drop",course_id:course_id},
        success: function (data) {
            if ($.trim(data)=="success") {
                alert("The course has been dropped successfully");
                show_enrolled_courses(); //refresh enrolled courses
                show_offered_courses(); //refresh offered courses
            }
        }
    });   
}

function enroll_course(enroll_button){
    var course_id=$(enroll_button).attr("data-course-id");
     $.ajax({
        method: "POST",
        url: "../server/controller.php",
        dataType: "text",
        data: {type: "enroll_course",course_id:course_id},
        success: function (data) {
            if ($.trim(data)=="success") {
                alert("The course has been enrolled successfully");
                show_enrolled_courses(); //refresh enrolled courses
                show_offered_courses(); //refresh offered courses
            }
        }
    });   
}



