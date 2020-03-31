<?php
class Status
{
    // database connection and table name
    private $conn;
    private $table_name = "Status";

    // object properties
    public $EmailUser;
    public $CodeEvent;
    public $DateHour;
    public $Safe;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read events
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

    // create product
    public function create()
    {
        // query to insert record
        $query = "INSERT INTO
					" . $this->table_name . "
				SET
					EmailUser=:emailuser, CodeEvent=:codeevent, DateHour=:datehour, Safe=:safe";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->EmailUser=htmlspecialchars(strip_tags($this->EmailUser));
        $this->CodeEvent=htmlspecialchars(strip_tags($this->CodeEvent));
        $this->DateHour=htmlspecialchars(strip_tags($this->DateHour));
        $this->Safe=htmlspecialchars(strip_tags($this->Safe));

        // bind values
        $stmt->bindParam(":emailuser", $this->EmailUser);
        $stmt->bindParam(":codeevent", $this->CodeEvent);
        $stmt->bindParam(":datehour", $this->DateHour);
        $stmt->bindParam(":safe", $this->Safe);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }

    // search products
    function search(){

        // select all query
        $query = "SELECT * FROM " . $this->table_name . " WHERE EmailUser=:email AND CodeEvent=:codeevent";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->EmailUser = htmlspecialchars(strip_tags($this->EmailUser));
        $this->CodeEvent = htmlspecialchars(strip_tags($this->CodeEvent));
        $stmt->bindParam(':emailuser', $this->EmailUser,PDO::PARAM_STR);
        $stmt->bindParam(':codeevent', $this->CodeEvent,PDO::PARAM_STR);

        if($stmt->execute())
            return $stmt;

        die("Error in search function!");
    }
}
?>