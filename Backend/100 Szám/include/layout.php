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
    <?php
    /*
        100 szám bekérése, menüpontra jöjjenek elő
        3 lapból álljon az oldal, menüvel lehessen választani
        1. oldal: bekérés
        2. oldal: bekért számok 10*10-es táblázata -> ha nincs -> Nincs szám
        3. oldal: ugyanezek a számok növekvő sorrendben rendezve
        Ha nincs szám, válasszon 100 randomot
        Ha volt bevitt adat, azok legyenek belerakva
    */
    ?>
    <div class="container">
        <div class="row">
            <header class="col-12"><h1>100 szám</h1></header>
            <?php include("include/navbar.php");?>
            <div class="col-12"><?php echo $mainContent;?></div>
        </div>
    </div>
</body>
</html>