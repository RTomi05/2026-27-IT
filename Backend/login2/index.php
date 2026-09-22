<?php
//include fájlokra bontás
    session_start();
    $login = false;
    $url = "index.php";

    /*
    include - betöltés
    include_once - egyszer tölti be
    */

    //include("include/check.php");
    include("./include/check.php");

    //ellenőrzés


    if(!isset($_SESSION["belepve"]) || !$_SESSION["belepve"])
        {
            //űrlap
            include("./include/loginForm.php");
        }
    else
        {
            //üzenet
            include("./include/content.php");
        }
    ?>
</body>
</html>