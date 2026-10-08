<?php
//4 oldalból álló portál
// Bootstrap formázás
//egyforma szerkezet
//baloldalt legyen a menüsáv
// 1. oldal: egy nagy kép (https://picsum.photos/), cím
// 2. oldal: hosszabb szöveg, 3-4 kép, beszúrva a szövegbe
// 3. oldal: űrlap, ahol bekérünk adatokat (név, többsoros üzenet) - a bekérés adatait mentse el egy fájlba + dátum és idő (magyar időzóna)
// 4. oldal: táblázatban megjeleníteni időrendben az üzeneteket

require_once("include/functions.php");
include_once("include/router.php");
include_once("include/layout.php");
?>