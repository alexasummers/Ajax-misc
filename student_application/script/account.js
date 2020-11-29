$(document).ready(init);

function init(){
    /* when the user clicks on the logout link, call logout*/
    $("#logout-link").on("click",logout);
    show_info(); //show the student information
    show_courses(); //show the enrolled courses
}

function show_info(){
    $.ajax({
        method: "POST",
        url: "server/controller.php",
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

function show_courses(){
    $.ajax({
        method: "POST",
        url: "server/controller.php",
        dataType: "json",
        data: {type: "courses"},
        success: function (data) {
            var info_template=$("#course-template").html();
            var html_maker=new htmlMaker(info_template);
            var html=html_maker.getHTML(data);
            $("#courses").html(html);
        }
    });    
}

function logout() {
    $.ajax({
        method: "POST",
        url: "server/controller.php",
        dataType: "text",
        data: {type: "logout"},
        success: function (data) {
            if ($.trim(data)=="success") {
                window.location.assign("login.html");
            }
        }
    });
}



