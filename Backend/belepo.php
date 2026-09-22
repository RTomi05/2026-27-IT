<?php
    session_start();
    $login = false;

    //ellenőrzés
    if(isset($_POST["kilepes"]))
        {
            session_destroy();
            header("Refresh: 0");
            //header("Location: " . $_SERVER['PHP_SELF']);
            die();
        }

    if(isset($_POST["user"]) && isset($_POST["pass"]))
        {
            $login = $_POST["user"] === "admin" && $_POST["pass"] === "admin";
            if($login)
                {
                    $_SESSION["belepve"] = true;
                    $_SESSION["user"] = htmlspecialchars($_POST["user"]);

                    header("Location: " . $_SERVER['PHP_SELF']);
                    die();
                }
        }



    if(!isset($_SESSION["belepve"]) || !$_SESSION["belepve"])
        {
            //űrlap
    ?>  
            <h1>Belépés</h1>
            <form action="belepo.php" method="post">
                <label for="">Username: <input type="text" name="user"></label>
                <label for="">Password: <input type="password" name="pass"></label>
                <button type="submit">belépés</button>
            </form>
<?php
        }
    else
        {
            //üzenet
            echo "<h1>Belépve, " . $_SESSION["user"] . "</h1>";
            echo '<a href="belepo.php">katt ide!</a>';
            echo '
            <form method="post" action="belepo.php">
                <button type="submit" name="kilepes">Kilépés</button>
            </form>';
        }
    ?>
</body>
</html>