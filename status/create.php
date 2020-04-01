<?php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	  
	include_once '../config/database.php';
	  
	include_once '../objects/status.php';
	  
	$database = new Database();
	$db = $database->getConnection();
	  
	$state = new Status($db);
	  
	$data = json_decode(file_get_contents("php://input"));
	
    $state->EmailUser = $data->EmailUser;
    $state->CodeEvent = $data->CodeEvent;
	$state->DateHour = $data->DateHour;
    $state->Safe = $data->Safe;

    if($state->create()){

        http_response_code(201);

        echo json_encode(array("message" => "status was created."));
    }
    else{

        http_response_code(503);

        echo json_encode(array("message" => "Unable to create status."));
    }
	
?>