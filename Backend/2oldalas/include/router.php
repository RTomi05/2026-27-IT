<?php
//útvonalválasztás

switch($_GET["menu"] ?? 0)
{
    case 1:
    default:
        $mainContent = bekeres();
        break;
    case 2:
        $mainContent = abrazol();
        break;
}
?>