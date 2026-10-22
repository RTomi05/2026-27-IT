<?php
include_once("include/functions.php");

//echo "hi";
function feladat2()
{
	$content = urlap();
	if(isset($_POST["sorszamBekuld"]))
		{
			$adatok = adatBetolt();
			$content .= autoKeres($adatok);
		}
	return $content;
}
//var_dump($adatok);

function urlap()
{
    return '<form action="index.php?menu=2" method="POST">
    <div class="row">
        <div class="col-5"><label class="label" for="sorszam">Adja meg a jármű sorszámát:</label></div>
        <div class="col-4"><input type="number" name="sorszam" id="sorszam" class="form-control"></div>
        <div class="col-3"><button type="submit" name="sorszamBekuld" class="btn btn-primary">Küldés</button></div>
    </div>
    </form>';
}

function autoKeres($adatok)
{
	$sorszam = intval($_POST["sorszam"] ?? 1);
	if($sorszam < 0 || $sorszam > sizeof($adatok))
		{
			return '<div class="row">
				<div>Nincs ilyen számú jármű!</div>
			</div>';
		}
	$keresettAuto = $adatok[$sorszam-1];
	return '<div class="row">
		<div>A <b>' . $sorszam. '</b>. számú autó <b>'.$keresettAuto->varos.'</b> felé haladt.</div>
	</div>';
	
}
?>