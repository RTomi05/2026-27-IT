<?php
include_once("include/functions.php");

//echo "hi";
function feladat2()
{
    $adatok = adatBetolt();
}
//var_dump($adatok);

function urlap()
{
    <form action="index.php?menu=2" method="POST">
    <div class="row">
        <div class="col-5"><label class="label" for="sorszam">Adja meg a jármű sorszámát:</label></div>
        <div class="col-4"><input type="number" name="sorsza0m" id="sorszam" class="form-control"></div>
        <div class="col-3"><button type="submit" class="btn btn-primary">Küldés</button></div>
    </div>
    </form>

    return 
}
?>