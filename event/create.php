<?php
	// required headers
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	  
	// get database connection
	include_once '../config/database.php';
	  
	// instantiate product object
	include_once '../objects/event.php';
	  
	$database = new Database();
	$db = $database->getConnection();
	  
	$event = new Event($db);
	  
	// get posted data
	$data = json_decode(file_get_contents("php://input"));
	
	// set product property values
    $event->Code = $data->Code;
    $event->Latitude = $data->Latitude;
	$event->Longitude = $data->Longitude;
    $event->Description = $data->Description;
    $event->Disabled = $data->Disabled;
	$event->DateHour = gmdate("Y-m-d H:i:s",$data->DateHour);
	
    // create the product
    if($event->create()){
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "Event was created."));
    }
    // if unable to create the product, tell the user
    else{
        // set response code - 503 service unavailable
        http_response_code(503);
        // tell the user
        echo json_encode(array("message" => "Unable to create event."));
    }
	
?>