<?php
function urlap()
{
    return '<form action="' . uri(3) . '" method="post">
                <label for="">Név:</label>
                <input type="text" class="form-control" name="nev" id="nev">
                <label for="">Üzenet:</label>
                <textarea class="form-control" name="uzenet" id="uzenet" cols="50" rows="4"></textarea>
                <button type="submit" class="btn btn-primary m-2" name="submit">Mentés</button>
                </form>';
}

function feldolgozas()
{
    if(isset($_POST["submit"]))
        {
            file_put_contents("save.txt", $_POST["nev"].';'.$_POST["szoveg"]. PHP_EOL, FILE_APPEND);
        }
        header("location:" . uri(3));
        exit;
}
?>