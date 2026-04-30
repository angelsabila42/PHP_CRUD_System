<?php
class Database {
    private String $servername = "localhost";
    private String $username = "root";
    private String $password = "";
    private String $dbname = "studentDB";
    public ?PDO $conn;

//Create Connection
public function connect(){
    $this->conn = null;

    try{
    $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname",
                            $this->username, $this->password);
        //Set the PDO error mode to exception
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    ///echo "Connected Successfully";
    }catch(PDOException $e){
        echo "Connection Failed: " . $e->getMessage();
    }
    
    return $this->conn;

 }
}


?>