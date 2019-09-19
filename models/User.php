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
        header("location: admin.php");
    }

    public function authenticate() 
    {
        $this->checkUserExist();
    }

    public function checkUserExist() 
    {
        $stmt = $this->db->connect()->prepare("SELECT username, password FROM users WHERE username = ?");
        if ($stmt->execute(array($this->username))) {
            if ($row = $stmt->fetch()) {
                $this->verifyPassword($row['password']);
                exit();
            } else {
                header("location: login.php?username=USERNAME&password=PASSWORD");
                exit();
            }
        } 
    }

    public function verifyPassword($userPassword)
    {
        $token_length = 32;

        if (password_verify($this->password, $userPassword)) {
            $_SESSION['username'] = $this->username;
            $_SESSION['valid_until'] = time() + 60*60;
            $_SESSION['csrf-token'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $token_length);
            $this->login();
            exit();
        } else {
            header("location: login.php?username=USERNAME&password=PASSWORD");
            exit();
        }
    }
}

