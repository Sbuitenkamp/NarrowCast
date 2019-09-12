<?php
if(!isset($_SESSION['username'])) {
    echo 'not logged in <br>';
} else {
    echo 'logged in<br>';
}

require './models/Db.php';

$db = new Db();

$db->connect();

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
    <form action="authenticate.php" method="post" class="form">
        <div class="form__group">
            <input type="text" name="username" autocomplete="off">
            <label for="username">Gebruikersnaam</label>
        </div>
        <div class="form__group">
            <input type="text" name="password" autocomplete="off">
            <label for="password">Wachtwoord</label>
        </div>
        <input type="submit" name="login" value="login">
    </form>
</body>
</html>
