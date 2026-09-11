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

            $celKonyvtar = "feltolt/";
            $celFile = $celKonyvtar . basename($_FILES["fajl"]["name"]);
            $feltoltesOk = 1;
            $kepTipus = strtolower(pathinfo($celFile,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if(isset($_FILES["fajl"]))
                {
                    $check = getimagesize($_FILES["fajl"]["tmp_name"]);
                    var_dump($check);
                    if($check !== false)
                        {
                            echo "File is an image - <br>" . $check["mime"] . ".";
                            $feltoltesOk = 1;
                        }
                    else
                        {
                            echo "File is not an image.";
                            $feltoltesOk = 0;
                        }

                    // Check file size
                    if ($_FILES["fajl"]["size"] > 900000) {
                    echo "Sorry, your file is too large.";
                    $feltoltesOk = 0;
                    }

                    // Allow certain file formats
                    if($kepTipus != "jpg" && $kepTipus != "png" && $kepTipus != "jpeg" && $kepTipus != "gif" )
                    {
                            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $feltoltesOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($feltoltesOk == 0)
                        {
                            echo "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                        }
                    else
                        {
                        if (move_uploaded_file($_FILES["fajl"]["tmp_name"], $celFile))
                            {
                        echo "The file ". htmlspecialchars( basename( $_FILES["fajl"]["name"])). " has been uploaded.";
                        meretez($celFile,"images/kicsi/" . basename($_FILES["fajl"]["name"]),50,50);
                        meretez($celFile,"images/nagy/" . basename($_FILES["fajl"]["name"]),500,500);
                            }
                        else
                            {
                        echo "Sorry, there was an error uploading your file.";
                            }
                        }
                }

            phpinfo(32);

            //https://www.php.net/manual/en/function.imagecopyresampled.php
            function meretez($forras,$cel,$szeles,$magas)
            {
                // The file
                $filename = $forras;

                // Set a maximum height and width
                $width = $szeles;
                $height = $magas;

                // Content type
                //header('Content-Type: image/jpeg');

                // Get new dimensions
                list($width_orig, $height_orig) = getimagesize($filename);

                $ratio_orig = $width_orig/$height_orig;

                if ($width/$height > $ratio_orig)
                {
                    $width = $height*$ratio_orig;
                }
                else
                {
                $height = $width/$ratio_orig;
                }

                // Resample
                $image_p = imagecreatetruecolor($width, $height);
                $image = imagecreatefromjpeg($filename);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                // Output
                imagejpeg($image_p, $cel, 100);
            }
            ?>

            <div class="text-wrap" style="margin: 130px; border: 10px yellow solid; width: 1000px;">
                <h1 class="text-start text-warning" id="ideNev">Név: </h1>
                <h1 class="text-start text-warning" id="ideEmail" >Email: </h1>
            </div>
        </div>
    </div>
    
    <script>
        //1. kép: 50 x 50
        //2. kép: 500 x 500
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