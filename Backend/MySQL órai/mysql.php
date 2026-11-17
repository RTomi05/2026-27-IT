<?php
/*
objektum-orientált mysqli használata
*/

// 1) Adatbázis kapcsolódási adatok
// Ezeket a localhost, az XAMPP beállításaihoz igazítják.
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proba2026";

// 2) Kapcsolat létrehozása
// Ha a kapcsolat sikertelen, a connect_error tartalmazza a hiba leírását.
$conn = new mysqli($servername, $username, $password, $dbname);

// 3) Kapcsolat ellenőrzése
// Ha a kapcsolat nem jött létre, a script leáll, és megjeleníti a hibát.
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

echo "Sikeres kapcsolódás az adatbázishoz!<br>";

// 4) Tábla létrehozása, ha még nem létezik
// A táblanév: MyGuests
// A mezők:
// - id: egyedi azonosító, automatikusan nő
// - firstname: vezetéknév (kötelező)
// - lastname: keresztnév (kötelező)
// - email: e-mail cím (opcionális)
// - reg_date: regisztráció dátuma, alapértelmezetten aktuális idő
$sql = "CREATE TABLE IF NOT EXISTS MyGuests (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// A query() metódus lefuttatja az SQL utasítást.
// CREATE TABLE esetén a visszatérési érték TRUE, ha sikeres.
if ($conn->query($sql) === TRUE) {
    echo "A MyGuests tábla létrejött, vagy már létezett.<br>";
} else {
    echo "Hiba a tábla létrehozásakor: " . $conn->error . "<br>";
    $conn->close();
    exit;
}

// 5) Adat beszúrása a táblába
// A VALUES részben például egy ember adatait adjuk hozzá.
$sqlInsert = "INSERT INTO MyGuests (firstname, lastname, email)
              VALUES ('John', 'Doe', 'john@example.com')";

$sqlDelete = "DELETE FROM MyGuests WHERE id = 2";

if ($conn->query($sqlInsert) === TRUE) {
    echo "Az adat sikeresen bekerült a táblába.<br>";
} else {
    echo "Hiba az adat beszúrásakor: " . $conn->error . "<br>";
}

if ($conn->query($sqlDelete) === TRUE) {
    echo "Az adat sikeresen törlődött a táblából.<br>";
} else {
    echo "Hiba az adat törlésekor: " . $conn->error . "<br>";
}

// 6) Adatok lekérdezése
// Ezzel a lekérdezéssel az összes rekordot olvassuk ki a táblából.
// A CONCAT(...) SQL függvény a vezetéknév és keresztnév összefűzésére szolgál.
$sqlSelect = "SELECT id, firstname, lastname, CONCAT(firstname, ' ', lastname) AS fullname FROM MyGuests";

$result = $conn->query($sqlSelect);

// 7) Eredmény feldolgozása
// fetch_assoc() soronként adja vissza a rekordokat asszociatív tömbként.
// Pl.: $row['firstname'] => "John"
if ($result->num_rows > 0) {
    echo "<h3>Adatok a MyGuests táblából:</h3>";

    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]
           . " | Név: " . $row["firstname"] . " " . $row["lastname"]
           . " | Teljes név: " . $row["fullname"]
           . "<br>";
    }
} else {
    echo "Nincsenek adatok a táblában.<br>";
}

// 8) A kapcsolat lezárása
// Fontos, hogy a kapcsolat végét lezárjuk, miután végeztünk a műveletekkel.
$conn->close();

// -------------------------------------------------------------------
// HÁTTÉRINFORMÁCIÓ:
// -------------------------------------------------------------------
// - mysqli: a MySQL adatbázis PHP-s kezeli.
// - query(): SQL utasítás futtatása.
// - fetch_assoc(): soronkénti adatolvasás asszociatív tömbben.
// - set_charset("utf8mb4"): helyes karakterkészlet beállítása magyar szövegekhez.
// - IF NOT EXISTS: megakadályozza a tábla duplázását.
// -------------------------------------------------------------------
?>