<?php
class People
{
    private $conn;
    private $table_name = "People";

    public $Name;
    public $Surname;
    public $Email;
    public $Password;
    public $Householder;
    public $Sex;

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
					Name=:name, Surname=:surname, Email=:email, Password=:password, Householder=:householder, Sex=:sex";

        $stmt = $this->conn->prepare($query);

        $this->Name=htmlspecialchars(strip_tags($this->Name));
        $this->Surname=htmlspecialchars(strip_tags($this->Surname));
        $this->Email=htmlspecialchars(strip_tags($this->Email));
        $this->Password=htmlspecialchars(strip_tags($this->Password));
        $this->Householder=htmlspecialchars(strip_tags($this->Householder));
        $this->Sex=htmlspecialchars(strip_tags($this->Sex));

        $stmt->bindParam(":name", $this->Name);
        $stmt->bindParam(":surname", $this->Surname);
        $stmt->bindParam(":email", $this->Email);
        $stmt->bindParam(":password", $this->Password);
        $stmt->bindParam(":householder", $this->Householder);
        $stmt->bindParam(":sex", $this->Sex);

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
					  	Password=:password WHERE Email=:email";

        $stmt = $this->conn->prepare($query);

        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $this->Password = htmlspecialchars(strip_tags($this->Password));

        $stmt->bindParam(':email', $this->Email,PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->Password, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function search(){

    $query = "SELECT Name,Surname, Email, Householder, Sex FROM " . $this->table_name . " WHERE Email=:email";

        $stmt = $this->conn->prepare($query);

        $this->Email = htmlspecialchars(strip_tags($this->Email));

        $stmt->bindParam(':email', $this->Email,PDO::PARAM_STR);

        if($stmt->execute())
            return $stmt;

        die("Error in search function!");
    }

    function searchFamily(){

        $query = "SELECT * FROM " . $this->table_name . " WHERE Email=:email OR Householder=:email";

        $stmt = $this->conn->prepare($query);

        $this->Email = htmlspecialchars(strip_tags($this->Email));

        $stmt->bindParam(':email', $this->Email,PDO::PARAM_STR);

        if($stmt->execute())
            return $stmt;

        die("Error in search function!");
    }
}
?>