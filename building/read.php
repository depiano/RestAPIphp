<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
include_once '../config/database.php';
include_once '../objects/building.php';
  
$database = new Database();
$db = $database->getConnection();
  
$building = new Building($db);
  
$stmt = $building->read();
$num = $stmt->rowCount();

if($num>0){
  
    $buildings_arr=array();
    $buildings_arr["records"]=array();
  
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
  
        $building_item=array(
            "Code" => $Code,
            "Latitude" => $Latitude,
            "Longitude" => $Longitude,
            "Description" => html_entity_decode($Description),
            "EmailUser" => $EmailUser
        );
  
        array_push($buildings_arr["records"], $building_item);
    }
  
    http_response_code(200);
  
    echo json_encode($buildings_arr);
}
else
{
  
    http_response_code(404);
  
    echo json_encode(
        array("message" => "No buildings found.")
    );
}