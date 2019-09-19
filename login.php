<?php
require './models/Db.php';
require './models/User.php';
require './models/token.php';
session_unset();
session_destroy();

$db = new Db();
$user = new User();
$token = new Token();

$db->connect();
$_SESSION['csrf-token'] = $token->generate();
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Narrow Cast - Login</title>
    <script defer src="js/main.js"></script>
    <script defer src="js/form-validation.js"></script>
    <script src="js/fastclick.js"></script>
</head>
<body>
<?php if(!isset($_SESSION['username'])): ?>
<div class="login">
    <div class="login__background"></div>
    <div class="background--overlay"></div>
    <div class="login__container">
        <div class="login__logo"><img src="./images/logo.png"></div>
        <form class="login__form" id="form" action="authenticate.php" method="post" onsubmit="return validateForm();">
            <input type="text" style="display:none;" name="csrf-token" value="<?= $_SESSION['csrf-token']; ?>">
            <span class="error" id="validation-message"></span>
            <div class="form__group">
                <input type="text" id="validate-username" name="username" autocomplete="off" required>
                <label class="label-float" for="username">Gebruikersnaam</label>
            </div>
            <div class="form__group">
                <input type="password" id="validate-password" name="password" autocomplete="off" required>
                <label class="label-float" for="password">Wachtwoord</label>
            </div>
            <input class="form__login-btn" type="submit" name="login" value="Login">
        </form>
    </div>
<?php else: ?>
    <span class="logged-in">You're already logged in</span>
<?php endif; ?>
    <div class="footer">
        <span class="footer__copyright">Copyright © 2019 ROC Friesepoort</span>
    </div>     
</div>
</body>
</html>
