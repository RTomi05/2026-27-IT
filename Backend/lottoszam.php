<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Lottószámok</title>
    <style>
        input{
            margin: 20px;
        }
        button{
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="col-lg-12" style="text-align: center;">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
            <label for="">A hét száma:</label>
            <input type="text" class="bg-info" name="het"><br>
            <label for="">1. szám:</label>
            <input type="text" class="bg-info" name="elso"><br>
            <label for="">2. szám:</label>
            <input type="text" class="bg-info" name="masodik"><br>
            <label for="">3. szám</label>
            <input type="text" class="bg-info" name="harmadik"><br>
            <label for="">4. szám:</label>
            <input type="text" class="bg-info" name="negyedik"><br>
            <label for="">5. szám:</label>
            <input type="text" class="bg-info" name="otodik"><br>
            <button type="submit" class="bg-success">Beküldés</button>
            <button onclick="eddigiek()" class="bg-warning">Összes adat megjelenítése</button>
            </form>
        </div>
    </div>

<?php

?>

    <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
            // collect value of input field
            if(isset($_POST['elso']))
                {
                    $elso = $_POST['elso'];
                    echo $elso;
                    $masodik = $_POST['masodik'];
                    $harmadik = $_POST['harmadik'];
                    $negyedik = $_POST['negyedik'];
                    $otodik = $_POST['harmadik'];
                }
            }
            //$elso = $_POST["elso"];
            //echo $elso;
        var_dump(isset($elso)); 
        phpinfo(32);
        

        $fajl = fopen("lotto.txt", "w");
        $txt = "Ide jönnek a számok";
        fwrite($fajl, $elso);
        fclose($fajl);
    ?>
    <script>
        function eddigiek()
        {

        }
    </script>
</body>
</html>