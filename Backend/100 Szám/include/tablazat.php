<?php
    /*
        10*10-es bootstrap táblázat
    */
    function tablazat($szamok, $rendezett=false)
    {
        if(!$szamok)
            {
                $szoveg="<h2>Nincsenek számok!</h2>";
                return $szoveg;
            }
        $cim = "Számok megjelenítése";
        $gombSor="";
        if($rendezett)
            {
                $cim = "Számok rendezett megjelenítése";
                sort($szamok);
                
                $gombSor .= "<tr>";
                $gombSor .= "<th>";
                for($cella = 0; $cella < 10; $cella++)
                    {
                        $gombSor .= '<th><button type="submit" name="oszlop_' . $cella . '">Rendez</button></th>';
                    }
                $gombSor.="</th>";
                $gombSor.="</tr>";
            }
        $szoveg="";
        $szoveg.='<table class="table table-striped table-hover">';
        $szoveg.='<thead class=""><th colspan="10" class="display-6 text-info text-center">' 
                    . $cim .
                    '</th><tr>' . 
                    $gombSor . 
                    '</thead>';
        $szoveg.="<tbody>";
        for($sor = 0; $sor < 10; $sor++)
            {
                $szoveg.='<tr class="">';
                if($rendezett)
                    {
                        $szoveg .= '<th><button type="submit">Rendez</button></th>';
                        $gombSor .= '<th><button type="submit" name="oszlop_' . $sor . '">Rendez</button></th>';
                    }
                for($cella = 0; $cella < 10; $cella++)
                    {
                        $szoveg.='<td class="">';
                        $szoveg.=$szamok[$sor*10 + $cella];
                        $szoveg.='</td>';
                    }
                
                $szoveg.='</tr>';
            }
        $szoveg.="</tbody>";
        $szoveg.='</table>';
        return $szoveg;
    }
?>