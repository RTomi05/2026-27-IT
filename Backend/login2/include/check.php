<?php
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
?>