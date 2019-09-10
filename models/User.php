<?php
class User
{
    public $userName;
    public $password;
    public $db;

    public function __construct($userName = null, $password = null, $db = null)
    {
        $this->userName = $userName;
        $this->password = $password;
        $this->db = $db;
    }
}