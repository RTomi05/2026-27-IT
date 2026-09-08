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
            <div>
                <form action="<?php echo $_SERVER["REQUEST_URI"];?>" method="post" enctype="multipart/form-data">
                <label for="">Név:</label>
                <input type="text" class="bg-success" id="nev" name="nev">
            </div>
            <div class="m-3">
            <label for="">Email:</label>
            <input type="text" class="bg-success" id="email" name="email">
            <input type="file" name="fajl" id="fajl">
            </div>
            <button type="submit" class="bg-success" onclick="bekuld()">Beküld</button><br>
            </form>

            <?php
            
            if(isset($_GET["nev"]))
                {
                    echo htmlspecialchars($_GET["nev"])."<br>";
                }

            if(isset($_GET["email"]))
                {
                    echo htmlspecialchars($_GET["email"])."<br>";
                }
            

            if(isset($_POST["nev"]))
                {
                    echo htmlspecialchars($_POST["nev"])."<br>";
                }

            if(isset($_POST["email"]))
                {
                    echo htmlspecialchars($_POST["email"])."<br>";
                }

            echo"<pre>";
            var_dump($_GET);
            var_dump($_POST);
            echo"</pre>";

            phpinfo(32);
            ?>

            <div class="text-wrap" style="margin: 130px; border: 10px yellow solid; width: 1000px;">
                <h1 class="text-start text-warning" id="ideNev">Név: </h1>
                <h1 class="text-start text-warning" id="ideEmail" >Email: </h1>
            </div>
        </div>
    </div>
    
    <script>
        function bekuld()
        {
            //console.log("jo");
            var nev = document.getElementById("nev").value;
            console.log(nev);
            document.getElementById("ideNev").innerHTML = "Név: "+ nev;
            var email = document.getElementById("email").value;
            console.log(email);
            document.getElementById("ideEmail").innerHTML = "Email: "+ email;
        }
    </script>
</body>
</html>