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
        $oldalCim = "Feladat 3";
		include("include/feladat3.php");
		$mainContent = feladat3();
        break;
	case 4:
        $oldalCim = "Feladat 4";
		include("include/feladat4.php");
		$mainContent = feladat4();
        break;
	case 5:
        $oldalCim = "Feladat 5";
		include("include/feladat5.php");
		$mainContent = feladat5();
        break;
	case 6:
        $oldalCim = "Feladat 6";
		//include("include/feladat6.php");
		//$mainContent = feladat6();
        break;
}
?>