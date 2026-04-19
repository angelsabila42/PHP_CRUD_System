<?php
class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "studentDB";
    public $conn;

//Create Connection
public function connect(){
    $this->conn = null;

    try{
    $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
    //Set the PDO error mode to exception
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected Successfully";
    }catch(PDOException $e){
   echo "Connection Failed: " . $e->getMessage();
    }
    return $this->conn;

 }
}


?>