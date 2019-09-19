<?php
session_start();
require_once './models/Db.php';
require './models/User.php';
require './models/token.php';

$username = $_POST['username'];
$password = $_POST['password'];

$user = new User($username, $password, new Db());
$token = new Token();

$_SESSION['csrf-token'] = $_POST['csrf-token'];

if ($_SESSION['csrf-token'] != $_POST['csrf-token']) exit();
$user->authenticate();
