<?php
//include függvények
    session_start();
    $login = false;
    $url = "index.php";

    /*
    include - betöltés
    include_once - egyszer tölti be
    */

    //include("include/check.php");
    include("./include/check.php");
    include("./include/loginForm.php");
    include("./include/content.php");

    //ellenőrzés

    check();
    if(!isset($_SESSION["belepve"]) || !$_SESSION["belepve"])
        {
            //űrlap
            loginForm();
        }
    else
        {
            content();
            //üzenet
        }
    ?>
</body>
</html>