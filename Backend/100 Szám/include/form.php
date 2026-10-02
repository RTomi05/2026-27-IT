<?php
    function form($szamok)
    {
        var_dump($szamok);
        $szoveg = "";
        $szoveg .= "<form action=\"" . uri(1) . "\" method=\"post\">";
        $szoveg .= '<div class="row">';
        for($i = 0; $i < sizeof($szamok); $i++)
            {
                if($i===0)
                    {
                         $szoveg .= '<div class="col-1"></div>';
                         //continue;
                    }

                        $szoveg .= '
                        <div class="col-1">
                        <label for="szam' . $i . '">' . ($i+1) . '</label>
                            <input type="number" value="' . $szamok[$i] . '" min="0" max="1000" name="szam' . $i . '" id="szam' . $i . '" class="form-control">
                        </div>';

                if($i%10===9)
                {
                    $szoveg .= '<div class="col-1"></div>';
                    if($i > 0 or $i < 99)
                        {
                            $szoveg .= '<div class="col-1"></div>';
                        }
                    //continue;
                }
            }
        $szoveg .= '</div>';
        $szoveg .= '<div class="row"><button type="submit" name="elkuld" class="btn btn-primary p-3 mt-4">Elküld</button></div>';
        $szoveg .= '</form>';
        return $szoveg;
    }


    function szamGeneral()
    {
        $szamok = [];
        for($i = 0; $i < 100; $i++)
            {
                $szamok[] = rand(0,1000);
            }
    return $szamok;
    }

    /*
    Fájlba menti a POST-ban érkező adatokat
    */
    function feldolgozas()
    {
        if(isset($_POST["elkuld"]))
            {
                $f = fopen("save.txt","w");
                for($i = 0; $i < 100; $i++)
                    {
                        fwrite($f,$_POST["szam$i"] . "\n");
                    }
                fclose($f);

                header("location:" . uri(1));
                die();
                //phpinfo(32);
            }
    }

    /*
    Adatok betöltése fájlból, ha létezik
    */
    function szamokBetolt($generalj=true)
    {
        if(file_exists("save.txt"))
            {
                $f = fopen("save.txt","r");
                $vissza = [];
                while(!feof($f))
                    {
                        $vissza[] = trim(fgets($f));
                    }
                fclose($f);
                array_pop($vissza);
                return $vissza;
            }
        else if($generalj)
            {
                return szamGeneral();
            }
        else
            {
                return false;
            }
    }
?>