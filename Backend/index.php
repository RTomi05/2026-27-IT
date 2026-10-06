<?php
// =========================================================
// 1. ADATOK BETÖLTÉSE VAGY GENERÁLÁSA
// =========================================================
$szamok = [];

if (file_exists("save.txt")) {
    // Ha létezik a fájl, beolvassuk a sorait egy tömbbe
    $szamok = file("save.txt", FILE_IGNORE_NEW_LINES);
} else {
    // Ha még nincs fájl, generálunk 100 darab véletlen számot
    for ($i = 0; $i < 100; $i++) {
        $szamok[] = rand(0, 1000);
    }
}

// =========================================================
// 2. MENTÉS (Ha a felhasználó rákattintott a gombra)
// =========================================================
if (isset($_POST['elkuld'])) {
    $mentendo = "";
    for ($i = 0; $i < 100; $i++) {
        $mentendo .= $_POST["szam$i"] . "\n";
    }
    // Kiírjuk a fájlba az összes számot sornként
    file_put_contents("save.txt", $mentendo);

    // Oldal frissítése, hogy a mentett adatok látszódjanak
    header("Location: index.php?menu=1");
    exit();
}

// =========================================================
// 3. ROUTER / MENÜ (Melyik oldalon vagyunk?)
// =========================================================
$menu = $_GET['menu'] ?? 1; // Ha nincs megadva, az 1-es menüre lép
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>100 Szám Feladat</title>
    <!-- Bootstrap CSS a szép megjelenéshez -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

    <h1 class="mb-4">100 Szám Kezelése</h1>

    <!-- NAVIGÁCIÓS MENÜ -->
    <nav class="mb-4">
        <a href="index.php?menu=1" class="btn btn-outline-primary">1. Űrlap (Bekérés)</a>
        <a href="index.php?menu=2" class="btn btn-outline-primary">2. Táblázat</a>
        <a href="index.php?menu=3" class="btn btn-outline-primary">3. Rendezett tábla</a>
    </nav>

    <hr>

    <!-- ===================================================== -->
    <!-- 1. MENÜPONT: ŰRLAP (100 beviteli mező)                -->
    <!-- ===================================================== -->
    <?php if ($menu == 1): ?>
        <h2>Számok módosítása</h2>
        <form action="index.php?menu=1" method="post">
            <div class="row g-2">
                <?php for ($i = 0; $i < 100; $i++): ?>
                    <div class="col-md-1 col-3">
                        <label class="form-label mb-0 small"><?= ($i + 1) ?>.</label>
                        <input type="number" name="szam<?= $i ?>" value="<?= $szamok[$i] ?? 0 ?>" min="0" max="1000" class="form-control form-control-sm">
                    </div>
                <?php endfor; ?>
            </div>
            <button type="submit" name="elkuld" class="btn btn-success mt-4 p-2">Adatok mentése fájlba</button>
        </form>

    <!-- ===================================================== -->
    <!-- 2. MENÜPONT: 10x10 TÁBLÁZAT (Eredeti sorrend)          -->
    <!-- ===================================================== -->
    <?php elseif ($menu == 2): ?>
        <h2>Számok 10x10-es táblázatban</h2>
        <table class="table table-bordered text-center mt-3">
            <tbody>
                <?php for ($sor = 0; $sor < 10; $sor++): ?>
                    <tr>
                        <?php for ($cella = 0; $cella < 10; $cella++): ?>
                            <td><?= $szamok[$sor * 10 + $cella] ?></td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>

    <!-- ===================================================== -->
    <!-- 3. MENÜPONT: 10x10 TÁBLÁZAT (Rendezett sorrend)        -->
    <!-- ===================================================== -->
    <?php elseif ($menu == 3): ?>
        <h2>Számok növekvő sorrendben</h2>
        <?php 
            $rendezett = $szamok; 
            sort($rendezett); // Tömb sorba rendezése növekvőleg
        ?>
        <table class="table table-bordered table-striped text-center mt-3">
            <tbody>
                <?php for ($sor = 0; $sor < 10; $sor++): ?>
                    <tr>
                        <?php for ($cella = 0; $cella < 10; $cella++): ?>
                            <td><?= $rendezett[$sor * 10 + $cella] ?></td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>
</html>