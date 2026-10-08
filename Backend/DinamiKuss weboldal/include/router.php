<?php

switch($_GET["menu"] ?? 0)
{
    case 1:
    default:
        include("include/fooldal.php");
        $mainContent = fooldal();
        break;
    case 2:
        break;
    case 3:
        include("include/form.php");
        $mainContent = urlap();
        feldolgozas();
        break;
    case 4:
        break;
}

?>