<?php
    $file = file("forgalom.txt");
    for($i = 0;$i < sizeof($file);$i++)
        {
            echo $file[$i] . "<br>";
        }

    //var_dump($file);
?>