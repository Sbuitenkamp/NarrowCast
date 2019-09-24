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
        <link rel="stylesheet" href="./styles/style.css">
        <script src="./controllers/admin.js"></script>
        <title>Narrow Cast</title>
    </head>
    <body>
        <!--todo add styling, teshale ples UwU-->
        <div class="header">
            <h1>Narrowcast Admin Panel</h1>
            <p><?=$_SESSION['username'];?></p>
            <button onclick="logOut();">Log Uit</button>
        </div>
        <div class="animations-container">
            <form action="">
                <input type="radio" value="0" name="animation">Geen
                <input type="radio" value="1" name="animation">Fade
                <input type="radio" value="2" name="animation">Swipe
                <button type="button" onclick="changeAnimation(this)">Verstuur</button>
            </form>
        </div>
        <div class="settings-container"></div>
        <div class="footer">
            <span class="footer__copyright">Copyright © 2019 ROC Friesepoort</span>'
        </div>
    </body>
    </html>
<?php endif; ?>