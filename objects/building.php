<?php
class Building
{
    // database connection and table name
    private $conn;
    private $table_name = "Building";

    // object properties
    public $Code;
    public $Latitude;
    public $Longitude;
    public $Description;
    public $EmailUser;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read buildings
    public function read()
    {
        // select all query
        $query = "SELECT * FROM " . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // create building
    public function create()
    {
        // query to insert record
        $query = "INSERT INTO
					" . $this->table_name . "
				SET
					Code=:code, Latitude=:latitude, Longitude=:longitude, Description=:description, EmailUser=:emailuser";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->Code=htmlspecialchars(strip_tags($this->Code));
        $this->Latitude=htmlspecialchars(strip_tags($this->Latitude));
        $this->Longitude=htmlspecialchars(strip_tags($this->Longitude));
        $this->Description=htmlspecialchars(strip_tags($this->Description));
        $this->EmailUser=htmlspecialchars(strip_tags($this->EmailUser));

        // bind values
        $stmt->bindParam(":code", $this->Code);
        $stmt->bindParam(":latitude", $this->Latitude);
        $stmt->bindParam(":longitude", $this->Longitude);
        $stmt->bindParam(":description", $this->Description);
        $stmt->bindParam(":emailuser", $this->EmailUser);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }

    //Update only description building
    function update()
    {
        $query = "UPDATE
					" . $this->table_name . "
					 SET
					  	Description=:description WHERE Code=:code";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->Code = htmlspecialchars(strip_tags($this->Code));
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        // bind new values
        $stmt->bindParam(':code', $this->Code,PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->Description, PDO::PARAM_STR);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // search buildings
    function search(){

        // select all query
        $query = "SELECT * FROM " . $this->table_name . " WHERE Code=:code";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->Code = htmlspecialchars(strip_tags($this->Code));
        // bind new values
        $stmt->bindParam(':code', $this->Code,PDO::PARAM_STR);

        if($stmt->execute())
            return $stmt;

        die("Error in search function!");
    }

    // search buildings
    function searchByLatLong(){

        // select all query
        $query = "SELECT * FROM " . $this->table_name . " WHERE Latitude=:latitude AND Longitude=:longitude";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->Latitude = htmlspecialchars(strip_tags($this->Latitude));
        $this->Longitude = htmlspecialchars(strip_tags($this->Longitude));

        // bind new values
        $stmt->bindParam(':latitude', $this->Latitude,PDO::PARAM_STR);
        $stmt->bindParam(':longitude', $this->Longitude,PDO::PARAM_STR);

        if($stmt->execute())
            return $stmt;

        die("Error in search function!");
    }
}
?>

