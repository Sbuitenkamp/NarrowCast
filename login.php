<?php
require_once './models/Db.php';
require_once './models/User.php';
session_unset();
session_destroy();

$db = new Db();

?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Narrow Cast - Login</title>
    <script defer src="js/form-validation.js"></script>
</head>
<body>
<?php if(!isset($_SESSION['username'])): ?>
    <form class="form" id="form" action="authenticate.php" method="post" onsubmit="return validateForm();">
        <span class="error" id="validation-message"></span>
        <div class="form__group">
            <input id="validate-username" type="text" name="username" autocomplete="off">
            <label for="username">Gebruikersnaam</label>
        </div>
        <div class="form__group">
            <input id="validate-password" type="text" name="password" autocomplete="off">
            <label for="password">Wachtwoord</label>
        </div>
        <input type="submit" name="login" value="login">
    </form>
<?php else: ?>
    <span class="logged-in">You're already logged in</span>
<?php endif; ?>
</body>
</html>
