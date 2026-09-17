<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Háromszög</title>
    <style>
        input{
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center">
            <h1 style="margin: 20px;" class="text-center">Háromszög oldalai</h1>
            <div class="m-3">
                <form action="<?php echo $_SERVER["REQUEST_URI"];?>" method="post" enctype="multipart/form-data">
                <label">a oldal:</label>
                <input type="text" class="" id="aOldal" name="aOldal"><br>
                <label>b oldal:</label>
                <input type="text" class="" id="bOldal" name="bOldal"><br>
                <label>c oldal:</label>
                <input type="text" class="" id="cOldal" name="cOldal">
            </div>
            <div class="m-3">
            </div>
            <button type="submit" class="bg-info">Ellenőrzés</button><br>
            </form>
        <?php
            if(isset($_POST["aOldal"]) && isset($_POST["bOldal"]) && isset($_POST["cOldal"]))
                {
                    //echo "ezjo";
                    if(is_numeric($_POST["aOldal"]) && is_numeric($_POST["bOldal"]) && is_numeric($_POST["cOldal"]))
                        {
                            $a = $_POST["aOldal"];
                            $b = $_POST["bOldal"];
                            $c = $_POST["cOldal"];
                            $fajl = fopen("haromszog.txt", "a");
                            //echo "Jók a számok";
                            if(($a + $b) > $c && ($a + $c) > $b && ($b + $c) > $a)
                                {
                                    //echo "Jó a háromszög";
                                    $txt = "a oldal: " . $a . ", b oldal: " . $b . ", c oldal: " . $c . "\t A háromszög megszerkeszthető. \n";
                                    fwrite($fajl, $txt);
                                }
                            else
                                {
                                    $txt = "a oldal: " . $a . ", b oldal: " . $b . ", c oldal: " . $c . "\t A háromszög nem szerkeszthető meg. \n";
                                    fwrite($fajl, $txt);
                                }
                            fclose($fajl);
                        }
                    }
        ?>
        </div>
    </div>
</body>
</html>