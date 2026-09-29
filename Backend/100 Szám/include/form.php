<?php
    function form($szamok)
    {
        $szoveg = "";
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
        return $szoveg;
    }


    function szamGeneral()
    {
        $szamok = [];
        for($i = 0; $i < 101; $i++)
            {
                $szamok[] = rand(0,1001);
            }  
    return $szamok;
    }
?>