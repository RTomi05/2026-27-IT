<?php include("include/header.php");?>
<?php include("include/navbar.php");?>
<?php include("include/main.php");?>
<?php include("include/footer.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Útépítés</title>
</head>
<body>
    <div class="container text-center">
       
        <?php echo $header;?>
        <div class="row">
            <?php echo $navbar;?>
        </div>
        <?php echo $main;?>
        <?php echo $footer;?> 
        
    </div>
</body>
</html>