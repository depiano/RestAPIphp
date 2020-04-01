<?php
class Status
{
    private $conn;
    private $table_name = "Status";

    public $EmailUser;
    public $CodeEvent;
    public $DateHour;
    public $Safe;

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
					EmailUser=:emailuser, CodeEvent=:codeevent, DateHour=:datehour, Safe=:safe";

        $stmt = $this->conn->prepare($query);

        $this->EmailUser=htmlspecialchars(strip_tags($this->EmailUser));
        $this->CodeEvent=htmlspecialchars(strip_tags($this->CodeEvent));
        $this->DateHour=htmlspecialchars(strip_tags($this->DateHour));
        $this->Safe=htmlspecialchars(strip_tags($this->Safe));

        $stmt->bindParam(":emailuser", $this->EmailUser);
        $stmt->bindParam(":codeevent", $this->CodeEvent);
        $stmt->bindParam(":datehour", $this->DateHour);
        $stmt->bindParam(":safe", $this->Safe);

        if($stmt->execute()){
            return true;
        }

        return false;

    }

    function search(){

        $query = "SELECT * FROM " . $this->table_name . " WHERE EmailUser=:emailuser AND CodeEvent=:codeevent";

        $stmt = $this->conn->prepare($query);

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