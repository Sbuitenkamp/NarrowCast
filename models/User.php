<?php
class User
{
    private $userName;
    private $password;
    private $db;

    public function __construct($userName = null, $password = null, $db = null)
    {
        $this->userName = $userName;
        $this->password = $password;
        $this->db = $db;
    }

    public function login() 
    {       
        $this->password = $_POST['password'];
        
        echo $this->password;
    }


}

