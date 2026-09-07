<?php
    echo "<h1>Hello World!</h1>";
    echo "valami "; echo "valami 
    " . "más"." csak így
    ";

    echo 'Zebra';
    $alma = "Jonathan";
    $Alma = "Idared";
    $korte = "Vilmos";

    echo $korte . " " . $alma . "<br>";

    $korte = 3;
    $alma = false;
    echo $korte . " " . $alma . "<br>";

    var_dump($korte);
    var_dump($Alma);

    $tomb = [];
    $tomb[] = 12;
    $tomb[] = 12;
    $tomb[] = 120;
    $tomb[100] = 120;
    $tomb[] = "12";
    $tomb["szöveg"] = "almafa";

    //asszociatív tömb
    $tomb["géza"] = "Kresz";
    $tomb["géza"] = ["Kresz","Mézga","BK"=>"kertész"];


    echo "<pre>";
    var_dump($tomb);
    echo "</pre>";

    echo $tomb[0] . "<br";
    echo $tomb["géza"][0] . "<br>";
    echo $tomb["géza"]["BK"] . "<br>";

    echo "Kedvenc Géza: " .$tomb["géza"][1] . "<br>";
    echo 'Kedvenc gyümölcs: $Alma' . "<br>";

    //ciklusok

    for($i = 0; $i < 10; $i++)
        {
            echo "$i<br>";
        }

    $i = 0;
    while($i < 5)
        {
            $i++;
            echo "$i";
        }

    do
    {
        $i--;
        echo "$i<br>";
    }
    while ($i > 0);

    foreach ($tomb as $value)
        {
            if(gettype($value)!="array")
                {
                    echo $value . " <br>";
                }
        }


    /*
    $z = rand(3,6);
    echo $z;*/

    

?>