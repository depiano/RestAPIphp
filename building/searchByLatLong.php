<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/building.php';

// instantiate database and building object
$database = new Database();
$db = $database->getConnection();

// initialize object
$building = new Building($db);

// get keywords
if((!isset($_GET["Latitude"]))&&(!(isset($_GET["Longitude"]))))
    die("Parameters Latitude/Longitude not founds.");

$building->Latitude=$_GET["Latitude"];
$building->Longitude=$_GET["Longitude"];

$stmt = $building->searchByLatLong();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // buildings array
    $buildings_arr=array();
    $buildings_arr["records"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
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

    // set response code - 200 OK
    http_response_code(200);

    // show buildings data
    echo json_encode($buildings_arr);
}

else{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no buildings found
    echo json_encode(
        array("message" => "No buildings found.")
    );
}
?>