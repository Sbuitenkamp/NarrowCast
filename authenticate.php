<?php
require './models/User.php';
require_once './models/Db.php';
$username = $_POST['username'];
$password = $_POST['password'];

$user = new User($username, $password, new Db());

$user->authenticate();