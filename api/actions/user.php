<?php
include_once 'api/actions/validate.php';
include_once 'api/objects/user.php';

class UserAction{

    private $conn;
    private $required = ['id', 'user', 'secret'];

    public function __construct($db){
        $this->conn = $db;
    }

    public function addUser($parameters)
    {
        if (!Validate::checkAccess($parameters)){
            echo json_encode(['error' => 'access denied']);
            return;
        }
        elseif(!Validate::checkParameters($this->required, $parameters)){
            echo json_encode(['error' => 'missing parameter']);
            return;
        }

        $user = new User($this->conn);

        $user->username = $parameters['user'];

        if($user->add()){
            return;
        }
        else{
            echo json_encode(['error' => 'internal error']);
            return;
        }
    }

    public function deleteUser($parameters)
    {
        if (!Validate::checkAccess($parameters)){
            echo json_encode(['error' => 'access denied']);
            return;
        }
        elseif(!Validate::checkParameters($this->required, $parameters)){
            echo json_encode(['error' => 'missing parameter']);
            return;
        }

        $user = new User($this->conn);

        $user->username = $parameters['user'];

        if($user->delete()){
            return;
        }
        else{
            echo json_encode(['error' => 'internal error']);
            return;
        }
    }
}

?>