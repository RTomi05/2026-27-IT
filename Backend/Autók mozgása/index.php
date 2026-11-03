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
	<title>Document</title>
</head>
<body>
	<div class="container">
		<header class="row">
			<h1>2024. október - Autók mozgása</h1>
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
					</ul>
				</div>
			</nav>
		<main class="row">
			<h2>'.$cim.'</h2>
			<p>'.$leiras.'</p>
			<article>'.$megoldas.'</article>
		</main>
		<footer class="row">
			<h4>Rengel &copy; Tomi </h4>
		</footer>
	</div>
</body>
</html>';
}

function router()
{
	switch($_GET["menu"] ?? 0)
	{
		case 2:
		default:
			$cim = "2. feladat";
			$leiras = "Állapítsa meg, hogy milyen időpontban történt a legutolsó jeladás, és írja a képernyőre az időpontot, valamint az utoljára jelet adó autó rendszámát!";
			$megoldas = feladat2();		
			break;
		case 3:
			$cim = "3. feladat";
			$leiras = "Írja ki a bemeneti állományban elsőként szereplő jármű rendszámát, valamint azt, hogy milyen időpontokban adott jelzést! Az időpontokat óra:perc formátumban, szóközzel elválasztva, egy sorban jelenítse meg!";
			$megoldas = feladat3();		
			break;
		case 4:
			$cim = "4. feladat";
			$leiras = "Kérje be a felhasználótól egy időpont óra és perc értékét, és adja meg, hogy hány jeladás történt az adott időpontban! Ha nem történt jeladás, akkor 0-t írjon ki!";
			$megoldas = feladat4();
			break;
		case 5:
			$cim = "5. feladat";
			$leiras = "Állapítsa meg, hogy mennyi az adatok szerint a legnagyobb sebesség, amellyel egy jármű a jeladáskor haladt, illetve adja meg az összes autó rendszámát, ami haladt ilyen sebességgel! Amennyiben egy jármű többször is haladt a legnagyobb sebességgel, akkor a rendszámát többször is megjelenítheti. A rendszámokat egy sorban, szóközzel elválasztva jelenítse meg a minta szerint! ";
			$megoldas = feladat5();
			break;
		case 6:
			$cim = "6. feladat";
			$leiras = "Kérje be a felhasználótól egy jármű rendszámát, és jelenítse meg a jármű jeladásainak
						időpontját és az adott rendszámú autó távolságát az útszakasz kezdetétől! A bevezető
						példában az első jármű esetén a 6:04-kor a jármű távolsága az útszakasz kezdetétől 0,0 km,
						míg 6:14-kor 15,8 km, mivel a jármű az eltelt 10 perc (10/60 óra) alatt 95 km/h-val haladt.
						A kimenetet a mintának megfelelőn alakítsa ki, a távolságot minden esetben egy
						tizedesjegyre kerekítve írja ki km mértékegységben! Ha nem szerepel a bekért rendszámmal
						jármű, akkor azt egy rövid mondatban jelezze a felhasználónak! ";
			$megoldas = feladat6();
			break;
	}
	return layout($cim, $leiras, $megoldas);
}

class Auto
{
	public $rendszam;
	public $ora;
	public $perc;
	public $sebesseg;
	public $idoString;

	function __construct($sor)
	{
		$vag = explode("\t",$sor);
		$this->rendszam = $vag[0];
		$this->ora = intval($vag[1]);
		$this->perc = intval($vag[2]);
		$this->sebesseg = intval($vag[3]);
		$this->idoString = $this->ora . ':' . $this->perc;
	}
}
function betolt()
{
	$sorok = file("jeladas.txt");
	$adatok = [];
	foreach($sorok as $sor)
		{
			$adatok[] = new Auto($sor);
		}
	return $adatok;
}

function feladat2()
{
	global $adatok;
	$utolsoAuto = "Az utolsó jeladás időpontja " . $adatok[sizeof($adatok)-1]->idoString . ", a jármű rendszáma " . $adatok[sizeof($adatok)-1]->rendszam . ".";
	return $utolsoAuto;
}

function feladat3()
{
	global $adatok;
	$idopontok = [];
	$elsoRendszam = $adatok[0]->rendszam;
	for($i = 0; $i < sizeof($adatok);$i++)
		{
			if($adatok[$i]->rendszam === $elsoRendszam)
				{
					$idopontok[] = $adatok[$i]->idoString;
				}
		}

	$megoldas = "Az első jármű: " . $elsoRendszam . "<br>";
	$megoldas .= "Jeladásainak időpontjai:<ul><li>" . implode("</li><li>", $idopontok) . "</li></ul>";
	return $megoldas;
}

function feladat4()
{
	global $adatok;
	$megoldasForm = '
	<form action="?menu=4" method="POST">
		<label for="ora" class="label">Kérem, adja meg az órát:</label>
		<input type="number" name="ora" id="ora" class="form-control">
		<label for="perc" class="label">Kérem, adja meg a percet:</label>
		<input type="number" name="perc" id="perc" class="form-control">
		<button type="submit" class="btn btn-primary p-2 m-2">Küldés</button>
	</form>';
	$megoldas = $megoldasForm;
	if(isset($_POST["ora"]))
		{
			$ora = intval($_POST["ora"]) ?? -1;
			$perc = intval($_POST["perc"]) ?? -1;
			$darabSzam = 0;
			foreach($adatok as $egyAdat)
				{
					if($ora == $egyAdat->ora && $perc == $egyAdat->perc)
						{
							$darabSzam++;
						}
				}
		}
	$megoldas .= "<p><b>Jeladások száma:</b> " . $darabSzam . "</p>";
	return $megoldas;
}

function feladat5()
{
	global $adatok;
	$maxSebesseg = -1;
	foreach($adatok as $egyAdat)
		{
			if($egyAdat->sebesseg > $maxSebesseg)
				{
					$maxSebesseg = $egyAdat->sebesseg;
				}
		}
	
	$megoldas = '<p>A legnagyobb sebesség km/h: ' . $maxSebesseg . '</p>';

	$rendszamok = [];
	for($i = 0; $i < sizeof($adatok);$i++)
		{
			if($adatok[$i]->sebesseg === $maxSebesseg)
				{
					$rendszamok[] = $adatok[$i]->rendszam;
				}
		}
	$megoldas .= "A járművek:<ul><li>" . implode("</li><li>", $rendszamok) . "</li></ul>";

	return $megoldas;
}

function feladat6()
{
	global $adatok;
	$megoldasForm = '
	<form action="?menu=6" method="POST">
		<label for="rendszam" class="label">Kérem, adja meg a rendszámot:</label>
		<input type="text" name="rendszam" id="rendszam" class="form-control">
		<button type="submit" class="btn btn-primary p-2 m-2">Küldés</button>
	</form>';
	$megoldas = $megoldasForm;
	if(isset($_POST["ora"]))
		{
			$ora = intval($_POST["ora"]) ?? -1;
			$perc = intval($_POST["perc"]) ?? -1;
			$darabSzam = 0;
			foreach($adatok as $egyAdat)
				{
					if($ora == $egyAdat->ora && $perc == $egyAdat->perc)
						{
							$darabSzam++;
						}
				}
		}
	$megoldas .= "<p><b>Jeladások száma:</b> " . $darabSzam . "</p>";
	return $megoldas;
}
?>

