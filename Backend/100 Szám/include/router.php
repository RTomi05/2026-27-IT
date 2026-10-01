<?php
//útvonalválasztás

switch($_GET["menu"] ?? 0)
{
    case 1:
    default:
        include("include/form.php");
        
        feldolgozas();
        $szamok = szamokBetolt();
        $mainContent = form($szamok);
        break;
    case 2:
        include("include/tablazat.php");
        break;
    case 3:
        include("include/layout.php");
        break;
}
?>