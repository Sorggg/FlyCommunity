<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Leggi l'username dell'utente dalla sessione
    $username = $_SESSION['username']; // Assicurati di avere una chiave 'username' nella sessione

    // Leggi i dati inviati dal form
    $newAereo = [
        'Id' => $_POST['id'],
        'Marca' => $_POST['marca'],
        'Modello' => $_POST['modello'],
        'Indirizzo' => $_POST['indirizzo'],
        'Username' => $_SESSION['username']
    ];

    // Carica i dati esistenti degli aerei dal file JSON
    $aereiFile = 'aerei.json';
    $aerei = json_decode(file_get_contents($aereiFile), true);

    // Aggiungi il nuovo aereo alla lista
    $aerei[] = $newAereo;

    // Scrivi i dati aggiornati nel file JSON
    file_put_contents($aereiFile, json_encode($aerei));

    echo "Nuovo aereo aggiunto con successo.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <title>Aggiungi Aereo</title>
</head>
<header>
        <nav>
            <a href="landing.php">Elenco Aerei</a>
            <a href="aggiungi_aereo.php">Aggiungi Aereo</a>
        </nav>
    </header>
<body>
    
    <h1>FlyCommunity</h1>
    <h2>Aggiungi Aereo</h2>
    <form method="post" action="">
        <label for="id">Id</label>
        <input type="text" name="id" id="id" required>
        <br><br>
        
        <label for="marca">Marca</label>
        <input type="text" name="marca" id="marca" required>
        <br><br>

        <label for="modello">Modello</label>
        <input type="text" name="modello" id="modello" required>
        <br><br>

        <label for="indirizzo">Indirizzo</label>
        <input type="text" name="indirizzo" id="indirizzo" required>

        <input type="submit" name="submit" value="Aggiungi Aereo">
    </form>
</body>

</html>
