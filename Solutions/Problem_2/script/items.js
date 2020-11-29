$(document).ready(init);

function init(){
    get_items();
}

function get_items(){
    $.ajax({
        method: "POST",
        url: "server/controller.php",
        dataType: "json",
        data: {type: "items"},
        success: function (data) {
            display_items(data);
        }
    });    
}

//used to complete/uncomplete item
function complete_item(id,status){
     $.ajax({
        method: "POST",
        url: "server/controller.php",
        dataType: "text",
        data: {type: "complete",id:id,status:status},
        success: function (data) {
            if(data.search("success")!=-1){
                get_items();
            }
        }
    });    
}

function attach_events(){
    //events for the checkboxes
    $("input[name=item-checkbox]").on("change",function(){
       var checked=$(this).prop("checked");
        var item_id=$(this).attr("data-item-id");
        if(checked){
            $("#name_"+item_id).addClass("checked");
            complete_item(item_id,true);
        }
        else{
            $("#name_"+item_id).removeClass("checked");
            complete_item(item_id,false);
        }
       
    });
       
    $("select[name=item-actions]").on("change",function(){
       var item_id=$(this).attr("data-item-id");
       var value=$(this).val();
       switch(value){
           case "edit":
               $("#name_"+item_id).css("border","1px solid lightgray");
               $("#name_"+item_id).removeClass("checked");
               $("#button_"+item_id).css("display","inline");
               break;
           case "delete":
               delete_item(item_id);
               break;
       }
    });
    
    $("button[name=edit]").on("click",function(){
        var item_id=$(this).attr("data-item-id");
       var name=$("#name_"+item_id).val(); 
       edit_item(item_id,name);
    });
    
    $("#add_button").on("click",function(){
       var name=$("#new_name").val(); 
       add_item(name);
    });    
}

function add_item(name){
      $.ajax({
        method: "POST",
        url: "server/controller.php",
        dataType: "text",
        data: {type: "add",name:name},
        success: function (data) {
            if(data.search("success")!=-1){
                get_items();
                alert("The item has been added successfully");
            }
        }
    });     
}

function edit_item(id,name){
      $.ajax({
        method: "POST",
        url: "server/controller.php",
        dataType: "text",
        data: {type: "edit",id:id,name:name},
        success: function (data) {
            if(data.search("success")!=-1){
                get_items();
                alert("The item has been editted successfully");
            }
        }
    });     
}

function delete_item(id){
       $.ajax({
        method: "POST",
        url: "server/controller.php",
        dataType: "text",
        data: {type: "delete",id:id},
        success: function (data) {
            if(data.search("success")!=-1){
                get_items();
                alert("The item has been deleted successfully");
            }
        }
    });       
}

function display_items(data){
    var html_maker=new htmlMaker($('#item-template').html());
    var html=html_maker.getHTML(data);
    $("#items").html(html);
    attach_events();
}