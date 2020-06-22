<?php
include_once 'api/config.php';

class User{

    // database connection and table name
    private $conn;
    private $table_name = "users";

    // object properties
    public $username;


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    public function add(){
            // query to insert record
            $query = 'INSERT INTO ' . $this->table_name . ' SET username="'.$this->username.'"';

            // prepare query
            $stmt = $this->conn->prepare($query);

            // execute query
            if($stmt->execute()){
                return true;
            }

            return false;
    }

    public function delete(){

        $query = 'DELETE FROM '. $this->table_name . ' WHERE username="'.$this->username.'"';

        // prepare query
        $stmt = $this->conn->prepare($query);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function getAll(){

        $query = 'SELECT username FROM ' . $this->table_name;

        // prepare query
        $stmt = $this->conn->prepare($query);
        $users = [];
        // execute query
        if($stmt->execute()){
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = $row['username'];
            }
            return $users;
        }

        return false;
    }
}