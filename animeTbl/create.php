<?php
include "anime2.php";
header("Content-type: application/json; charset=UTF-8");
$new = new Students();
$new->createTable();
// echo $new->getAll();
echo $new->create($_POST); 

?>