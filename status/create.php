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
	include_once '../objects/status.php';
	  
	$database = new Database();
	$db = $database->getConnection();
	  
	$state = new Status($db);
	  
	// get posted data
	$data = json_decode(file_get_contents("php://input"));
	
	// set product property values
    $state->EmailUser = $data->EmailUser;
    $state->CodeEvent = $data->CodeEvent;
	$state->DateHour = $data->DateHour;
    $state->Safe = $data->Safe;

    // create the product
    if($state->create()){
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "status was created."));
    }
    // if unable to create the product, tell the user
    else{
        // set response code - 503 service unavailable
        http_response_code(503);
        // tell the user
        echo json_encode(array("message" => "Unable to create status."));
    }
	
?>