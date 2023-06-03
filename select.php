<?php

header("Content-Type: application/json; charset=utf-8");

$sel= "SELECT * FROM $this->tblName";
return $this->conn->query($sel);