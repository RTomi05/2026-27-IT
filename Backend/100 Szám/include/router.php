<?php
//útvonalválasztás

switch($_GET["menu"])
{
    case 1:
    default:
        include("include/form.php");
        $mainContent = form(szamGeneral());
        break;
    case 2:
        include("include/tablazat.php");
        break;
    case 3:
        include("include/layout.php");
        break;
}
?>