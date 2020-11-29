<?php

include "sanitization.php";

if(isset($_POST["from"]) && isset($_POST["to"])){
$from=  sanitizeMYSQL($connection,$_POST["from"]);
$to= sanitizeMYSQL($connection,$_POST["to"]);

$SQL = "SELECT * FROM dbEvent WHERE StartDate >= '$from' AND StartDate <= '$to'";

$result = mysqli_query($connection,$SQL);

if(!$result)
    echo "fail";
else
    echo convert_json($result);
}

function convert_json($result){
    $rows = array();
  while($row = mysqli_fetch_array($result)) {
    $rows[] = $row;
  }
  return json_encode($rows);
}

?>
