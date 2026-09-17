<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Űrlap</title>
</head>
<body>
    <div class="container">
        <div class="text-center">
            <h1 class="text-center">Űrlap</h1>
            <div class="m-3">
                <form action="<?php echo $_SERVER["REQUEST_URI"];?>" method="post" enctype="multipart/form-data">
                <label for="">Szám:</label>
                <input type="text" class="bg-success" id="szam1" name="szam1"><br>
                <label for="">Műveleti jel:</label>
                <input type="text" class="bg-success" id="jel" name="jel"><br>
                <label for="">Szám:</label>
                <input type="text" class="bg-success" id="szam2" name="szam2">
            </div>
            <div class="m-3">
            </div>
            <button type="submit" class="bg-success" onclick="bekuld()">Beküld</button><br>
            </form>

            <?php
            //$eredmeny = 0;
            if(isset($_POST["szam1"]) && isset($_POST["jel"]) && isset($_POST["szam2"]))
                {
                    if(is_numeric($_POST["szam1"]) && is_numeric($_POST["szam2"]))
                        {
                            //echo "Jók a számok";
                            $szam1 = $_POST["szam1"];
                            $jel = $_POST["jel"];
                            $szam2 = $_POST["szam2"];
                            if($jel == "+")
                                {
                                    $eredmeny = $szam1 + $szam2;
                                }
                            else if($jel == "-")
                                {
                                    $eredmeny = $szam1 - $szam2;
                                }

                            else if($jel == "*")
                                {
                                    $eredmeny = $szam1 * $szam2;
                                }

                            else if($jel == "/")
                                {
                                    $eredmeny = $szam1 / $szam2;
                                }
                            else
                                {
                                    echo "Valami nem jó!";
                                }
                            echo $szam1 . " " . $jel . " " . $szam2 . " " . "= " . $eredmeny;
                            //echo htmlspecialchars($_POST["szam1"])." ";
                            //$szam1 = $_POST("szam1");
                            //echo $szam1;

                            $fajl = fopen("szamEllenorzes.txt", "w");
                            $txt = $szam1 . "\t" . $jel . "\t" . $szam2 . "\t" . "=\t" . $eredmeny;
                            fwrite($fajl, $txt);
                            fclose($fajl);
                        }
                    
                }

            phpinfo(32);
            ?>
        </div>
    </div>
    
    <script>
        function bekuld()
        {

        }
    </script>
</body>
</html>