<?php
class Event
{
    // database connection and table name
    private $conn;
    private $table_name = "Event";
  
    // object properties
    public $Code;
    public $Latitude;
	public $Longitude;
    public $Description;
    public $Disabled;
	public $DateHour;
	
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
					Code=:code, Latitude=:latitude, Longitude=:longitude, Description=:description, Disabled=:disabled, DateHour=:datehour";

		// prepare query
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		$this->Code=htmlspecialchars(strip_tags($this->Code));
		$this->Latitude=htmlspecialchars(strip_tags($this->Latitude));
		$this->Longitude=htmlspecialchars(strip_tags($this->Longitude));
		$this->Description=htmlspecialchars(strip_tags($this->Description));
		$this->Disabled=htmlspecialchars(strip_tags($this->Disabled));
		$this->DateHour=htmlspecialchars(strip_tags($this->DateHour));
	  
		// bind values
		$stmt->bindParam(":code", $this->Code);
		$stmt->bindParam(":latitude", $this->Latitude);
		$stmt->bindParam(":longitude", $this->Longitude);
		$stmt->bindParam(":description", $this->Description);
		$stmt->bindParam(":disabled", $this->Disabled);
		$stmt->bindParam(":datehour", $this->DateHour);
	  
		// execute query
		if($stmt->execute()){
			return true;
		}
	  
		return false;
		  
	}

	function update()
	{

		// update query
		$query = "UPDATE
					" . $this->table_name . "
					 SET
					  	Disabled=:disabled WHERE Code=:code";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->Code = htmlspecialchars(strip_tags($this->Code));
		$this->Disabled = htmlspecialchars(strip_tags($this->Disabled));
		// bind new values
		$stmt->bindParam(':code', $this->Code,PDO::PARAM_STR);
		$stmt->bindParam(':disabled', $this->Disabled, PDO::PARAM_BOOL);

		// execute the query
		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	// search products
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
}
?>

