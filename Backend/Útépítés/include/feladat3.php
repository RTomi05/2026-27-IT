<?php
include_once("include/functions.php");

	function feladat3()
	{
		$adatok = adatBetolt();

		$felsoVarosFeleTartok = [];

		for($i = 0; $i < sizeof($adatok); $i++)
			{
				if($adatok[$i]->varos == "A")
					{
						$felsoVarosFeleTartok[] = $adatok[$i];
					}
			}

		$utolso = $felsoVarosFeleTartok[sizeof($felsoVarosFeleTartok)-1];
		$utolsoElotti = $felsoVarosFeleTartok[sizeof($felsoVarosFeleTartok)-2];
		$utolsoIdo = mktime($utolso->ora, $utolso->perc, $utolso->masodperc);
		$utolsoElottiIdo = mktime($utolsoElotti->ora, $utolsoElotti->perc, $utolsoElotti->masodperc);

		return '<div class="row">
		<div>Az utolsó két F irányba tartó autó közötti távolság között eltelt idő: <b>' . ($utolsoIdo - $utolsoElottiIdo) . ' másodperc volt.</b></div>
	</div>';
	}
?>