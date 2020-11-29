
$(document).ready(init);

function init(){
    $("#search_button").on("click",view_students);
    $("#search").on("keydown",function(event){view_students_key(event);});
}

function view_students_key(event) {
    if (event.keyCode == 13) //ENTER KEY
        view_students();
}

function view_students() {
    $("#loading_img").attr("class","loading_visible");
    $.ajax({
        method: "POST",
        url: "view_ajax.php",
        dataType: "text", //return text data
        data: {search: $("#search").val()}, //send the value of the search box
        success: function (data) {
            $("#loading_img").attr("class","loading_hidden");
            $("#students").html(data); //the returned result is the HTML of the students div
        }
    });   
}




