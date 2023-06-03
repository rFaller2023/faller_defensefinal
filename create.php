<?php
include 'database.php';
class Employee extends Database 
{
    public $tblName="employee";

    public function __construct()
    {
    
        $create="CREATE TABLE IF NOT EXISTS $this->tblName (
            id int primary key auto_increment,
            first_name varchar(200),
            last_name varchar(200)
            )";

           
}
}