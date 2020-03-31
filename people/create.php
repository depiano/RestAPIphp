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
	include_once '../objects/people.php';
	  
	$database = new Database();
	$db = $database->getConnection();
	  
	$people = new People($db);
	  
	// get posted data
	$data = json_decode(file_get_contents("php://input"));
	
	// set product property values
    $people->Email = $data->Email;
    $people->Name = $data->Name;
	$people->Surname = $data->Surname;
    $people->Sex = $data->Sex;
    $people->Householder = $data->Householder;
	
    // create the product
    if($people->create()){
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "people was created."));
    }
    // if unable to create the product, tell the user
    else{
        // set response code - 503 service unavailable
        http_response_code(503);
        // tell the user
        echo json_encode(array("message" => "Unable to create people."));
    }
	
?>