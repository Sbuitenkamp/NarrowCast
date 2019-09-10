<?php
// dynamic controller including because effort
$files = glob('./controllers/*.{php}', GLOB_BRACE);
foreach($files as $file) {
    include_once($file);
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
</head>
<body>

</body>
</html>
