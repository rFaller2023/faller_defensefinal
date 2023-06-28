<?php
include "../classes/interface.php";
include "../database/database.php";

class Students extends Db implements DbConnection
{
    public $TableName = "name_of_students";

    public function createTable()
    {
        $this->connection();

        $createtable = "CREATE TABLE IF NOT EXISTS $this->TableName
        (
        id int auto_increment primary key,
        anime_title varchar(255) not null,
        genre varchar(255) not null,
        published varchar(255) not null,
        login varchar(10) not null default 0
        )";

        $this->conn->query($createtable);
        
    }
    public function search($params)
    {
        if($_SERVER['REQUEST_METHOD'] != 'GET')
        {
            return json_encode(
                [
                    "code" => 404,
                    "message" => "GET method is only allowed!"
                ]
                );
        }
        $first_name = $params['first_name'] ?? '';
        $last_name = $params['last_name'] ?? '';
        // $email = $params['email'] ?? '';
        // $course = $params['course'] ?? '';

        $search = "SELECT * FROM $this->TableName where first_name like '%$first_name%'";

         $issearch = $this->conn->query($search); 

        if(empty($this->db_error()))
        {
            return json_encode($issearch->fetch_all(MYSQLI_ASSOC));
        }else{
            return json_encode(
                [
                    "code" => 101,
                    "message" => $this->db_error(),
                ]
                ); 
        }

    }
    public function getAll()
    {
        $students = $this->conn->query("SELECT * FROM $this->TableName");

        
        $studentsList = [];
        
        return json_encode($students->fetch_all(MYSQLI_ASSOC));
    }
    public function create($params)
    {
        if($_SERVER['REQUEST_METHOD'] != 'GET')
        {
            return json_encode(
                [
                    "code" => 404,
                    "message" => "GET method is only allowed!"
                ]
                );
        }
        if(!isset($params['first_name']) || empty($params['first_name']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "First_name is Required!"
                ]
                );
        }
        if(!isset($params['last_name']) || empty($params['last_name']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Last_name is Required!"
                ]
                );
        }
        if(!isset($params['email']) || empty($params['email']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Email is Required!"
                ]
                );
        }
        if(!isset($params['course']) || empty($params['course']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Course is Required!"
                ]
                );
        }
        
        $first_name = $params['first_name'];
        $last_name = $params['last_name'];
        $email = $params['email'];
        $course = $params['course'];

        $insert = "INSERT INTO $this->TableName(first_name, last_name, email, course)
        VALUES('$first_name','$last_name','$email','$course')";

        $isadded = $this->conn->query($insert);

        if($isadded)
        {
            return json_encode(
                [
                    "code" => 101,
                    "message" => "Added Successfully!"
                ]
                );
        }else{
            return json_encode(
                [
                    "code" => 101,
                    "message" => $this->db_error(),
                ]
                ); 
        }

      
    }
    public function getid($getid)
    {
        if(!isset($getid['id']) || empty($getid['id']))
        {
            $response = [
                'code' => 102,
                'message' => 'id is required'
            ];

            return json_encode($response);
        }
        $id = $getid['id'];

        $data = $this->conn->query("SELECT * FROM $this->TableName WHERE id='$id'");

        if($data->num_rows == 0)
        {
            $response = [
                "code" => 404,
                "message" => "Student Not Found!"
            ];
            return json_encode($response);
        }
        return json_encode($data->fetch_assoc());
    }
    public function update($params)
    {
        if($_SERVER['REQUEST_METHOD'] != 'GET')
        {
            return json_encode(
                [
                    "code" => 404,
                    "message" => "GET method is only allowed!"
                ]
                );
        }
        if(!isset($params['first_name']) || empty($params['first_name']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "First_name is Required!"
                ]
                );
        }
        if(!isset($params['last_name']) || empty($params['last_name']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Last_name is Required!"
                ]
                );
        }
        if(!isset($params['email']) || empty($params['email']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Email is Required!"
                ]
                );
        }
        if(!isset($params['course']) || empty($params['course']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Course is Required!"
                ]
                );
        }
        if(!isset($params['id']) || empty($params['id']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Id  is Required!"
                ]
                );
        }
        $id = $params['id'];
        $first_name = $params['first_name'];
        $last_name = $params['last_name'];
        $email = $params['email'];
        $course = $params['course'];

        $update = "UPDATE $this->TableName 
        SET first_name = '$first_name', last_name = '$last_name', email = '$email', course = '$course' 
        where id='$id'";

         $isupdated = $this->conn->query($update);

        if($isupdated)
        {
            return json_encode(
                [
                    "code" => 101,
                    "message" => "Student Successfully Updated!"
                ]
                );
        }else{
            return json_encode(
                [
                    "code" => 101,
                    "message" => $this->db_error(),
                ]
                ); 
        }
    }
    public function delete($params)
    {
        if($_SERVER['REQUEST_METHOD'] != 'GET')
        {
            return json_encode(
                [
                    "code" => 404,
                    "message" => "GET method is only allowed!"
                ]
                );
        }
     
        if(!isset($params['id']) || empty($params['id']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Id  is Required!"
                ]
                );
        }
        $id = $params['id'];

        $delete = "DELETE FROM $this->TableName 
        where id='$id'";

         $isdeleted = $this->conn->query($delete);

        if($isdeleted)
        {
            return json_encode(
                [
                    "code" => 101,
                    "message" => "Student Successfully Deleted!"
                ]
                );
        }else{
            return json_encode(
                [
                    "code" => 101,
                    "message" => $this->db_error(),
                ]
                ); 
        }
    }
    }
   


?>