<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Narrow Cast - Add module</title>
    <script src="./controllers/main.js"></script>
</head>
<body>
    <div class="container">
        <form class="module" action="./admin.php" onsubmit="createModule(this)">
            Module naam: <input type="text" name="name">
            Interval in seconden: <input type="text" name="timeout">
            <input type="submit">Opslaan</input>
        </form>
    </div>
</body>
</html>