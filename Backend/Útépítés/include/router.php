<?php
    switch($_GET["menu"] ?? 0)
{
    case 2:
    default:
        $oldalCim = "Feladat 2";
        include("include/feladat2.php");
        $mainContent = feladat2();
        break;
    case 3:
        $oldalCim = "";
        break;
}
?>