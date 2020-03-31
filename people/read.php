<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/people.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$people = new People($db);
  
// query products
$stmt = $people->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
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
            "Password" => $Password,
            "Householder" => $Householder,
            "Sex" => $Sex
        );
  
        array_push($peoples_arr["records"], $people_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($peoples_arr);
}
else
{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No peoples found.")
    );
}