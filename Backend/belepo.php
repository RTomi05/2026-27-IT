<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belépés</title>
    <style>
        input{
            margin: 20px;
        }
    </style>
</head>
<body>
    <?php
    $login = false;

    //ellenőrzés
    if(isset($_POST["user"]) && isset($_POST["pass"]))
        {
            $login = $_POST["user"] === "admin" && $_POST["pass"] === "admin";
        }

    if(!$login)
        {
            //űrlap
    ?>  
            <h1>Belépés</h1>
            <form action="belepo.php" method="post">
                <label for="">Username:<input type="text" name="user"></label>
                <label for="">Password:<input type="password" name="pass"></label>
                <button type="submit">belépés</button>
            </form>
    <?php
        }
    else
        {
            //üzenet
            echo "<h1>Belépve</h1>";
            echo '<a href="belepo.php">katt ide!</a>';
        }
    ?>
</body>
</html>