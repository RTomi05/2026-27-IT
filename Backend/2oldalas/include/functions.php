<?php
//a menüpont url-je
    function uri($menuSzam)
    {
        return htmlspecialchars($_SERVER["PHP_SELF"]) . "?menu=" . $menuSzam;
    }
?>