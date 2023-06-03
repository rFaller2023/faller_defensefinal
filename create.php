<?php
include 'index.php';
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
    $in="INSERT INTO $this->tblName
    VALUES (NULL,'One Piece','Eiichiro Oda')";
    $this->conn->query($in);
    var_dump($this->conn->error);
}
}
// $r= new Anime();
// $r->table();
// $r->insert();