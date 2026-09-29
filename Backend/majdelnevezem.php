<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class=""col-12>
            <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]);?>" method="post" enctype="multipart/form-data">
            <label for="">Add meg az együttes nevét!</label>
            <input type="text" id="nev" name="nev" class="input-group mb-4">
            <input type="submit" value="Küldés" class="btn btn-info">
            </form>
        </div>
    </div>
    <script>
        //egy mezős űrlap (együttes neve)
        //eltárolni a fájl végére az aktuális dátum idővel
        //függvény, ami véletlenszerűen kiválaszt 5 névből, majd eltárolja a fájlban (random voks)

    </script>

    <?php
    phpinfo(32);

    $egyuttes = $_POST["nev"];
    echo $egyuttes . " - " . date("Y/m/d") . " - " . date("H:i:s");

    $fajl = fopen("fajl.txt", "a") or die("Unable to open file!");
    $txt = $egyuttes . " - " . date("Y/m/d") . " - " . date("H:i:s") . "\n";
    fwrite($fajl, $txt);
    fclose($fajl);
    ?>
</body>
</html>