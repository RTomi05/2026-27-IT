<?php
    echo "<h1>Belépve, " . $_SESSION["user"] . "</h1>";
            echo '<a href="' . $url . '">katt ide!</a>';
            echo '
            <form method="post" action="' . $url . '">
                <button type="submit" name="kilepes">Kilépés</button>
            </form>';
?>