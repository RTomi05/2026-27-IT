<?php
    switch($_GET["menu"] ?? 0)
    {
        default:
        case 1:
            include("include/fooldal.php");
            $mainContent = fooldal();
            break;
        case 2:
            include("include/tartalmiOldal.php");
            $mainContent = tartalmiOldal();
            break;
        case 3:
            include("include/form.php");
            $mainContent = form();
            feldolgoz();
            break;

    }
?>