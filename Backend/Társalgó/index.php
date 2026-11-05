<?php

$adatok = betolt();
//var_dump($adatok);
echo router();
function layout($cim, $leiras, $megoldas)
{
	return '<!DOCTYPE html>
<html lang="hu">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<title>Társalgó</title>
</head>
<body>
	<div class="container">
		<header class="row">
			<h1 class="col-12">2018. május 14. - Társalgó</h1>
		</header>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
					<li class="nav-item active">
						<a class="nav-link" href="?menu=2">2. feladat</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="?menu=3">3. feladat</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="?menu=4">4. feladat</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="?menu=5">5. feladat</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="?menu=6">6. feladat</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="?menu=7">7. feladat</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="?menu=8">8. feladat</a>
					</li>
					</ul>
				</div>
			</nav>
		<main class="row">
			<h2 class="text-center">'.$cim.'</h2>
			<p>'.$leiras.'</p>
			<article>'.$megoldas.'</article>
		</main>
		<footer class="row">
			<h4>2026. 11. 04 - &copy; Tomi </h4>
		</footer>
	</div>
</body>
</html>';
}

function router()
{
	switch ($_GET["menu"] ?? 0)
	{
		case 2:
		default:
		$cim = "2. feladat";
		$leiras = "Írd a képernyőre annak a személynek az azonosítóját, aki a vizsgált időszakon belül először lépett be az ajtón, és azét, aki utoljára távozott a megfigyelési időszakban!";
		$megoldas = feladat2();
		break;

		case 3:
		$cim = "3. feladat";
		$leiras = "Határozd meg a fájlban szereplő személyek közül, ki hányszor haladt át a társalgó ajtaján! A meghatározott értékeket azonosító szerint növekvő sorrendben írd az athaladas.txt fájlba! Soronként egy személy azonosítója, és tőle egy szóközzel elválasztva az áthaladások száma szerepeljen!";
		$megoldas = feladat3();
		break;

		case 4:
		$cim = "4. feladat";
		$leiras = " Írd a képernyőre azon személyek azonosítóját, akik a vizsgált időszak végén a társalgóban tartózkodtak!";
		$megoldas = feladat4();
		break;

		case 5:
		$cim = "5. feladat";
		$leiras = "Hányan voltak legtöbben egyszerre a társalgóban? Írj a képernyőre egy olyan időpontot (óra:perc), amikor a legtöbben voltak bent! ";
		$megoldas = feladat5();
		break;

		case 6:
		$cim = "6. feladat";
		$leiras = "Kérd be a felhasználótól egy személy azonosítóját! A további feladatok megoldásánál ezt használd fel! Feltételezheted, hogy a megadott azonosítóhoz tartozik adat a forrásfájlban.";
		$megoldas = feladat6();
		break;

		case 7:
		$cim = "7. feladat";
		$leiras = "Írd a képernyőre, hogy a beolvasott azonosítóhoz tartozó személy mettől meddig tartózkodott a társalgóban! ";
		$megoldas = feladat7();
		break;

		case 8:
		$cim = "8. feladat";
		$leiras = "Határozd meg, hogy a megfigyelt időszakban a beolvasott azonosítójú személy összesen hány percet töltött a társalgóban! Az előző feladatban példaként szereplő 22-es személy 5 alkalommal járt bent, a megfigyelés végén még bent volt. Róla azt tudjuk, hogy 18 percet töltött bent a megfigyelés végéig. A 39-es személy 6 alkalommal járt bent, a vizsgált időszak végén nem tartózkodott a helyiségben. Róla azt tudjuk, hogy 39 percet töltött ott. Írd ki, hogy a beolvasott azonosítójú személy mennyi időt volt a társalgóban, és a megfigyelési időszak végén bent volt-e még! ";
		$megoldas = feladat8();
		break;
	}

	return layout($cim, $leiras, $megoldas);
}

class Adatok
{
	public $ora;
	public $perc;
	public $id;
	public $irany;

