<?php
include_once('./controllers/index.php');
include_once('./models/Db.php');

$db = new Db();
$result = $db->select([["name", "activated", "timeout", "frequency"], "modules", null, "2"]);
foreach ($result as $res) {
    print_r($res);
    echo "<br>";
}
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Narrow Cast</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="controllers/index.js"></script>
</head>
<body>
<?php if (isset($_POST['url'])) load($_POST['url']);?>
<div class="footer"></div>
</body>
</html>