<?php
function abrazol()
{
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['adatok'][] = [
            'nev' => $_POST['nev'],
            'datum' => $_POST['datum'],
            'becenev' => $_POST['becenev']
        ];
    }
    $szoveg = '<table class="table">';
    $szoveg .= '<tr><th>Név</th><th>Születési dátum</th><th>Becenév</th></tr>';

    foreach ($_SESSION['adatok'] ?? [] as $adat) {
        $szoveg .= '<tr>';
        $szoveg .= '<td>' . htmlspecialchars($adat['nev']) . '</td>';
        $szoveg .= '<td>' . htmlspecialchars($adat['datum']) . '</td>';
        $szoveg .= '<td>' . htmlspecialchars($adat['becenev']) . '</td>';
        $szoveg .= '</tr>';
    }
    $szoveg .= '</table>';
    //session_destroy();
    return $szoveg;
}
?>