<?php
// ============================================================================
// 1. ADATOK MENTÉSE (Ha a felhasználó rákattintott a mentés gombra)
// ============================================================================
if (isset($_POST['mentes'])) {
    $szoveg = "";
    
    // Végigmegyünk a 100 beírt mezőn, és összefűzzük őket egy szöveggé (újsorokkal elválasztva)
    for ($i = 0; $i < 100; $i++) {
        $szoveg .= $_POST["szam_$i"] . "\n";
    }
    
    // Egyetlen sorban kiírjuk az egészet a fájlba!
    file_put_contents("szamok.txt", $szoveg);
}

// ============================================================================
// 2. ADATOK BETÖLTÉSE VAGY ÚJ GENERÁLÁSA
// ============================================================================
$szamok = [];

if (file_exists("szamok.txt")) {
    // Ha létezik a fájl, beolvassuk a sorait egy tömbbe
    $szamok = file("szamok.txt", FILE_IGNORE_NEW_LINES);
} else {
    // Ha még nincs fájl, feltöltjük a tömböt 100 darab véletlen számmal
    for ($i = 0; $i < 100; $i++) {
        $szamok[] = rand(0, 1000);
    }
}

// ============================================================================
// 3. MENÜPONT KIOLVASÁSA AZ URL-BŐL (?menu=1, ?menu=2, stb.)
// ============================================================================
// Ha nincs megadva menü az URL-ben, alapértelmezetten az 1-es (űrlap) tölt be
$menu = $_GET['menu'] ?? 1;
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>100 Szám - Egyszerű kiadás</title>
</head>
<body>

    <!-- FELÜLSŐ MENÜ (Egyszerű HTML linkek) -->
    <a href="?menu=1">1. Űrlap</a> | 
    <a href="?menu=2">2. Táblázat</a> | 
    <a href="?menu=3">3. Rendezett táblázat</a>
    <hr>

    <?php
    // ============================================================================
    // 4. MEGJELENÍTÉS A KIVÁLASZTOTT MENÜ ALAPJÁN (Switch)
    // ============================================================================
    switch ($menu) {

        // --- 1. MENÜPONT: 100 BEVITELI MEZŐ (FORM) ---
        case 1:
            echo '<form method="post">';
            echo '<h3>100 szám módosítása:</h3>';
            
            for ($i = 0; $i < 100; $i++) {
                // Generálunk 100 darab input mezőt, feltöltve a jelenlegi számokkal
                echo ($i + 1) . '. <input type="number" name="szam_' . $i . '" value="' . $szamok[$i] . '"><br>';
            }
            
            echo '<br><button type="submit" name="mentes">Mentés fájlba</button>';
            echo '</form>';
            break;

        // --- 2. MENÜPONT: 10x10-ES TÁBLÁZAT ---
        case 2:
            echo '<h3>A számok 10x10-es táblázatban:</h3>';
            echo '<table border="1" cellpadding="5">';
            
            for ($sor = 0; $sor < 10; $sor++) {
                echo '<tr>';
                for ($oszlop = 0; $oszlop < 10; $oszlop++) {
                    // Kiszámoljuk a tömb indexét (pl. 2. sor 3. oszlop = 23. elem)
                    $index = $sor * 10 + $oszlop;
                    echo '<td>' . $szamok[$index] . '</td>';
                }
                echo '</tr>';
            }
            
            echo '</table>';
            break;

        // --- 3. MENÜPONT: RENDEZETT TÁBLÁZAT ---
        case 3:
            echo '<h3>A számok növekvő sorrendben:</h3>';
            
            // A PHP beépített sort() függvényével sorba rakjuk a számokat
            sort($szamok);

            echo '<table border="1" cellpadding="5">';
            for ($sor = 0; $sor < 10; $sor++) {
                echo '<tr>';
                for ($oszlop = 0; $oszlop < 10; $oszlop++) {
                    $index = $sor * 10 + $oszlop;
                    echo '<td>' . $szamok[$index] . '</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
            break;
    }
    ?>

</body>
</html>