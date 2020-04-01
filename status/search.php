<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/status.php';

$database = new Database();
$db = $database->getConnection();

$state = new Status($db);

if((!isset($_GET["EmailUser"]))&&(!(isset($_GET["CodeEvent"]))))
    die("Parameter Email not found.");

$state->EmailUser=$_GET["EmailUser"];
$state->CodeEvent=$_GET["CodeEvent"];

$stmt = $state->search();
$num = $stmt->rowCount();

if($num>0){

    $states_arr=array();
    $states_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $state_item=array(
            "EmailUser" => $EmailUser,
            "CodeEvent" => $CodeEvent,
            "DateHour" => $DateHour,
            "Safe" => $Safe
        );

        array_push($states_arr["records"], $state_item);
    }

    http_response_code(200);

    echo json_encode($states_arr);
}

else{
    http_response_code(404);

    echo json_encode(
        array("message" => "No states found.")
    );
}
?>