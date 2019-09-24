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
        <title>Narrow Cast</title>
    </head>
    <body>
    
    <div class="footer">
        <span class="footer__copyright">Copyright © 2019 ROC Friesepoort</span>
    </div>
    </body>
    </html>
<?php endif; ?>