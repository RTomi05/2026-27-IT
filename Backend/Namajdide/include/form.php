<?php
    function form()
    {
        $szoveg = "";
        $szoveg .= "<form action=\"" . uri(3) . "\" method=\"post\">";
        $szoveg .= '<div class="row">';
        $szoveg .= '<div class="col-1"></div>';
        //continue;
        $szoveg .= '<div class="col-12 text-center">
                        <h4>Név: </h4>
                        <input type="text" name="nev" class="form-control mb-4">
                        <h4>E-mail cím: </h4>
                        <input type="text" name="email" class="form-control mb-4">
                        <h4>Üzenet: </h4>
                        <input type="textarea" name="uzenet" class="form-control mb-4">
                    </div>';
        $szoveg .= '</div>';
        $szoveg .= '<div class="row"><button type="submit" name="elkuld" class="btn btn-primary p-3 mt-4">Elküld</button></div>';
        $szoveg .= '</form>';
        return $szoveg;
    }
    /*
    Fájlba menti a POST-ban érkező adatokat
    */
    function feldolgozas()
    {
        if(isset($_POST["elkuld"]))
            {
                $f = fopen("uzenetek.txt","w");
                fwrite($f, "Név: " . $_POST["nev"] . "\tE-mail: " . $_POST["email"] . "\tÜzenet: " . $_POST["uzenet"]);
                fclose($f);

                header("location:" . uri(3));
                die();
                //phpinfo(32);
            }
    }
?>