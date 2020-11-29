<?php

include "connection.php";
include "utility.php";

if (isset($_POST["type"])) {
    $type = sanitizeMYSQL($connection,$_POST["type"]);
    $returned_value = ""; //default value

    switch ($type) {       
        case "items":
            $returned_value = display_items($connection);
            break;  
        case "complete":
            $returned_value = complete_item($connection,sanitizeMYSQL($connection,$_POST["id"]),sanitizeMYSQL($connection,$_POST["status"]));
            break;
        case "edit":
            $returned_value = edit_item($connection,sanitizeMYSQL($connection,$_POST["id"]),sanitizeMYSQL($connection,$_POST["name"]));
            break;    
        case "delete":
            $returned_value = delete_item($connection,sanitizeMYSQL($connection,$_POST["id"]));
            break; 
        case "add":
            $returned_value = add_item($connection,sanitizeMYSQL($connection,$_POST["name"]));
            break;         
    }
    echo $returned_value;
}

function complete_item($connection,$id,$status){
    $query = "UPDATE Item SET Completed=$status WHERE ID=$id";
    $result = mysqli_query($connection, $query);
    if(!$result)
        return "fail";
    return "success";
}

function add_item($connection,$name){
    $query = "INSERT INTO Item(Name) VALUES('$name')";
    $result = mysqli_query($connection, $query);
    if(!$result)
        return "fail";
    return "success";
}

function edit_item($connection,$id,$name){

    $query = "UPDATE Item SET Name='$name' WHERE ID=$id";
    $result = mysqli_query($connection, $query);
    if(!$result)
        return "fail";
    return "success";
}

function delete_item($connection,$id){
    $query = "DELETE FROM Item WHERE ID=$id";
    $result = mysqli_query($connection, $query);
    if(!$result)
        return "fail";
    return "success";
}



function display_items($connection) {
    $query = "SELECT * FROM Item";
    $result = mysqli_query($connection, $query);
    $html="";
    $final_result=array();
    if ($result) {
        $row_count = mysqli_num_rows($result);
        for($i=0;$i<$row_count;++$i){
            $row = mysqli_fetch_array($result);
            $status=$row["Completed"]?"checked":"";
            $item = array("id"=>$row["ID"],"name"=>$row["Name"], "checked"=>$status);
            $final_result["items"][]=$item;
        }
    }
    return json_encode($final_result);
}


