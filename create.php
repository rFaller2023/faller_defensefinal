<?php
include 'index.php';

header("Content-Type: application/json; charset=utf-8");
class Anime extends Database 
{
    public $tblName="anime";

    public function table()
    {
    
        $create="CREATE TABLE IF NOT EXISTS $this->tblName (
            id int primary key auto_increment,
            anime_name varchar(200),
            manga_author varchar(200)
            )";
    $this->conn->query($create);
           
}
public function insert()
{
    $in="INSERT INTO $this->tblName (anime_name, manga_author)
    VALUES (NULL,'$an','$ma')";
    $this->conn->query($in);
    var_dump($this->conn->error);
}
public function getAll()
{
    $sel= "SELECT * FROM $this->tblName";
    return $this->conn->query($sel);
}
}
// $r= new Anime();
// $r->table();
// $r->insert();