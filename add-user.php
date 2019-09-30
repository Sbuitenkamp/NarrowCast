<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="./controllers/main.js"></script>
    <title>Narrow Cast - Add user</title>
</head>
<body>
    <div class="container">
        <form class="module" onsubmit="return false;">
            Naam: <input type="text" name="username">
            Wachtwoord: <input type="text" name="password">
            <input type="submit" onclick="createUser(this)">Opslaan</input>
        </form>
    </div>
</body>
</html>