<?php 
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="./controllers/main.js"></script>
    <link rel="stylesheet" href="./styles/reset.css">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/header.css">
    <title>Narrow Cast - Add user</title>
    <style>
    
        .container {
            width: 100%;
            height: calc(100% - 60px);
            display: flex;
            justify-content: center;
            flex-direction: column;
        }
        .module > * {
            display: flex;
            align-items: center;
            flex-direction: column;
            margin: 10px auto;
        }
        
        .module > input[type="text"] {
            padding: .5rem .5rem;
            outline: none;
        }
        
        .save-button {
            border: none;
            padding: .8em 1.2em;
            background-color:
            #002159;
            color:
            #ffffff;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: .8rem;
            cursor: pointer;
        }
        
    </style>
</head>
<body>
   <?php include './includes/navbar.php'; ?>
    <div class="container">
        <form class="module" onsubmit="return false;">
            <span>Naam:</span> <input type="text" name="username" autocomplete="off">
            <span>Wachtwoord:</span><input type="text" name="password">
            <input type="submit" class="save-button" onclick="createUser(this)" value="Opslaan">
        </form>
    </div>
</body>
</html>