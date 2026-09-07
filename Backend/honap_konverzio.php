<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hónap konverzió</title>
</head>
<body>
    <?php
    function honapNeve()
    {
        //echo "szia";
        $honap = rand(1,13);
         //$honap = "Béla";
    switch ($honap) {
        case 1:
            echo "<h1>"."Január"."</h1>";
            break;
            case 2:
            echo "<h1>"."Február"."</h1>";
            break;
            case 3:
            echo "<h1>"."Március"."</h1>";
            break;
            case 4:
            echo "<h1>"."Április"."</h1>";
            break;
            case 5:
            echo "<h1>"."Május"."</h1>";
            break;
            case 6:
            echo "<h1>"."Június"."</h1>";
            break;
            case 7:
            echo "<h1>"."Július"."</h1>";
            break;
            case 8:
            echo "<h1>"."Augusztus"."</h1>";
            break;
            case 9:
            echo "<h1>"."Szeptember"."</h1>";
            break;
            case 10:
            echo "<h1>"."Október"."</h1>";
            break;
            case 11:
            echo "<h1>"."November"."</h1>";
            break;
            case 12:
            echo "<h1>"."December"."</h1>";
            break;
        default:
            echo "<h1>"."Nincs ilyen hónap."."</h1>";
        }

        switch ($honap) {
        case 1:
            echo "<h1>"."Január"."</h1>";
            break;
            case 2:
            echo "<h1>"."Február"."</h1>";
            break;
            case 3:
            echo "<h1>"."Március"."</h1>";
            break;
            case 4:
            echo "<h1>"."Április"."</h1>";
            break;
            case 5:
            echo "<h1>"."Május"."</h1>";
            break;
            case 6:
            echo "<h1>"."Június"."</h1>";
            break;
            case 7:
            echo "<h1>"."Július"."</h1>";
            break;
            case 8:
            echo "<h1>"."Augusztus"."</h1>";
            break;
            case 9:
            echo "<h1>"."Szeptember"."</h1>";
            break;
            case 10:
            echo "<h1>"."Október"."</h1>";
            break;
            case 11:
            echo "<h1>"."November"."</h1>";
            break;
            case 12:
            echo "<h1>"."December"."</h1>";
            break;
        default:
            echo "<h1>"."Nincs ilyen hónap."."</h1>";
        }
        //$honap2 = rand(1,13);

        $text = match($honap) {
        1 => "<h1>"."Január"."</h1>",
        2 => "<h1>"."Február"."</h1>",
        3 => "<h1>"."Március"."</h1>",
        4 => "<h1>"."Április"."</h1>",
        5 => "<h1>"."Május"."</h1>",
        6 => "<h1>"."Június"."</h1>",
        7 => "<h1>"."Július"."</h1>",
        8 => "<h1>"."Augusztus"."</h1>",
        9 => "<h1>"."Szeptember"."</h1>",
        10 => "<h1>"."Október"."</h1>",
        11 => "<h1>"."November"."</h1>",
        12 => "<h1>"."December"."</h1>",
        default => "<h1>"."Nincs ilyen hónap"."</h1>",
        };

        echo $text;
    }
    
        honapNeve();
?>
</body>
</html>