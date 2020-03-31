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
	include_once '../objects/building.php';
	  
	$database = new Database();
	$db = $database->getConnection();
	  
	$building = new Building($db);
	  
	// get posted data
	$data = json_decode(file_get_contents("php://input"));
	
	// set product property values
    $building->Code = $data->Code;
    $building->Latitude = $data->Latitude;
	$building->Longitude = $data->Longitude;
    $building->Description = $data->Description;
    $building->EmailUser = $data->EmailUser;
	
    // create the product
    if($building->create()){
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "building was created."));
    }
    // if unable to create the product, tell the user
    else{
        // set response code - 503 service unavailable
        http_response_code(503);
        // tell the user
        echo json_encode(array("message" => "Unable to create building."));
    }
	
?>