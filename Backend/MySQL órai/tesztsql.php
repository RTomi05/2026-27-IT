<!DOCTYPE html>
<html lang="hu">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Teszt SQL</title>
</head>
<body>
	<form action="tesztsql.php" method="post">
		<label for="adat">Írj be valamit</label>
		<input type="text" name="adat" id="adat">
		<input type="submit" name="kuldes" id="kuldes">
	</form>

<?php
	$conn = new mysqli("localhost", "root", "", "proba2026");
if(isset($_POST["adat"]))
	{
		//eltárolás
		$sql = "INSERT INTO probaadat (szoveg) VALUES ('".$_POST["adat"]."')";
		$conn -> query($sql) or die($conn -> error);
	}

	//adatok kigyűjtése
	$adatok = [];

	//itt lesz az SQL

	foreach($adatok as $adat)
		{
			
		}

	$conn -> close();
?>
</body>
</html>

<?php

?>