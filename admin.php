<?php
include_once('./models/Db.php');

$db = new Db();

$logged_in = false;
$uri = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if (isset($_SESSION['username'])) {
    if (!$_SESSION['valid_until'] >= time()) $logged_in = false;
    $logged_in = true;
}
?>

<?php if(!$logged_in): ?>   
    <?= '<h1>Toegang geweigerd!</h1>'; ?>
    <?= '<span>U heeft geen toegang om ' . $uri . ' te betreden.</span>'; ?>
<?php else: ?>
    <!doctype html>
    <html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="./styles/reset.css">
        <link rel="stylesheet" href="./styles/style.css">
        <link rel="stylesheet" href="./styles/admin.css">
        <link rel="stylesheet" href="./styles/header.css">
        <link rel="stylesheet" href="./styles/footer.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--IMPORTANT: main needs to be loaded first-->
        <script defer src="./controllers/main.js"></script>
        <script defer src="./controllers/admin-bundle.js"></script>
        <title>Narrow Cast - Admin panel</title>
    </head>
    <body>
        <!--todo add styling, teshale ples UwU-->
        <div class="header">
            <h2 class="header__title">Narrowcast Admin Panel</h2>
            <div class="header__logout-container">
                <p class="username"><?=$_SESSION['username'];?></p>
                <button class="logout-btn" onclick="logOut();">Log Uit</button>
            </div>
        </div>
        <div class="animations-container">
            <form class="animations-container" action="">
            <h2>Kies animatie:</h2>
            </form>
        </div>
        <div class="add">
            <a href="./add-module.php" class="add__button">Module Toevoegen</a>
        </div>
        <div class="sort">
            <div class="sort-container">
                <ul class="sort-container__list"></ul>
            </div>
            <div class="sort-items">
                <ul class="sort-items__list"></ul>
            </div>
            <button class="save-button" onclick="orderOnClick()">Opslaan</button>
        </div>
        <div class="settings-container"></div>
        <div class="footer">
            <span class="footer__copyright">Copyright © 2019 ROC Friesepoort</span>
        </div>
    </body>
    </html>
<?php endif; ?>