<?php
include_once("include/functions.php");

function feladat4()
{
	$adatok = adatBetolt();
	$csoportositott = [];
	for($i = 0; $i < sizeof($adatok);$i++)
		{
			if(!isset($csoportositott[$adatok[$i]->ora]))
			{
				$csoportositott[$adatok[$i]->ora] = ["A"=>0,"F"=>0];
			}
			$csoportositott[$adatok[$i]->ora][$adatok[$i]->varos]++;
		}

		//var_dump($csoportositott);
		return tablaKeszit($csoportositott);
}

	function tablaKeszit($csoportositottAdatok)
	{
		$content = '<table class="table table-striped">
			<thead>
				<tr>
					<th>Óra</th>
					<th>Alsóváros</th>
					<th>Felsőváros</th>
				</tr>
			</thead>
			<tbody>';

			foreach($csoportositottAdatok as $ora => $athaladasok)
				{
					$content .= '<tr>
					<th>'.$ora.'</th>
					<td>'.$athaladasok['A'].'</td>
					<td>'.$athaladasok['F'].'</td>
				</tr>';
				}
			$content .= '</tbody>
		</table>';
		return $content;
	}
?>