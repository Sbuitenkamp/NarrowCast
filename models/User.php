<?php
class User
{
    private $userId;
    private $username;
    private $password;
    private $db;

    public function __construct($username = null, $password = null, $db = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->db = $db;
    }

    public function login() 
    { 
        header("location: index.php");
    }

    public function authenticate() 
    {
        $this->checkUserExist();
    }

    public function checkUserExist() 
    {
        $stmt = $this->db->connect()->prepare("SELECT username, password FROM users WHERE username = ?");
        if ($stmt->execute(array($this->username))) {
            if ($row = $stmt->fetch()) $this->verifyPassword($row['password']);
        } else {
            header("location: login.php?username=USERNAME&password=PASSWORD");
            exit();
        }
    }

    public function verifyPassword($userPassword)
    {
        $this->userId = $userId;
        if (password_verify($this->password, $userPassword)) {
            $_SESSION['username'] = $this->username;
            $_SESSION['valid_until'] = time() + 60*60;
            $this->login();
            exit();
        } else {
            header("location: login.php?username=USERNAME&password=PASSWORD");
            exit();
        }
    }
}

