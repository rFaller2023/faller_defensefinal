<?php
include "../classes/interface.php";
include "../database/database.php";

class Students extends Db implements DbConnection
{
    public $TableName = "name_of_anime";

    public function createTable()
    {
        $this->connection();

        $createtable = "CREATE TABLE IF NOT EXISTS $this->TableName
        (
        id int auto_increment primary key,
        anime_title varchar(255) not null,
        manga_authors varchar(255) not null,
        genre varchar(255) not null,
        bias varchar(255)not null,
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
        $animeTitle = $params['anime_title'] ?? '';
        $manga_authors = $params['manga_authors'] ?? '';
        // $email = $params['email'] ?? '';
        // $course = $params['course'] ?? '';

        $search = "SELECT * FROM $this->TableName where anime_title like '%$animeTitle%'";

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
        $anime = $this->conn->query("SELECT * FROM $this->TableName");

        
        $animeList = [];
        
        return json_encode($anime->fetch_all(MYSQLI_ASSOC));
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
        if(!isset($params['anime_title']) || empty($params['anime_title']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Anime title is Required!"
                ]
                );
        }
        if(!isset($params['manga_authors']) || empty($params['manga_authors']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Manga author is Required!"
                ]
                );
        }
        if(!isset($params['genre']) || empty($params['genre']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Genre is Required!"
                ]
                );
        }
        if(!isset($params['bias']) || empty($params['bias']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Bias is Required!"
                ]
                );
        }
        
        $anime_title = $params['anime_title'];
        $manga_authors = $params['manga_authors'];
        $genre = $params['genre'];
        $bias = $params['bias'];

        $insert = "INSERT INTO $this->TableName(anime_title, manga_authors, genre, bias)
        VALUES('$anime_title','$manga_authors','$genre','$bias')";

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
                "message" => "Anime Not Found!"
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
        if(!isset($params['anime_title']) || empty($params['anime_title']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Anime title is Required!"
                ]
                );
        }
        if(!isset($params['manga_authors']) || empty($params['manga_authors']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Mangga author is Required!"
                ]
                );
        }
        if(!isset($params['genre']) || empty($params['genre']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Genre is Required!"
                ]
                );
        }
        if(!isset($params['bias']) || empty($params['bias']))
        {
            return json_encode(
                [
                    'code' => 404,
                    'message' => "Bias is Required!"
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
        $anime_title = $params['anime_title'];
        $manga_authors = $params['manga_authors'];
        $genre = $params['genre'];
        $bias = $params['biass'];

        $update = "UPDATE $this->TableName 
        SET anime_title = '$anime_title', manga_authors = '$manga_authors', email = '$genre', course = '$bias' 
        where id='$id'";

         $isupdated = $this->conn->query($update);

        if($isupdated)
        {
            return json_encode(
                [
                    "code" => 101,
                    "message" => "Anime_title Successfully Updated!"
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
                    "message" => "Anime_tiltle Successfully Deleted!"
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