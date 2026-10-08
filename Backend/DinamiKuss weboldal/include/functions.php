<?php
function uri($menuSzam)
{
    return htmlspecialchars($_SERVER['PHP_SELF'])."?menu=" . $menuSzam;
}
?>