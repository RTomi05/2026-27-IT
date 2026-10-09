<?php
function uri($menu)
{
    return htmlspecialchars($_SERVER['PHP_SELF'])."?menu=".$menu;
}
?>