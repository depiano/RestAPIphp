<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/people.php';

$database = new Database();
$db = $database->getConnection();

$people = new People($db);

$data = json_decode(file_get_contents("php://input"));

$people->Email = $data->Email;
$people->Password = $data->Password;

if($people->update()){

    http_response_code(200);

    echo json_encode(array("message" => "people was updated."));
}
else{

    http_response_code(503);

    echo json_encode(array("message" => "Unable to update people."));
}
?>