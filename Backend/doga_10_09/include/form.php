<?php
function form()
{
    $szoveg = "";
    $szoveg .= '<h1 class="m-5 text-center">Űrlap</h1>
    <form action="' . uri(3) .'" method="POST">
                <label for="nev">Adja meg a nevet: </label>
                <input type="text" name="nev" id="nev" class="form-control">
                <label for="uzenet">Írjon be egy üzenetet: </label>
                <textarea name="uzenet" id="uzenet" class="form-control" rows="5" cols="50"></textarea>
                <button type="submit" class="btn btn-info" name="kuldes" style="margin: 20px;">Küldés</button>
                </form>';
    return $szoveg;
}

function feldolgoz()
{
    if(isset($_POST["kuldes"]))
        {
            //echo "jó";
            $fajl = fopen("fajl.txt","a");
            fwrite($fajl, "\nNév: " . $_POST["nev"] . "\n" . "Üzenet: " . $_POST["uzenet"] . "\n\n-------------------------");
            fclose($fajl);
        }
}
?>