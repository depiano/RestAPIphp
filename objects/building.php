<?php
class Building
{
    private $conn;
    private $table_name = "Building";

    public $Code;
    public $Latitude;
    public $Longitude;
    public $Description;
    public $EmailUser;

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
					Code=:code, Latitude=:latitude, Longitude=:longitude, Description=:description, EmailUser=:emailuser";

        $stmt = $this->conn->prepare($query);

        $this->Code=htmlspecialchars(strip_tags($this->Code));
        $this->Latitude=htmlspecialchars(strip_tags($this->Latitude));
        $this->Longitude=htmlspecialchars(strip_tags($this->Longitude));
        $this->Description=htmlspecialchars(strip_tags($this->Description));
        $this->EmailUser=htmlspecialchars(strip_tags($this->EmailUser));

        $stmt->bindParam(":code", $this->Code);
        $stmt->bindParam(":latitude", $this->Latitude);
        $stmt->bindParam(":longitude", $this->Longitude);
        $stmt->bindParam(":description", $this->Description);
        $stmt->bindParam(":emailuser", $this->EmailUser);

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
					  	Description=:description WHERE Code=:code";

        $stmt = $this->conn->prepare($query);

        $this->Code = htmlspecialchars(strip_tags($this->Code));
        $this->Description = htmlspecialchars(strip_tags($this->Description));

        $stmt->bindParam(':code', $this->Code,PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->Description, PDO::PARAM_STR);

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

    function searchByLatLong(){

     $query = "SELECT * FROM " . $this->table_name . " WHERE Latitude=:latitude AND Longitude=:longitude";

        $stmt = $this->conn->prepare($query);

        $this->Latitude = htmlspecialchars(strip_tags($this->Latitude));
        $this->Longitude = htmlspecialchars(strip_tags($this->Longitude));

        $stmt->bindParam(':latitude', $this->Latitude,PDO::PARAM_STR);
        $stmt->bindParam(':longitude', $this->Longitude,PDO::PARAM_STR);

        if($stmt->execute())
            return $stmt;

        die("Error in search function!");
    }
}
?>

