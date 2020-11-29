$(document).ready(init); //call the init function after the page loads

function init(){
    /** when the login button gets clicked, call the login function **/
    $("#login-button").on("click",login);
    $("#password-input").on("keydown",function(event){maybe_login(event);});
}

/** when the user presses Enter in the password field, call login **/
function maybe_login(event){
    if (event.keyCode == 13) //ENTER KEY
        login();
}

function login() {
    var formData=new FormData($("#login_form")[0]); //get the data from the form
    formData.append("type","login");
    
    $("#loading").attr("class","loading");//show the loading icon
        $.ajax({
        method: "POST",
        url: "../server/controller.php",
        dataType: "text",
        data: formData, //get the data from the form
        processData: false, //necessary when you get data from the form
        contentType: false, //necessary when you get data from the form
        success: function (data) {
        if($.trim(data)=="success")
            window.location.assign("../HTML/account.html"); //redirect the page to account.html
        else{
            $("#loading").attr("class","loading_hidden"); //hide the loading icon
            $("#login_feedback").html("Invalid username or password"); //show feedback
        }
        }
    });
}








