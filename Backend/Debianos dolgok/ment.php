<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <label for="nev">Név</label>
        <input type="text" name="nev" id="nev" required>
        <label for="telefon">Telefon</label>
        <input type="text" name="telefon" id="telefon" required>
        <input type="submit" name="kuldes" id="kuldes">
    </form>

    <?php

        $nev = $_POST['nev'];
        $telefonszam = $_POST['telefon'];
        $sor = $nev . ',' . $telefonszam . PHP_EOL;
        file_put_contents('telefonkonyv.txt', $sor, FILE_APPEND);
        echo "Sikeres rögzítés! <a href='ment.php'>Vissza</a>";
/*
    $nev = $_POST["nev"];
    $telefonszam = $_POST["telefonszam"];
    $adatok = json_decode(file_get_contents("telefonszamok.json"), true);
    $adatok[] = ["nev" => $nev, "telefonszam" => $telefonszam];

    file_put_contents("telefonszamok.json", json_encode($adatok));
    echo "Mentve!";
    */
/*
    if (isset($_POST['nev'], $_POST['telefon'])) {
        $nev = trim($_POST['nev']);
        $telefon = trim($_POST['telefon']);
        $adatok[] = $nev . " " . $telefon;
        file_put_contents("telefonszamok.json", json_encode($adatok), FILE_APPEND);
        echo $nev . " " . $telefon;
    }
        */
    ?>
</body>
</html>