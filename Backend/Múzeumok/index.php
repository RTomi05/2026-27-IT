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
	<title>Múzeumok</title>
</head>
<body>
	<div class="container">
		<header class="row">
			<h1>Múzeumok - 2026. október 20.</h1>
		</header>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarText">
				<ul class="navbar-nav mr-auto">
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
					<a class="nav-link" href="?menu=9">9. feladat</a>
				</li>
				</ul>
			</div>
		</nav>
		<main class="row">
			<h2>'.$cim.'</h2>
			<p>'.$leiras.'</p>
			<article>'.$megoldas.'</article>
		</main>
		<footer class="row">
			<h5>Rengel Tomi &copy; 2026. 11. 09.</h5></footer>
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
			$leiras = "Fontos adat, hogy hány látogató volt a városi múzeumokban az adott napon összesen. Írassa ki az eredményt a mintához hasonlóan a képernyőre! Ha valaki napijegyet vett, akkor őt annyiszor vegye figyelembe, ahány múzeumba ténylegesen be is lépett!";
			$megoldas = feladat2();
			break;

		case 3:
			$cim = "3. feladat";
			$leiras = "Határozza meg, hogy mikor és melyik kiállításra lépett be az első és az utolsó látogató! Jelenítse meg a képernyőn a két időpontot és múzeumnevet a mintához hasonlóan! ";
			$megoldas = feladat3();
			break;

		case 4:
			$cim = "4. feladat";
			$leiras = "Kérje be egy jegy sorszámát, majd írassa ki a képernyőre, hogy az illető a nap folyamán mikor, melyik múzeumba lépett be! Ha nincs ilyen sorszámú jegy, ne jelenjen meg semmi! ";
			$megoldas = feladat4();
			break;

		case 5:
			$cim = "5. feladat";
			$leiras = "Az igazgatóság szeretné zárás előtt 30 perccel megszüntetni a jegyek eladását. Jogos-e ez a döntés? Határozza meg, hogy mennyi idő telt el az utolsó jegy megvásárlása és a zárás között! A választ óra:perc formátumban írassa ki a képernyőre! A vezető nullákat nem kell megjelenítenie. Tudjuk, hogy valamennyi múzeum pontosan 18:00-kor zár.";
			$megoldas = feladat5();
			break;

		case 6:
			$cim = "6. feladat";
			$leiras = "Mennyi volt a múzeum teljes bevétele az adott napon? A bevételt a mintának megfelelően írassa ki a képernyőre!";
			$megoldas = feladat6();
			break;

		case 7:
			$cim = "7. feladat";
			$leiras = "Igaz-e, hogy a napijegyet váltók általában a Kastélyban kezdenek? Adjon teljes mondatban pozitív választ, ha aznap a napijegyet váltók több mint a fele a Kastélyban kezdett, egyébként adjon negatív választ! Például „A napijegyet váltók általában nem a Kastélyban kezdtek.";
			$megoldas = feladat7();
			break;

		case 9:
			$cim = "9. feladat";
			$leiras = "Sajnos a napijegyet vásárlóknak csak egy része tekinti meg az összes kiállítást. Nekik a múzeum igazgatósága egy ajándéktárggyal külön is kedveskedni szeretne, melyet az utolsó kiállításra való belépéskor adnának át. Írassa ki a képernyőre a mintának megfelelő elrendezésben oszlopokra tagolva, hogy az érintett látogatók milyen sorszámú jeggyel, melyik múzeumban és mikor vehetnék át az ajándékot!";
			$megoldas = feladat9();
			break;

		
	}
	return layout($cim, $leiras, $megoldas);
}

class Adatok
{
	public $ido;
	public $jegyid;
	public $helyid;
	public $tipus;

	function __construct($sor)
	{
		$vag = explode(" ",$sor);
		$this->ido = $vag[0];
		$this->jegyid = $vag[1];
		$this->helyid = intval($vag[2]);
		$this->tipus = trim($vag[3]);
	}
}

