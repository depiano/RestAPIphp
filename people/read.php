<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
include_once '../config/database.php';
include_once '../objects/people.php';

$database = new Database();
$db = $database->getConnection();
  
$people = new People($db);
  
$stmt = $people->read();
$num = $stmt->rowCount();
  
if($num>0){
  
    $peoples_arr=array();
    $peoples_arr["records"]=array();
  
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $people_item=array(
            "Email" => $Email,
            "Name" => $Name,
            "Surname" => $Surname,
            "Password" => $Password,
            "Householder" => $Householder,
            "Sex" => $Sex
        );
  
        array_push($peoples_arr["records"], $people_item);
    }
  
    http_response_code(200);
  
    echo json_encode($peoples_arr);
}
else
{

    http_response_code(404);

    echo json_encode(
        array("message" => "No peoples found.")
    );
}