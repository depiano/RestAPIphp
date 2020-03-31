<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/people.php';

// instantiate database and people object
$database = new Database();
$db = $database->getConnection();

// initialize object
$people = new People($db);

// get keywords
if(!isset($_GET["Email"]))
    die("Parameter Email non found.");

$people->Email=$_GET["Email"];

$stmt = $people->search();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // peoples array
    $peoples_arr=array();
    $peoples_arr["records"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $people_item=array(
            "Email" => $Email,
            "Name" => $Name,
            "Surname" => $Surname,
            "Householder" => $Householder,
            "Sex" => $Sex
        );

        array_push($peoples_arr["records"], $people_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show peoples data
    echo json_encode($peoples_arr);
}

else{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no peoples found
    echo json_encode(
        array("message" => "No peoples found.")
    );
}
?>