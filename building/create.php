<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	  
	include_once '../config/database.php';
	  
	include_once '../objects/building.php';
	  
	$database = new Database();
	$db = $database->getConnection();
	  
	$building = new Building($db);
	  
	$data = json_decode(file_get_contents("php://input"));
	
	$building->Code = $data->Code;
    $building->Latitude = $data->Latitude;
	$building->Longitude = $data->Longitude;
    $building->Description = $data->Description;
    $building->EmailUser = $data->EmailUser;
	
    if($building->create()){
        http_response_code(201);
        echo json_encode(array("message" => "building was created."));
    }
    else{
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create building."));
    }
	
?>