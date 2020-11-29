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

function attach_events(){
    //events for the checkboxes
       
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



function display_items(data){
    var html_maker=new htmlMaker($('#item-template').html());
    var html=html_maker.getHTML(data);
    $("#items").html(html);
    attach_events();
}