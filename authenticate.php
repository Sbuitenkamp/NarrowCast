<?php
require './models/User.php';

$user = new User();

if(isset($_POST['login'])) {
    require_once './models/Db.php';

    $realpass = 'test123';
    $options = [
        'cost' => 12
    ];

    $password = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
    if(password_verify($realpass, $password)) {
        echo 'good<br>';
        echo $password;
    } else {
        echo 'bad<br>';
    }
    // $user->login();
}
