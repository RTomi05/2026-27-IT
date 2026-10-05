<?php
//útvonalválasztás

switch($_GET["menu"] ?? 0)
{
    case 1:
    default:
        $mainContent = fooldal();
        break;
    case 2:
        $mainContent = aloldal();
        break;
    case 3:
        $mainContent = form();
        feldolgozas();
        break;
}
?>