<?php
include "../classes/abstract.php";

class Db extends Database
{
    public $conn;
    public $servername = "localhost";
    public $username = "root";
    public $password = "";
    public $DbName = "defense_oop";

    public function connection()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password);
        $this->conn->query("CREATE DATABASE IF NOT EXISTS $this->DbName");
        $this->conn->query("USE $this->DbName");
      
    }
    public function db_error()
    {
        return $this->conn->error;
    }
}



?>