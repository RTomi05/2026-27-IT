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
        include("include/form.php");
        include("include/tablazat.php");
        $szamok = szamokBetolt(false);
        $mainContent = tablazat($szamok);
        break;
    case 3:
        include("include/form.php");
        include("include/tablazat.php");
        $szamok = szamokBetolt(false);
        $mainContent = tablazat($szamok, true);
        break;
}
?>