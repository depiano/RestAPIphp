<?php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	  
	include_once '../config/database.php';
	  
	include_once '../objects/event.php';
	  
	$database = new Database();
	$db = $database->getConnection();
	  
	$event = new Event($db);
	  
	$data = json_decode(file_get_contents("php://input"));
	
    $event->Code = $data->Code;
    $event->Latitude = $data->Latitude;
	$event->Longitude = $data->Longitude;
    $event->Description = $data->Description;
    $event->Disabled = $data->Disabled;
	$event->DateHour = gmdate("Y-m-d H:i:s",$data->DateHour);
	
    if($event->create()){
        http_response_code(201);
        echo json_encode(array("message" => "Event was created."));
    }
    else{
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create event."));
    }
	
?>