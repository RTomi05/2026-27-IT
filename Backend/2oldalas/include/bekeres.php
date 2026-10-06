<?php
function bekeres()
    {
        $szoveg = "";
        $szoveg .= "<form action=\"" . uri(2) . "\" method=\"post\">";
        $szoveg .= '<div class="row">';
        $szoveg .= '<div class="col-1"></div>';
        //continue;
        $szoveg .= '<div class="col-12 text-center">
                        <h4>Név: </h4>
                        <input type="text" name="nev" class="form-control mb-4">
                        <h4>Születési dátum: </h4>
                        <input type="date" name="datum" class="form-control mb-4">
                        <h4>Becenév: </h4>
                        <input type="text" name="becenev" class="form-control mb-4">
                    </div>';
        $szoveg .= '</div>';
        $szoveg .= '<div class="row"><button type="submit" name="elkuld" class="btn btn-primary p-3 mt-4">Elküld</button></div>';
        $szoveg .= '</form>';
        return $szoveg;
        abrazol();
    }
?>