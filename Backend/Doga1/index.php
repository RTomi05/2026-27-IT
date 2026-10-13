
<!DOCTYPE html>
<html lang="hu">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container">

    <h1 class="mb-4">Helpdesk - hibajegyek</h1>

    <div class="card mb-4">
        <div class="card-header">Környezeti adatok</div>
        <div class="card-body">
            <p>Látogató IP-címe: <b><?= $_SERVER['REMOTE_ADDR'] ?></b></p>
            <p>Kérés ideje: <b><?= date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) ?></b></p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Új hibajegy</div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Bejelentő neve</label>
                    <input type="text" name="nev" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hiba / Üzenet leírása</label>
                    <textarea name="uzenet" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Hibajegy leadása</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Eddigi hibajegyek</div>
        <div class="card-body">
            <ol class="list-group list-group-numbered">
                <?php
                if (file_exists('hibak.txt')) {
                    foreach (file('hibak.txt') as $sor) {
                        echo '<li class="list-group-item">' . $sor . '</li>';
                    }
                }
                ?>
            </ol>
        </div>
    </div>

</body>
</html>

<?php
if (!empty($_POST['nev'])) {
    $sor = "[" . date('Y-m-d H:i:s') . "] | Név: " . $_POST['nev'] . " | Üzenet: " . $_POST['uzenet'] . PHP_EOL;
    file_put_contents('hibak.txt', $sor, FILE_APPEND);
}
?>