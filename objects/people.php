<?php
class People
{
    // database connection and table name
    private $conn;
    private $table_name = "People";

    // object properties
    public $Name;
    public $Surname;
    public $Email;
    public $Password;
    public $Householder;
    public $Sex;

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
					Name=:name, Surname=:surname, Email=:email, Password=:password, Householder=:householder, Sex=:sex";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->Name=htmlspecialchars(strip_tags($this->Name));
        $this->Surname=htmlspecialchars(strip_tags($this->Surname));
        $this->Email=htmlspecialchars(strip_tags($this->Email));
        $this->Password=htmlspecialchars(strip_tags($this->Password));
        $this->Householder=htmlspecialchars(strip_tags($this->Householder));
        $this->Sex=htmlspecialchars(strip_tags($this->Sex));

        // bind values
        $stmt->bindParam(":name", $this->Name);
        $stmt->bindParam(":surname", $this->Surname);
        $stmt->bindParam(":email", $this->Email);
        $stmt->bindParam(":password", $this->Password);
        $stmt->bindParam(":householder", $this->Householder);
        $stmt->bindParam(":sex", $this->Sex);

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
					  	Password=:password WHERE Email=:email";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $this->Password = htmlspecialchars(strip_tags($this->Password));
        // bind new values
        $stmt->bindParam(':email', $this->Email,PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->Password, PDO::PARAM_STR);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // search products
    function search(){

        // select all query
        $query = "SELECT Name,Surname, Email, Householder, Sex FROM " . $this->table_name . " WHERE Email=:email";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        // bind new values
        $stmt->bindParam(':email', $this->Email,PDO::PARAM_STR);

        if($stmt->execute())
            return $stmt;

        die("Error in search function!");
    }

    // search products
    function searchFamily(){

        // select all query
        $query = "SELECT * FROM " . $this->table_name . " WHERE Email=:email OR Householder=:email";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        // bind new values
        $stmt->bindParam(':email', $this->Email,PDO::PARAM_STR);

        if($stmt->execute())
            return $stmt;

        die("Error in search function!");
    }
}
?>