	function __construct($sor)
	{
		$vag = explode(" ",$sor);
		$this->ora = intval($vag[0]);
		$this->perc = intval($vag[1]);
		$this->id = intval($vag[2]);
		$this->irany = trim($vag[3]);
	}
}

function betolt()
{
	$sorok = file("ajto.txt");
	$adatok = [];
	foreach($sorok as $sor)
		{
			$adatok[] = New Adatok($sor);
		}
	return $adatok;
}

function feladat2()
{
	global $adatok;
	$utolsoKi;
	for($i = 0; $i < sizeof($adatok); $i++)
		{
			if($adatok[$i]->irany === "ki")
				{
					$utolsoKi = $adatok[$i]->id;
				}
		}
	$elsoEsUtolso = "Az első belépő: <b>". $adatok[0]->id."</b> <br> Az utolsó kilépő: <b>".$utolsoKi."</b>";
	return $elsoEsUtolso;
}

function feladat3()
{
	global $adatok;
	$athaladasok = [];
	foreach ($adatok as $adat) {
		if (!isset($athaladasok[$adat->id])) {
			$athaladasok[$adat->id] = 0;
		}
		$athaladasok[$adat->id]++;
	}
	ksort($athaladasok);

	$file = fopen("athaladas.txt", "w");
	foreach ($athaladasok as $id => $db) {
		fwrite($file, $id . " " . $db . "\n");
	}
	fclose($file);

	return "Az adatok kiírva: <b>athaladas.txt</b>";
}

function feladat4()
{
	global $adatok;
	$bentVan = [];

	foreach ($adatok as $adat) {
		if ($adat->irany === "be") {
			$bentVan[$adat->id] = true;
		} else {
			$bentVan[$adat->id] = false;
		}
	}

	ksort($bentVan);

	$eredmeny = "";
	foreach ($bentVan as $id => $amigBentVan) {
		if ($amigBentVan === true) {
			$eredmeny .= $id . " ";
		}
	}

	return "A végén a társalgóban voltak: " . $eredmeny;
}

function feladat5()
{
	global $adatok;

	$aktualisLetszam = 0;
	$maxLetszam = 0;
	$maxOra = 0;
	$maxPerc = 0;

	foreach ($adatok as $adat) {
		if ($adat->irany === "be") {
			$aktualisLetszam++;
		} else {
			$aktualisLetszam--;
		}

		if ($aktualisLetszam > $maxLetszam) {
			$maxLetszam = $aktualisLetszam;
			$maxOra = $adat->ora;
			$maxPerc = $adat->perc;
		}
	}

	return "Például ".$maxOra.":".$maxPerc."-kor voltak a legtöbben a társalgóban.";
}

function feladat6()
{
	$szemelyId = $_POST['id'] ?? ' ';

	$eredmeny = '
	<form action="?menu=6" method="POST" class="mb-3">
		<div class="row">
			<div class="col-12">
				<label for="id" class="col-form-label">Adja meg a személy azonosítóját:</label>
			</div>
			<div class="col-2">
				<input type="number" id="id" name="id" class="form-control" value="' . $szemelyId . '" required>
			</div>
			<div class="col-auto">
				<button type="submit" class="btn btn-primary">küldés</button>
			</div>
		</div>
	</form>';

	if ($szemelyId !== '') {
		$eredmeny .= "<div class='alert alert-success'>A beolvasott azonosító: <b>$szemelyId</b></div>";
	}

	return $eredmeny;
}

function feladat7()
{
	global $adatok;
	$szemelyId = $_POST['id'] ?? 22;

	$eredmeny = "";

	foreach ($adatok as $adat) {
		if ($adat->id == $szemelyId) {
			
			$perc = $adat->perc < 10 ? "0" . $adat->perc : $adat->perc;
			$ido = $adat->ora . ":" . $perc;

			if ($adat->irany === "be") {
				$eredmeny .= $ido . "-";
			} 

			else {
				$eredmeny .= $ido . "<br>";
			}
		}
	}

	return $eredmeny;
}

function feladat8()
{

}
?>