function betolt()
{
	$sorok = file("muzdat.txt");
	$adatok = [];
	$arak = array_shift($sorok);
	foreach ($sorok as $sor)
		{
			$adatok[] = new Adatok($sor);
		}
	return $adatok;
}
function feladat2()
{
	global $adatok;
	return "Az adott napon összesen <b>".sizeof($adatok)."</b> látogató volt. ";
}

function feladat3()
{
	global $adatok;
	foreach($adatok as $sor)
		{
			if($sor->helyid == "0")
				{
					$sor->helyid = "Kastély";
				}

			if($sor->helyid == "1")
				{
					$sor->helyid = "Fegyvertár";
				}

			if($sor->helyid == "2")
				{
					$sor->helyid = "Agrárgép Kiállítás";
				}

			if($sor->helyid == "3")
				{
					$sor->helyid = "Vadászmúzeum";
				}

			if($sor->helyid == "4")
				{
					$sor->helyid = "Helytörténeti Gyűjtemény";
				}

			if($sor->helyid == "5")
				{
					$sor->helyid = "Népművészeti Kiállítás";
				}
		}
	return "Az első látogató <b>".$adatok[0]->ido."</b>-kor lépett a(z) <b>" .$adatok[0]->helyid . "</b> helyszínre.<br>
	Az utolsó látogató <b>".$adatok[sizeof($adatok)-1]->ido."</b>-kor lépett a(z) <b>".$adatok[sizeof($adatok)-1]->helyid."</b> helyszínre.";
}

function feladat4()
{
	global $adatok;
	$db = 0;
	$sorszam = $_POST["sorszam"];
	$content = '<form action="index.php?menu=4" method="POST">
				<label for="sorszam" class="label">Add meg a jegy sorszámát!</label>
				<input type="text" name="sorszam" id="sorszam" class="form-control">
				<button type="submit" class="btn btn-primary m-3">Küldés</button>
			</form>';

	foreach($adatok as $sor)
		{
			if($sorszam == $sor->jegyid)
				{
					$db++;
				}
		}
	return $db . $content;
}

function feladat5()
{
	$idoKulonbseg = "";
	return 'Az utolsó jegyvásárló '.$idoKulonbseg.' perccel a zárás előtt vett jegyet. ';
}

function feladat6()
{
	// teljes árú helyijegy (T) - 1.000 Ft.,
	// teljes árú helyijegy (T) a Kastélyba 6.000 Ft,
	// kedvezményes árú helyijegy a Kastélyba (K) - 3.000 Ft,
	// kedvezményes árú helyijegy (K) - 500 Ft,
	// teljes árú napijegy (TN) 8.000 Ft.
	// kedvezményes árú napijegy (KN) - 4.000 Ft.
	global $adatok;
	//echo $adatok[0]->tipus;
	$bevetel = 0;
	foreach($adatok as $sor)
		{
			if($sor->helyid === 0 && $sor->tipus==="T")
				{
					$bevetel += 6000;
				}
			else if($sor->helyid !== 0 && $sor->tipus=="T")
				{
					$bevetel += 1000;
				}
			else if($sor->helyid === 0 && $sor->tipus=="K")
				{
					$bevetel += 3000;
				}
			else if($sor->helyid !== 0 && $sor->tipus==="T")
				{
					$bevetel += 1000;
				}
			else if($sor->tipus === "TN")
				{
					$bevetel += 8000;
				}
			else if($sor->tipus === "K")
				{
					$bevetel += 500;
				}
			else if($sor->tipus === "KN")
				{
					$bevetel += 4000;
				}
		}
	return "A múzeum teljes bevétele az adott napon <b>".$bevetel."</b> Ft volt.";
}

function feladat7()
{
	return 'A napijegyet váltók általában a Kastélyban kezdtek.';
}

function feladat9()
{
	return 'Majd HTML tábla';
}
?>

