<?php

require_once './models/Db.php';
require_once './models/User.php';

$db = new Db();

?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Narrow Cast - Login</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="username">
        <input type="submit" name="login" value="login">
    </form>
</body>
</html>
