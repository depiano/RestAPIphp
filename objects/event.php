<?php
class Event
{
    private $conn;
    private $table_name = "Event";
  
    public $Code;
    public $Latitude;
	public $Longitude;
    public $Description;
    public $Disabled;
	public $DateHour;
	
    public function __construct($db)
	{
        $this->conn = $db;
    }
	
	public function read()
	{
		$query = "SELECT * FROM " . $this->table_name;
	  
		$stmt = $this->conn->prepare($query);
	  
		$stmt->execute();
	  
		return $stmt;
	}
	
	public function create()
	{
		$query = "INSERT INTO
					" . $this->table_name . "
				SET
					Code=:code, Latitude=:latitude, Longitude=:longitude, Description=:description, Disabled=:disabled, DateHour=:datehour";

		$stmt = $this->conn->prepare($query);
	  
		$this->Code=htmlspecialchars(strip_tags($this->Code));
		$this->Latitude=htmlspecialchars(strip_tags($this->Latitude));
		$this->Longitude=htmlspecialchars(strip_tags($this->Longitude));
		$this->Description=htmlspecialchars(strip_tags($this->Description));
		$this->Disabled=htmlspecialchars(strip_tags($this->Disabled));
		$this->DateHour=htmlspecialchars(strip_tags($this->DateHour));
	  
		$stmt->bindParam(":code", $this->Code);
		$stmt->bindParam(":latitude", $this->Latitude);
		$stmt->bindParam(":longitude", $this->Longitude);
		$stmt->bindParam(":description", $this->Description);
		$stmt->bindParam(":disabled", $this->Disabled);
		$stmt->bindParam(":datehour", $this->DateHour);
	  
		if($stmt->execute()){
			return true;
		}
	  
		return false;
		  
	}

	function update()
	{

		$query = "UPDATE
					" . $this->table_name . "
					 SET
					  	Disabled=:disabled WHERE Code=:code";

		$stmt = $this->conn->prepare($query);

		$this->Code = htmlspecialchars(strip_tags($this->Code));
		$this->Disabled = htmlspecialchars(strip_tags($this->Disabled));

		$stmt->bindParam(':code', $this->Code,PDO::PARAM_STR);
		$stmt->bindParam(':disabled', $this->Disabled, PDO::PARAM_BOOL);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	function search(){

		$query = "SELECT * FROM " . $this->table_name . " WHERE Code=:code";

		$stmt = $this->conn->prepare($query);

		$this->Code = htmlspecialchars(strip_tags($this->Code));
		$stmt->bindParam(':code', $this->Code,PDO::PARAM_STR);

		if($stmt->execute())
			return $stmt;

		die("Error in search function!");
	}
}
?>

